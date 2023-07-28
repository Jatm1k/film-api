<?php

namespace Database\Factories\API\v1;

use App\Enums\API\v1\ReviewType;
use App\Models\API\v1\Film;
use App\Models\API\v1\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\API\v1\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(rand(2, 4), true),
            'text' => fake()->text(),
            'type' => fake()->randomElement(ReviewType::cases())->value,
            'user_id' => User::query()->inRandomOrder()->first(),
            'film_id' => Film::query()->inRandomOrder()->first(),
        ];
    }
}
