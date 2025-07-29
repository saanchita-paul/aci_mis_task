<?php

namespace App\Http\Controllers\API\V1\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeImportRequest;
use App\Services\EmployeeImportService;

class EmployeeImportController extends Controller
{

    protected $employeeImportService;

    public function __construct(EmployeeImportService $employeeImportService)
    {
        $this->employeeImportService = $employeeImportService;
    }

    public function import(EmployeeImportRequest $request)
    {
        $this->employeeImportService->import($request->file('file'), $request->user());

        return response()->json(['message' => 'Employee import queued']);
    }

}
