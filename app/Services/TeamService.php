<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
    public function getAll(): Collection
    {
        return Team::with('organization')->get();
    }

    public function create(array $data): Team
    {
        return Team::create($data);
    }

    public function getById(Team $team): Team
    {
        return $team->load('organization');
    }

    public function update(Team $team, array $data): Team
    {
        $team->update($data);
        return $team;
    }

    public function delete(Team $team): void
    {
        $team->delete();
    }
}
