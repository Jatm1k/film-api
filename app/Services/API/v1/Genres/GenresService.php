<?php

namespace App\Services\API\v1\Genres;

use App\Contracts\API\v1\Genres\GenresContract;
use App\Models\API\v1\Genre;

class GenresService implements GenresContract
{

    public function storeGenre(array $data): Genre
    {
        return Genre::query()->create($data);
    }

    public function updateGenre(Genre $genre, array $data): void
    {
        $genre->update($data);
    }

    public function destroyGenre(Genre $genre): void
    {
        $genre->delete();
    }
}
