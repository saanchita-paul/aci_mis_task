<?php

namespace App\Services\Reports;

use Aci\EmployeeReports\Facades\EmployeeReports;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Organization;

class EmployeeReportService
{
    public function generatePdfReport()
    {
        $employees = Employee::with(['team.organization'])->get();
        $pdf = EmployeeReports::generate($employees);

        return $pdf->download('employee-report.pdf');

    }
}
