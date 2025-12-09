<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\School;
use App\Models\Pool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'school_id' => School::inRandomOrder()->first()->id
                ?? School::factory()->create()->id,

            'name'      => $this->faker->unique()->city . ' Team',

            'referee'   => $this->faker->name(),

            'tournament_id' => null,

            'sport'     => 'voetbal',
            'group'     => $this->faker->randomElement([
                'groep3/4', 'groep5/6', 'groep7/8', 'klas1_jongens', 'klas1_meiden'
            ]),
        ];
    }
}
