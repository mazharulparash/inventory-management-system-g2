<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;

class CheckoutController extends Controller
{
    protected $paymentService;
    protected $orderService;
    protected $cartService;

    public function __construct(
        PaymentService $paymentService,
        OrderService $orderService,
        CartService $cartService
    ) {
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
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

        // Get cart and calculate total amount
        $cart = $this->cartService->getCart();
        $totalAmount = $this->cartService->calculateTotalAmount($cart);

        $paymentMethodId = $request->input('payment_method_id');

        try {
            // Create a PaymentIntent
            $paymentIntent = $this->paymentService->createPaymentIntent($totalAmount, $paymentMethodId);

            // Handle the response
            if ($paymentIntent->status === 'requires_action' || $paymentIntent->status === 'requires_source_action') {
                // Redirect to the URL provided by Stripe
                return redirect()->away($paymentIntent->next_action->redirect_to_url->url);
            } elseif ($paymentIntent->status === 'succeeded') {
                // Create the order if the payment is successful
                $orderData = $request->only(['name', 'address', 'city', 'postal_code', 'country', 'email', 'phone']);
                $orderData['totalAmount'] = $totalAmount;
                $order = $this->orderService->createOrder($orderData, $cart);

                $this->cartService->clearCart();

                return redirect()->route('checkout.confirmation', ['order' => $order->id])
                    ->with('success', 'Order placed successfully!');
            } else {
                return redirect()->back()->with('error', 'Payment failed.');
            }
        } catch (ApiErrorException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmation($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId);
        return view('checkout.confirmation', compact('order'));
    }
}
