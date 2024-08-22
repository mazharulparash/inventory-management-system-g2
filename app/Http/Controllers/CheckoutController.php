<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'payment_method_id' => 'required|string',
        ]);

        // Calculate the total amount
        $cart = session()->get('cart', []);
        $totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Set your Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodId = $request->input('payment_method_id');

        try {
            // Create a PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Amount in cents
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('checkout.confirmation', ['order' => 'PLACEHOLDER']), // Placeholder
            ]);

            // Handle the response
            if ($paymentIntent->status === 'requires_action' || $paymentIntent->status === 'requires_source_action') {
                // Redirect to the URL provided by Stripe
                return redirect()->away($paymentIntent->next_action->redirect_to_url->url);
            } elseif ($paymentIntent->status === 'succeeded') {
                // Create the order if the payment is successful
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'postal_code' => $request->input('postal_code'),
                    'country' => $request->input('country'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'total_amount' => $totalAmount,
                    'status' => 'completed',
                ]);

                foreach ($cart as $id => $details) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $id,
                        'name' => $details['name'],
                        'price' => $details['price'],
                        'quantity' => $details['quantity'],
                    ]);

                    $product = Product::find($id);
                    if ($product) {
                        $product->reduceStock($details['quantity']);
                    }
                }

                session()->forget('cart');

                return redirect()->route('checkout.confirmation', ['order' => $order->id])
                    ->with('success', 'Order placed successfully!');
            } else {
                return redirect()->back()->with('error', 'Payment failed.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId);
        return view('checkout.confirmation', compact('order'));
    }
}
