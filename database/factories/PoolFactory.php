<?php

namespace Database\Factories;

use App\Models\Pool;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pool>
 */
class PoolFactory extends Factory
{
    protected $model = Pool::class;

    public function definition()
    {
        return [
            'tournament_id' => Tournament::inRandomOrder()->first()->id
                ?? Tournament::factory()->create()->id,
            'name'          => 'Pool ' . $this->faker->unique()->randomLetter(),
        ];
    }
}
