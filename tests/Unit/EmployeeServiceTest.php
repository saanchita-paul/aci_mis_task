<?php

namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Team;
use App\Services\EmployeeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EmployeeService $employeeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->employeeService = new EmployeeService();
    }

    public function test_create_employee()
    {
        $team = Team::factory()->create();

        $data = [
            'name' => 'John Doe',
            'salary' => 75000,
            'team_id' => $team->id,
            'start_date' => '2023-01-01',
        ];

        $employee = $this->employeeService->create($data);

        $this->assertInstanceOf(Employee::class, $employee);
        $this->assertDatabaseHas('employees', ['name' => 'John Doe']);
    }

    public function test_update_employee()
    {
        $employee = Employee::factory()->create([
            'name' => 'Aaron O\'Keefe',
            'salary' => 34928,
            'start_date' => '2023-01-01',
        ]);

        $updatedData = [
            'name' => 'Updated Name',
            'salary' => 85000,
        ];

        $result = $this->employeeService->update($employee, $updatedData);

        $this->assertInstanceOf(Employee::class, $result);
        $this->assertEquals('Updated Name', $result->name);
        $this->assertEquals(85000, $result->salary);

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Name',
            'salary' => 85000,
        ]);
    }


    public function test_delete_employee()
    {
        $employee = Employee::factory()->create();

        $this->employeeService->delete($employee);

        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }
}
