<?php

namespace Aci\EmployeeReports\Facades;

use Illuminate\Support\Facades\Facade;

class EmployeeReports extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'employeereports';
    }
}
