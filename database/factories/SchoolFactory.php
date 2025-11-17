<?php

namespace Database\Factories;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\School>
 */
class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition()
    {
        return [
            'name'       => $this->faker->unique()->company . ' School',
            'creator_id' => User::inRandomOrder()->first()->id
                            ?? User::factory()->create()->id,
        ];
    }
}
