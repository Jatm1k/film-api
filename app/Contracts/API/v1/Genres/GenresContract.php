<?php

namespace App\Contracts\API\v1\Genres;

use App\Models\API\v1\Genre;

interface GenresContract
{
    /**
     * @param array $data
     * @return Genre
     */
    public function storeGenre(array $data): Genre;

    /**
     * @param Genre $genre
     * @param array $data
     * @return void
     */
    public function updateGenre(Genre $genre, array $data): void;

    /**
     * @param Genre $genre
     * @return void
     */
    public function destroyGenre(Genre $genre): void;
}
