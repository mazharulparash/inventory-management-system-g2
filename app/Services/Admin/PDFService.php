<?php

namespace App\Services\Admin;

use PDF;

class PDFService
{
    public function generateSalesReportPDF($view, $data, $fileName)
    {
        $pdf = PDF::loadView($view, $data);
        return $pdf->download($fileName);
    }
}
