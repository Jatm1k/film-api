<?php

namespace App\Contracts\API\v1\Films;

use App\Models\API\v1\Film;

interface FilmsContract
{
    /**
     * @param array $data
     * @return Film
     */
    public function storeFilm(array $data): Film;
}
