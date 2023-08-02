<?php

namespace Database\Seeders;

use App\Models\API\v1\Review;
use App\Models\API\v1\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::with('watchedFilms')->get()->each(
            fn(User $user) => $this->ratingForWatched(
                $user->watchedFilms->random(rand(1, count($user->watchedFilms))),
                $user
            )
        );
    }

    private function ratingForWatched(Collection $films, $user)
    {
        $films->each(
            fn($film) => Review::factory()->for($film)->for($user, 'author')->create()
        );
    }
}
