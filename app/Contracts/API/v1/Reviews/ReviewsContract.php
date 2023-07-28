<?php

namespace App\Contracts\API\v1\Reviews;

use App\Models\API\v1\Review;

interface ReviewsContract
{
    /**
     * @param  array  $data
     * @return Review
     */
    public function storeReview(array $data): Review;

    /**
     * @param  Review  $review
     * @param  array  $data
     * @return void
     */
    public function updateReview(Review $review, array $data): void;

    /**
     * @param  Review  $review
     * @return void
     */
    public function destroyReview(Review $review): void;
}