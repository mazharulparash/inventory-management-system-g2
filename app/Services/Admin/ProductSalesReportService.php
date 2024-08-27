<?php

namespace App\Services\Admin;

use App\Models\OrderItem;

class ProductSalesReportService
{
    public function getProductSalesReportData($startDate, $endDate)
    {
        $productSales = OrderItem::select('product_id', 'name')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(quantity * price) as total_sales')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('product_id', 'name')
            ->get();

        $grandTotalQuantity = $productSales->sum('total_quantity');
        $grandTotalSales = $productSales->sum('total_sales');

        return compact('productSales', 'grandTotalQuantity', 'grandTotalSales');
    }
}
