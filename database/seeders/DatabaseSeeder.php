<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tournament;
use App\Models\Pool;
use App\Models\School;
use App\Models\Team;
use App\Models\Fixture;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
     
        $this->call(AdminUserSeeder::class);
        // Create users for school creators
        User::factory()->count(10)->create();

        // -----------------------------
        // 1️⃣ Create Tournaments
        // -----------------------------
        $tournaments = Tournament::factory()
            ->count(4)
            ->create();

        // -----------------------------
        // 2️⃣ Create Pools for each Tournament
        // -----------------------------
        $tournaments->each(function (Tournament $tournament) {
            Pool::factory()
                ->count(4) // adjust pools per tournament
                ->create([
                    'tournament_id' => $tournament->id,
                ]);
        });

        // -----------------------------
        // 3️⃣ Create Schools
        // -----------------------------
        $schools = School::factory()
            ->count(8)
            ->create();

        // -----------------------------
        // 4️⃣ Create Teams for each Pool & School
        //    Ensures valid school_id + pool_id
        // -----------------------------
        Pool::all()->each(function (Pool $pool) use ($schools) {
            Team::factory()
                ->count(2) // adjust as needed
                ->create([
                    'pool_id'   => $pool->id,
                    'school_id' => $schools->random()->id,
                ]);
        });

        // -----------------------------
        // 5️⃣ Create Fixtures for each Tournament
        // -----------------------------
        Tournament::all()->each(function (Tournament $tournament) {
            $teams = $tournament->pools->flatMap->teams; // teams in all pools

            // Generate fixtures only if enough teams exist
            if ($teams->count() >= 2) {
                Fixture::factory()
                    ->count(10) // adjust amount of matches
                    ->create([
                        'tournament_id' => $tournament->id,
                    ]);
            }
        });
    }
}
