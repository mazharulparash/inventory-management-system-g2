<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\PDFService;
use App\Services\Admin\ProductSalesReportService;
use App\Services\Admin\SalesReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $salesReportService;
    protected $productSalesReportService;
    protected $pdfService;

    public function __construct(
        SalesReportService $salesReportService,
        ProductSalesReportService $productSalesReportService,
        PDFService $pdfService
    ) {
        $this->salesReportService = $salesReportService;
        $this->productSalesReportService = $productSalesReportService;
        $this->pdfService = $pdfService;
    }

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
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'nullable',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $salesData = $this->salesReportService->getSalesReportData($startDate, $endDate, $status);

        return $this->pdfService->generateSalesReportPDF(
            'admin.reports.pdf.sales',
            array_merge($salesData, compact('startDate', 'endDate', 'status')),
            'sales_report_' . $startDate . '_to_' . $endDate . '.pdf'
        );
    }

    public function downloadProductSalesReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $productSalesData = $this->productSalesReportService->getProductSalesReportData($startDate, $endDate);

        return $this->pdfService->generateSalesReportPDF(
            'admin.reports.pdf.product-sales',
            array_merge($productSalesData, compact('startDate', 'endDate')),
            'product_sales_report_' . $startDate . '_to_' . $endDate . '.pdf'
        );
    }
}
