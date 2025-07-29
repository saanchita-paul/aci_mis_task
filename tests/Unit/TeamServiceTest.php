<?php

namespace Tests\Unit;

use App\Models\Team;
use App\Models\Organization;
use App\Services\TeamService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TeamService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TeamService();
    }

    public function test_get_all_teams()
    {
        Team::factory()->count(3)->create();
        $teams = $this->service->getAll();

        $this->assertCount(3, $teams);
    }

    public function test_create_team()
    {
        $org = Organization::factory()->create();

        $team = $this->service->create([
            'name' => 'QA Team',
            'organization_id' => $org->id
        ]);

        $this->assertInstanceOf(Team::class, $team);
        $this->assertEquals('QA Team', $team->name);
    }

    public function test_get_by_id()
    {
        $team = Team::factory()->create();

        $found = $this->service->getById($team);

        $this->assertEquals($team->id, $found->id);
        $this->assertArrayHasKey('organization', $found->toArray());
    }

    public function test_update_team()
    {
        $team = Team::factory()->create(['name' => 'Before']);
        $this->service->update($team, ['name' => 'After']);

        $this->assertEquals('After', $team->fresh()->name);
    }

    public function test_delete_team()
    {
        $team = Team::factory()->create();

        $this->service->delete($team);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
