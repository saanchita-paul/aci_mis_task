<?php

namespace App\Http\Controllers\API\V1\Organizations;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        return Organization::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Organization::create($data);
    }

    public function show(Organization $organization)
    {
        return $organization;
    }

    public function update(Request $request, Organization $organization)
    {
        $organization->update($request->only('name'));
        return $organization;
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
