<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SalesDataService;

class AdminDashboardController extends Controller
{
    protected $salesDataService;

    public function __construct(SalesDataService $salesDataService)
    {
        $this->salesDataService = $salesDataService;
    }
    
    public function index()
    {
        $salesDataArray = $this->salesDataService->getMonthlySalesData();
        $monthlySalesArray = $this->salesDataService->getMonthlyOrderQuantities();

        return view('admin.dashboard', compact('salesDataArray', 'monthlySalesArray'));
    }
}
