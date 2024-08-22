<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Display a list of orders for the authenticated user
    public function index(Request $request)
    {
        // Retrieve the selected status from the request
        $status = $request->input('status');

        // Fetch orders, optionally filtering by status
        $ordersQuery = Order::query();

        if ($status) {
            $ordersQuery->where('status', $status);
        }

        // Paginate the results
        $orders = $ordersQuery->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Display the details of a specific order
    public function show($id)
    {
        $order = Order::where('id', $id)->with('orderItems')->firstOrFail();
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'status' => 'required',
        ]);

        $order = Order::findOrFail($id);

        // Update the order status
        $order->status = $request->status;
        $order->save();

        // Redirect back with a success message
        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }
}
