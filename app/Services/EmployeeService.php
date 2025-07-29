<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function getAll()
    {
        return Employee::with('team.organization')->get();
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function getById(Employee $employee): Employee
    {
        return $employee->load('team.organization');
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee;
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
    }
}
