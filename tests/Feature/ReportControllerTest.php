<?php

namespace Tests\Feature\Reports;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use Aci\EmployeeReports\Facades\EmployeeReports;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user, 'sanctum');

        $this->withoutMiddleware('role:user');
    }

    public function test_stats_endpoint_returns_correct_json_structure()
    {
        $this->assertAuthenticated('sanctum');

        $org = Organization::factory()->create();
        $team = Team::factory()->create(['organization_id' => $org->id]);
        Employee::factory()->count(2)->create(['team_id' => $team->id, 'salary' => 4000]);

        $response = $this->getJson('/api/v1/reports/stats');

        $response->assertOk()
            ->assertJsonStructure([
                'team_avg_salaries',
                'org_employee_counts',
            ]);
    }

    public function test_download_report_returns_pdf_response()
    {
        $user = auth()->user();

        $org = Organization::factory()->create();
        $team = Team::factory()->create(['organization_id' => $org->id]);
        Employee::factory()->create(['team_id' => $team->id]);

        EmployeeReports::shouldReceive('generate')
            ->once()
            ->andReturn(
                new class {
                    public function download($name)
                    {
                        return response('PDF content')->header('Content-Type', 'application/pdf');
                    }
                }
            );

        $response = $this->get('/employee-report/download');

        $response->assertOk();
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
    }
}
