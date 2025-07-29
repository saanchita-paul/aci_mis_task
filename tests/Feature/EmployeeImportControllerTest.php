<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Jobs\ProcessEmployeeImport;

class EmployeeImportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_requires_authentication()
    {
        $response = $this->postJson('/api/v1/employees/import', []);

        $response->assertUnauthorized();
    }

    public function test_import_requires_file()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/employees/import', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['file']);
    }

    public function test_import_accepts_valid_json_file_and_dispatches_job()
    {
        Queue::fake();

        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');

        $file = UploadedFile::fake()->create('employees.json', 100, 'application/json');

        $response = $this->postJson('/api/v1/employees/import', [
            'file' => $file,
        ]);

        $response->assertOk()
            ->assertJson(['message' => 'Employee import queued']);

        Queue::assertPushed(ProcessEmployeeImport::class, function ($job) use ($user) {
            return $job->user->id === $user->id;
        });
    }
}
