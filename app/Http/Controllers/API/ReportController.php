<?php

namespace App\Http\Controllers\API;

use Aci\EmployeeReports\Facades\EmployeeReports;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Team;

class ReportController extends Controller
{
    public function stats() {
        $teams = Team::withAvg('employees', 'salary')->get();
        $orgs = Organization::withCount('employees')->get();

        return response()->json([
            'team_avg_salaries' => $teams,
            'org_employee_counts' => $orgs
        ]);
    }

    public function downloadReport()
    {
        $employees = Employee::with(['team.organization'])->get();

        $pdf = EmployeeReports::generate($employees);

        return $pdf->download('employee-report.pdf');
    }
}
