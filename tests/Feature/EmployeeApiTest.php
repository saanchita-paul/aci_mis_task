<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');
    }

    public function test_index_returns_all_employees()
    {
        $this->authenticate();
        Employee::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/employees');

        $response->assertOk()->assertJsonCount(3);
    }

    public function test_store_creates_employee()
    {
        $this->authenticate();
        $team = Team::factory()->create();

        $payload = [
            'name' => 'John Doe',
            'salary' => 5000,
            'team_id' => $team->id,
            'start_date' => now()->toDateString(),
        ];

        $response = $this->postJson('/api/v1/employees', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'John Doe']);

        $this->assertDatabaseHas('employees', ['name' => 'John Doe']);
    }

    public function test_show_returns_single_employee()
    {
        $this->authenticate();
        $employee = Employee::factory()->create();

        $response = $this->getJson("/api/v1/employees/{$employee->id}");

        $response->assertOk()
            ->assertJsonFragment(['id' => $employee->id]);
    }

    public function test_update_modifies_employee()
    {
        $this->authenticate();
        $employee = Employee::factory()->create();

        $response = $this->putJson("/api/v1/employees/{$employee->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('employees', ['id' => $employee->id, 'name' => 'Updated Name']);
    }

    public function test_destroy_deletes_employee()
    {
        $this->authenticate();
        $employee = Employee::factory()->create();

        $response = $this->deleteJson("/api/v1/employees/{$employee->id}");

        $response->assertOk()
            ->assertJson(['message' => 'Deleted successfully']);
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }
}
