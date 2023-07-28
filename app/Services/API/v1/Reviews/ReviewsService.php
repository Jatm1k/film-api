<?php

namespace App\Services\API\v1\Reviews;

use App\Contracts\API\v1\Reviews\ReviewsContract;
use App\Facades\ExceptionHelper;
use App\Models\API\v1\Review;

class ReviewsService implements ReviewsContract
{
    private function isReviewExists(array $data): bool
    {
        return Review::query()
            ->where('film_id', $data['film_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
    }

    public function storeReview(array $data): Review
    {
        $data['user_id'] = auth()->id();

        if ($this->isReviewExists($data)) {
            ExceptionHelper::make(__('review.error.exists'), 422);
        }

        return Review::query()->create($data);
    }


    public function updateReview(Review $review, array $data): void
    {
        if ($review->user_id !== auth()->id()) {
            ExceptionHelper::make(__('review.error.forbidden'), 403);
        }

        $review->update($data);
    }

    public function destroyReview(Review $review): void
    {
        if ($review->user_id !== auth()->id()) {
            ExceptionHelper::make(__('review.error.forbidden'), 403);
        }

        $review->delete();
    }
}