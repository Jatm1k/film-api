<?php

namespace Database\Factories\API\v1;

use App\Models\API\v1\Film;
use App\Models\API\v1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\API\v1\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first(),
            'film_id' => Film::query()->inRandomOrder()->first(),
            'rating' => rand(1, 10),
        ];
    }
}
