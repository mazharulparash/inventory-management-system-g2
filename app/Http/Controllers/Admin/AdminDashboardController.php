<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Example: Dynamically retrieve sales data for each month
        $salesData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total_sales')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [date('F', mktime(0, 0, 0, $item->month, 10)) => $item->total_sales];
        });

        // Separate labels and data for the chart
        $labels = $salesData->keys()->toArray();
        $data = $salesData->values()->toArray();

        // Prepare the salesData array
        $salesDataArray = [
            'labels' => $labels,
            'data' => $data,
        ];

        // You can add more data for different charts if needed
        // Example: Monthly order count
        // Retrieve the total quantities sold each month
        $monthlySales = OrderItem::select(
            DB::raw('MONTH(orders.created_at) as month'),
            DB::raw('SUM(order_items.quantity) as total_quantity')
        )
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->mapWithKeys(function ($item) {
            return [date('F', mktime(0, 0, 0, $item->month, 10)) => $item->total_quantity];
        });

        // Separate labels and data for the monthly orders chart
        $monthlySalesLabels = $monthlySales->keys()->toArray();
        $monthlySalesData = $monthlySales->values()->toArray();

        // Prepare the monthlySales array
        $monthlySalesArray = [
            'labels' => $monthlySalesLabels,
            'data' => $monthlySalesData,
        ];

        // Pass the data to the view
        return view('admin.dashboard', compact('salesDataArray', 'monthlySalesArray'));
    }
}
