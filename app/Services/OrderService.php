<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder($orderData, $cart)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $orderData['name'],
            'address' => $orderData['address'],
            'city' => $orderData['city'],
            'postal_code' => $orderData['postal_code'],
            'country' => $orderData['country'],
            'email' => $orderData['email'],
            'phone' => $orderData['phone'],
            'total_amount' => $orderData['totalAmount'],
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

        return $order;
    }
}
