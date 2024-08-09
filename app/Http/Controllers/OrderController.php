<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Display a list of orders for the authenticated user
    public function index()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->with('orderItems')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Display the details of a specific order
    public function show($id)
    {
        $userId = Auth::id();
        $order = Order::where('id', $id)->where('user_id', $userId)->with('orderItems', 'user')->firstOrFail();
        return view('orders.show', compact('order'));
    }
}
