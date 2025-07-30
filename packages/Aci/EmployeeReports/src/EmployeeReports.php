<?php

namespace Aci\EmployeeReports;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Employee;

class EmployeeReports
{
    public function generate($employees, array $options = [])
    {
        $view = $options['view'] ?? 'employeereports::report';
        return Pdf::loadView($view, ['employees' => $employees]);
    }
}
