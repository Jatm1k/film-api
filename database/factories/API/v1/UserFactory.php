<?php

namespace Database\Factories\API\v1;

use App\Models\API\v1\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\API\v1\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::query()->inRandomOrder()->first(),
            'name' => fake()->name(),
            'login' => fake()->unique()->word(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
        ];
    }
}
