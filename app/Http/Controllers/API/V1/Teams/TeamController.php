<?php

namespace App\Http\Controllers\API\V1\Teams;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }


    public function index()
    {
        return $this->teamService->getAll();
    }

    public function store(StoreTeamRequest $request)
    {
        $team = $this->teamService->create($request->validated());
        return response()->json($team, 201);
    }

    public function show(Team $team)
    {
        return $this->teamService->getById($team);
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        $updated = $this->teamService->update($team, $request->validated());
        return response()->json($updated);
    }

    public function destroy(Team $team)
    {
        $this->teamService->delete($team);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
