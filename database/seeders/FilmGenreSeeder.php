<?php

namespace Database\Seeders;

use App\Models\API\v1\Film;
use App\Models\API\v1\Genre;
use App\Models\API\v1\User;
use Illuminate\Database\Seeder;

class FilmGenreSeeder extends Seeder
{
    public function run(): void
    {
        Genre::get()->each(
            fn($genre) => $genre->films()->saveMany($this->randomFilms())
        );
    }

    private function randomFilms()
    {
        $films = Film::query()->get();

        return $films->random(rand(1, count($films)));
    }
}
