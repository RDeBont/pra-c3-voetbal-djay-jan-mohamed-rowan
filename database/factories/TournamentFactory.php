<?php

namespace Database\Factories;

use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    protected $model = Tournament::class;

    public function definition()
    {
        return [
            'name'                => $this->faker->unique()->words(3, true) . ' Tournament',
            'date'                => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'fields_amount'       => $this->faker->numberBetween(1, 5),
            'game_length_minutes' => $this->faker->randomElement([60, 90, 120]),
            'amount_teams_pool'   => $this->faker->numberBetween(4, 6),
            'archived'            => false,
        ];
    }
}
