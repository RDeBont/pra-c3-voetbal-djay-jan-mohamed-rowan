<?php

namespace Database\Factories;
use App\Models\Fixture;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fixture>
 */
class FixtureFactory extends Factory
{
    protected $model = Fixture::class;

    public function definition()
    {
        $team1 = Team::inRandomOrder()->first() ?? Team::factory()->create();
        $team2 = Team::inRandomOrder()->where('id', '!=', $team1->id)->first() ?? Team::factory()->create();

        return [
            'team_1_id'     => $team1->id,
            'team_2_id'     => $team2->id,
            'team_1_score'  => $this->faker->numberBetween(0, 8),
            'team_2_score'  => $this->faker->numberBetween(0, 8),
            'field'         => $this->faker->numberBetween(0, 5),
            'start_time'    => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'type'          => $this->faker->randomElement(['Group', 'Semi-Final', 'Final']),
            'tournament_id' => Tournament::inRandomOrder()->first()->id
                               ?? Tournament::factory()->create()->id,
        ];
    }
}
