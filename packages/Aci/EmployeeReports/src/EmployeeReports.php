<?php

namespace Aci\EmployeeReports;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee;

class EmployeeReports
{
    /**
     * Generate PDF report for given employees
     *
     * @param \Illuminate\Support\Collection|array $employees
     * @param array $options (optional) customization options
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generate($employees, array $options = [])
    {
        // Customize view and options if needed
        $view = $options['view'] ?? 'employeereports::report';

        return Pdf::loadView($view, ['employees' => $employees]);
    }
}
