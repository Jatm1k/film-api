<?php

namespace App\Contracts\API\v1\Films;

use App\Models\API\v1\Film;
use Illuminate\Database\Eloquent\Collection;

interface FilmsContract
{
    /**
     * @param array $data
     * @return Film
     */
    public function storeFilm(array $data): Film;

    /**
     * @param Film $film
     * @param array $data
     * @return void
     */
    public function updateFilm(Film $film, array $data): void;

    /**
     * @param Film $film
     * @return void
     */
    public function destroyFilm(Film $film): void;

    /**
     * @param Film $film
     * @return void
     */
    public function watch(Film $film): void;

    /**
     * @param Film $film
     * @return void
     */
    public function unwatch(Film $film): void;

    /**
     * @param Film $film
     * @return void
     */
    public function favorite(Film $film): void;

    /**
     * @param Film $film
     * @return void
     */
    public function unfavorite(Film $film): void;

    /**
     * @return Collection
     */
    public function recommendations(): Collection;

    /**
     * @return Collection
     */
    public function subscriptionsWatched(): Collection;
}
