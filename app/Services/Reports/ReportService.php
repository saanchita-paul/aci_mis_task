<?php

namespace App\Services\Reports;

use App\Models\Team;
use App\Models\Organization;

class ReportService
{
    public function getStats(): array
    {
        $teams = Team::withAvg('employees', 'salary')->get();
        $orgs = Organization::withCount('employees')->get();

        return [
            'team_avg_salaries' => $teams,
            'org_employee_counts' => $orgs
        ];
    }
}
