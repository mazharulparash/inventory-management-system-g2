<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Display a list of orders for the authenticated user
    public function index()
    {
        $orders = Order::with('orderItems')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Display the details of a specific order
    public function show($id)
    {
        $order = Order::where('id', $id)->with('orderItems')->firstOrFail();
        return view('admin.orders.show', compact('order'));
    }
}
