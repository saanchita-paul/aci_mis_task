<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Collection;

class OrganizationService
{
    public function getAll(): Collection
    {
        return Organization::all();
    }

    public function create(array $data): Organization
    {
        return Organization::create($data);
    }

    public function getById(Organization $organization): Organization
    {
        return $organization;
    }

    public function update(Organization $organization, array $data): Organization
    {
        $organization->update($data);
        return $organization;
    }

    public function delete(Organization $organization): void
    {
        $organization->delete();
    }
}
