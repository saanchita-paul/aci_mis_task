<?php
namespace Tests\Unit;

use App\Models\Employee;
use App\Models\Organization;
use App\Models\Team;
use App\Services\Reports\EmployeeReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Facade;
use Aci\EmployeeReports\Facades\EmployeeReports;
use Tests\TestCase;

class EmployeeReportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_pdf_report_calls_facade_and_downloads()
    {
        $org = Organization::factory()->create();
        $team = Team::factory()->create(['organization_id' => $org->id]);
        Employee::factory()->create(['team_id' => $team->id]);

        EmployeeReports::shouldReceive('generate')
            ->once()
            ->withArgs(function ($employees) {
                return $employees->count() === 1;
            })
            ->andReturn(
                new class {
                    public function download($name)
                    {
                        return response('PDF content')->header('Content-Type', 'application/pdf');
                    }
                }
            );

        $service = new EmployeeReportService();
        $response = $service->generatePdfReport();

        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
    }
}
