<?php

namespace Tests\Unit;

use App\Models\Organization;
use App\Models\Team;
use App\Models\Employee;
use App\Services\Reports\ReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_stats_returns_expected_structure()
    {
        $org = Organization::factory()->create();
        $team = Team::factory()->create(['organization_id' => $org->id]);
        Employee::factory()->count(3)->create(['team_id' => $team->id, 'salary' => 5000]);

        $service = new ReportService();
        $stats = $service->getStats();

        $this->assertArrayHasKey('team_avg_salaries', $stats);
        $this->assertArrayHasKey('org_employee_counts', $stats);

        $this->assertGreaterThan(0, $stats['team_avg_salaries']->count());
        $this->assertGreaterThan(0, $stats['org_employee_counts']->count());
    }
}
