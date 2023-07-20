<?php

namespace App\Services\API\v1\Films;

use App\Contracts\API\v1\Films\FilmsContract;
use App\Models\API\v1\Film;

class FilmsService implements FilmsContract
{
    public function storeFilm(array $data): Film
    {
        $data['poster'] = upload_file($data['poster'], 'film/posters');
        $data['images'] = upload_files($data['images'], 'film/images');
        return Film::query()->create($data);
    }
}
