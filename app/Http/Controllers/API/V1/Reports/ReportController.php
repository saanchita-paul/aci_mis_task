<?php

namespace App\Http\Controllers\API\V1\Reports;

use App\Http\Controllers\Controller;
use App\Services\Reports\EmployeeReportService;
use App\Services\Reports\ReportService;

class ReportController extends Controller
{

    public function stats()
    {
        $reportService = new ReportService();
        $stats = $reportService->getStats();

        return response()->json($stats);
    }


    public function downloadReport()
    {
        $employeeReportService = new EmployeeReportService();
        return $employeeReportService->generatePdfReport();
    }
}
