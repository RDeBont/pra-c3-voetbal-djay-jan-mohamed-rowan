<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name'       => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail(),
            'password'   => Hash::make('password'), // default password
            'is_admin'   => false,
            'phonenumber'=> $this->faker->phoneNumber(),
        ];
    }

    /**
     * Admin user state
     */
    public function admin()
    {
        return $this->state([
            'is_admin' => true,
        ]);
    }
}
