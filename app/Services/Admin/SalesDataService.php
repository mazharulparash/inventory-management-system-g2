<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class SalesDataService
{
    /**
     * Get sales data grouped by month.
     *
     * @return array
     */
    public function getMonthlySalesData()
    {
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

        return [
            'labels' => $salesData->keys()->toArray(),
            'data' => $salesData->values()->toArray(),
        ];
    }

    /**
     * Get the total quantities sold each month.
     *
     * @return array
     */
    public function getMonthlyOrderQuantities()
    {
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

        return [
            'labels' => $monthlySales->keys()->toArray(),
            'data' => $monthlySales->values()->toArray(),
        ];
    }
}