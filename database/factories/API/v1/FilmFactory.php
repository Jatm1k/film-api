<?php

namespace Database\Factories\API\v1;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\API\v1\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeInInterval('-5 years', '+5 years');
        return [
            'title' => ucfirst(fake()->unique()->words(rand(1, 4), true)),
            'production_year' => fake()->year(),
            'duration' => fake()->time('H:i'),
            'poster' => 'https://via.placeholder.com/300x450',
            'images' => [
                'https://via.placeholder.com/1920x1080',
                'https://via.placeholder.com/1920x1080',
                'https://via.placeholder.com/1920x1080',
            ],
            'trailer' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
