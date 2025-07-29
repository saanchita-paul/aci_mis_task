<?php

namespace App\Http\Controllers\API\V1\Employees;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{

    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        return $this->employeeService->getAll();
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = $this->employeeService->create($request->validated());
        return response()->json($employee, 201);
    }

    public function show(Employee $employee)
    {
        return $this->employeeService->getById($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee = $this->employeeService->update($employee, $request->validated());
        return response()->json($employee);
    }

    public function destroy(Employee $employee)
    {
        $this->employeeService->delete($employee);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
