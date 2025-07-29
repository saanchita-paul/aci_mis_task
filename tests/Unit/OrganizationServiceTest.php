<?php

namespace Tests\Unit;

use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrganizationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OrganizationService();
    }

    public function test_it_can_create_organization()
    {
        $org = $this->service->create(['name' => 'Test Org']);
        $this->assertInstanceOf(Organization::class, $org);
        $this->assertDatabaseHas('organizations', ['name' => 'Test Org']);
    }

    public function test_it_can_return_all_organizations()
    {
        Organization::factory()->count(3)->create();
        $orgs = $this->service->getAll();
        $this->assertCount(3, $orgs);
    }

    public function test_it_can_return_single_organization()
    {
        $org = Organization::factory()->create();
        $result = $this->service->getById($org);
        $this->assertEquals($org->id, $result->id);
    }

    public function test_it_can_update_organization()
    {
        $org = Organization::factory()->create(['name' => 'Old Name']);
        $updated = $this->service->update($org, ['name' => 'New Name']);

        $this->assertEquals('New Name', $updated->name);
        $this->assertDatabaseHas('organizations', ['name' => 'New Name']);
    }

    public function test_it_can_delete_organization()
    {
        $org = Organization::factory()->create();
        $this->service->delete($org);

        $this->assertDatabaseMissing('organizations', ['id' => $org->id]);
    }
}
