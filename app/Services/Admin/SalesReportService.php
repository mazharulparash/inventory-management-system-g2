<?php

namespace App\Services\Admin;

use App\Models\Order;

class SalesReportService
{
    public function getSalesReportData($startDate, $endDate, $status = null)
    {
        $ordersQuery = Order::with('orderItems')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($status) {
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->get();

        $totalSales = $orders->sum('total_amount');

        return compact('orders', 'totalSales');
    }
}
