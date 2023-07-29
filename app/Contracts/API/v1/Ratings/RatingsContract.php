<?php

namespace App\Contracts\API\v1\Ratings;

use App\Models\API\v1\Rating;

interface RatingsContract
{
    /**
     * @param  array  $data
     * @return Rating
     */
    public function storeRating(array $data): Rating;

    /**
     * @param  Rating  $rating
     * @param  array  $data
     * @return void
     */
    public function updateRating(Rating $rating, array $data): void;

    /**
     * @param  Rating  $rating
     * @return void
     */
    public function destroyRating(Rating $rating): void;
}