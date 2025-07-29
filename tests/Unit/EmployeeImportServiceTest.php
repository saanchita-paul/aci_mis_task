<?php

namespace Tests\Unit;

use App\Jobs\ProcessEmployeeImport;
use App\Models\User;
use App\Services\EmployeeImportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EmployeeImportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_dispatches_employee_import_job()
    {
        Queue::fake();
        Storage::fake();

        $user = User::factory()->make();
        $file = UploadedFile::fake()->create('employees.json', 100, 'application/json');

        $service = new EmployeeImportService();
        $service->import($file, $user);

        Queue::assertPushed(ProcessEmployeeImport::class, function ($job) use ($user) {
            return $job->user->id === $user->id;
        });
    }
}
