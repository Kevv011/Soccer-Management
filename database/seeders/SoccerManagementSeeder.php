<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Federation;
use App\Models\Player;
use App\Models\Subdivision;
use App\Models\Team;
use Illuminate\Database\Seeder;

class SoccerManagementSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Country::factory()
            ->count(3)
            ->create()
            ->each(function (Country $country): void {
                $subdivisions = Subdivision::factory()
                    ->count(2)
                    ->for($country)
                    ->create();

                $subdivisions->each(function (Subdivision $subdivision): void {
                    $federations = Federation::factory()
                        ->count(2)
                        ->for($subdivision)
                        ->create();

                    $federations->each(function (Federation $federation): void {
                        $teams = Team::factory()
                            ->count(3)
                            ->for($federation)
                            ->create();

                        $teams->each(function (Team $team): void {
                            Player::factory()
                                ->count(10)
                                ->for($team)
                                ->create();
                        });
                    });
                });
            });
    }
}
