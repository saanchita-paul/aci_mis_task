<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'sanctum');
    }

    public function test_index_returns_teams()
    {
        $this->authenticate();

        Team::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/teams');

        $response->assertOk()
            ->assertJsonCount(2);
    }

    public function test_store_creates_team()
    {
        $this->authenticate();

        $org = Organization::factory()->create();

        $response = $this->postJson('/api/v1/teams', [
            'name' => 'Dev Team',
            'organization_id' => $org->id
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Dev Team']);

        $this->assertDatabaseHas('teams', ['name' => 'Dev Team']);
    }

    public function test_store_validation_fails()
    {
        $this->authenticate();

        $response = $this->postJson('/api/v1/teams', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'organization_id']);
    }

    public function test_show_returns_team()
    {
        $this->authenticate();

        $team = Team::factory()->create();

        $response = $this->getJson("/api/v1/teams/{$team->id}");

        $response->assertOk()
            ->assertJsonFragment(['id' => $team->id]);
    }

    public function test_update_modifies_team()
    {
        $this->authenticate();

        $team = Team::factory()->create(['name' => 'Old Name']);
        $newOrg = Organization::factory()->create();

        $response = $this->putJson("/api/v1/teams/{$team->id}", [
            'name' => 'New Name',
            'organization_id' => $newOrg->id
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'New Name']);

        $this->assertDatabaseHas('teams', ['name' => 'New Name']);
    }

    public function test_destroy_deletes_team()
    {
        $this->authenticate();

        $team = Team::factory()->create();

        $response = $this->deleteJson("/api/v1/teams/{$team->id}");

        $response->assertOk()
            ->assertJson(['message' => 'Deleted successfully']);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
