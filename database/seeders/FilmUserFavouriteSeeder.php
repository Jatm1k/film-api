<?php

namespace Database\Seeders;

use App\Models\API\v1\Film;
use App\Models\API\v1\User;
use Illuminate\Database\Seeder;

class FilmUserFavouriteSeeder extends Seeder
{
    public function run(): void
    {
        User::get()->each(
            fn($user) => $user->favoriteFilms()->saveMany($this->randomFilms())
        );
    }

    private function randomFilms()
    {
        $films = Film::query()->get();

        return $films->random(rand(1, count($films)));
    }
}
