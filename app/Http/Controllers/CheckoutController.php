<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        // Calculate the total amount
        $cart = session()->get('cart', []);
        $totalAmount = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(), // Optional, if user is logged in
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'country' => $request->input('country'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'name' => $details['name'],
                'price' => $details['price'],
                'quantity' => $details['quantity'],
            ]);

            // Update product stock
            $product = Product::find($id);
            if ($product) {
                $product->reduceStock($details['quantity']);
            }
        }

        // Clear the cart
        session()->forget('cart');

        // Redirect to a confirmation or thank you page
        return redirect()->route('checkout.confirmation', ['order' => $order->id])
            ->with('success', 'Order placed successfully!');
    }

    public function confirmation($orderId)
    {
        $order = Order::with('orderItems')->findOrFail($orderId);
        return view('checkout.confirmation', compact('order'));
    }
}
