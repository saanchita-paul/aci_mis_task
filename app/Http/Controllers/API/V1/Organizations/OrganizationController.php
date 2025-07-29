<?php

namespace App\Http\Controllers\API\V1\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;

class OrganizationController extends Controller
{
    protected OrganizationService $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }


    public function index()
    {
        return $this->organizationService->getAll();
    }

    public function store(StoreUpdateOrganizationRequest $request)
    {
        return $this->organizationService->create($request->validated());
    }

    public function show(Organization $organization)
    {
        return $this->organizationService->getById($organization);
    }

    public function update(StoreUpdateOrganizationRequest $request, Organization $organization)
    {
        return $this->organizationService->update($organization, $request->validated());

    }

    public function destroy(Organization $organization)
    {
        $this->organizationService->delete($organization);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
