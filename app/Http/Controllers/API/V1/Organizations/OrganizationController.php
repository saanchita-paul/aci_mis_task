<?php

namespace App\Http\Controllers\API\V1\Organizations;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateOrganizationRequest;
use App\Models\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Request;

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
//        return Organization::all();
    }

    public function store(StoreUpdateOrganizationRequest $request)
    {
//        $data = $request->validate([
//            'name' => 'required|string|max:255',
//        ]);
//
//        return Organization::create($data);
        return $this->organizationService->create($request->validated());
    }

    public function show(Organization $organization)
    {
//        return $organization;
        return $this->organizationService->getById($organization);
    }

    public function update(StoreUpdateOrganizationRequest $request, Organization $organization)
    {
//        $organization->update($request->only('name'));
//        return $organization;
        return $this->organizationService->update($organization, $request->validated());

    }

    public function destroy(Organization $organization)
    {
//        $organization->delete();
//        return response()->json(['message' => 'Deleted successfully']);
        $this->organizationService->delete($organization);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
