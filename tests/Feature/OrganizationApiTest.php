<?php

namespace Tests\Feature;


use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = \App\Models\User::factory()->create([
            'role' => 'user',
        ]);

        $this->actingAs($user, 'sanctum');
    }

    public function test_index_returns_all_organizations()
    {
        Organization::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/organizations');

        $response->assertOk()
            ->assertJsonCount(2);
    }

    public function test_store_creates_organization()
    {
        $response = $this->postJson('/api/v1/organizations', [
            'name' => 'Test Org',
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Test Org']);

        $this->assertDatabaseHas('organizations', ['name' => 'Test Org']);
    }

    public function test_store_validates_data()
    {
        $response = $this->postJson('/api/v1/organizations', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_show_returns_organization()
    {
        $org = Organization::factory()->create();

        $response = $this->getJson("/api/v1/organizations/{$org->id}");

        $response->assertOk()
            ->assertJsonFragment(['id' => $org->id]);
    }

    public function test_update_modifies_organization()
    {
        $org = Organization::factory()->create(['name' => 'Before']);

        $response = $this->putJson("/api/v1/organizations/{$org->id}", [
            'name' => 'After'
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'After']);

        $this->assertDatabaseHas('organizations', ['name' => 'After']);
    }

    public function test_destroy_deletes_organization()
    {
        $org = Organization::factory()->create();

        $response = $this->deleteJson("/api/v1/organizations/{$org->id}");

        $response->assertOk()
            ->assertJson(['message' => 'Deleted successfully']);

        $this->assertDatabaseMissing('organizations', ['id' => $org->id]);
    }
}
