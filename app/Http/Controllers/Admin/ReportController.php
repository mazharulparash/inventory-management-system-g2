<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales()
    {
        return view('admin.reports.sales');
    }

    public function productSales()
    {
        return view('admin.reports.product-sales');
    }

    public function downloadSalesReport(Request $request)
    {
        // Validate input
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'nullable', // Add validation for status
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status'); // Get the status from the request

        // Fetch orders within the date range and filter by status if provided
        $ordersQuery = Order::with('orderItems')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($status) {
            $ordersQuery->where('status', $status); // Apply the status filter
        }

        $orders = $ordersQuery->get();

        // Calculate total sales
        $totalSales = $orders->sum('total_amount');

        // Generate the PDF
        $pdf = PDF::loadView('admin.reports.pdf.sales', compact('orders', 'startDate', 'endDate', 'totalSales', 'status'));

        // Return the PDF as a download
        return $pdf->download('sales_report_' . $startDate . '_to_' . $endDate . '.pdf');
    }

    public function downloadProductSalesReport(Request $request)
    {
        // Validate input
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch order items within the date range and group by product
        $productSales = OrderItem::select('product_id', 'name')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(quantity * price) as total_sales')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('product_id', 'name')
            ->get();

        // Calculate total quantities and sales
        $grandTotalQuantity = $productSales->sum('total_quantity');
        $grandTotalSales = $productSales->sum('total_sales');

        // Generate the PDF
        $pdf = PDF::loadView('admin.reports.pdf.product-sales', compact('productSales', 'startDate', 'endDate', 'grandTotalQuantity', 'grandTotalSales'));

        // Return the PDF as a download
        return $pdf->download('product_sales_report_' . $startDate . '_to_' . $endDate . '.pdf');
    }
}
