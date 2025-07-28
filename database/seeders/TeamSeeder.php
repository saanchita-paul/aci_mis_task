<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();

        foreach ($organizations as $org) {
            Team::factory()->count(3)->create([
                'organization_id' => $org->id
            ]);
        }
    }
}
