<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = Team::all();

        foreach ($teams as $team) {
            Employee::factory()->count(10)->create([
                'team_id' => $team->id
            ]);
        }
    }
}
