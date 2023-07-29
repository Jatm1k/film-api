<?php

namespace App\Services\API\v1\Ratings;

use App\Contracts\API\v1\Ratings\RatingsContract;
use App\Facades\ExceptionHelper;
use App\Models\API\v1\Rating;

class RatingsService implements RatingsContract
{
    private function isReviewExists(array $data): bool
    {
        return Rating::query()
            ->where('film_id', $data['film_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
    }

    public function storeRating(array $data): Rating
    {
        $data['user_id'] = auth()->id();

        if ($this->isReviewExists($data)) {
            ExceptionHelper::make(__('rating.error.exists'), 422);
        }

        return Rating::query()->create($data);
    }

    public function updateRating(Rating $rating, array $data): void
    {
        if ($rating->user_id !== auth()->id()) {
            ExceptionHelper::make(__('rating.error.forbidden'), 403);
        }

        $rating->update($data);
    }

    public function destroyRating(Rating $rating): void
    {
        if ($rating->user_id !== auth()->id()) {
            ExceptionHelper::make(__('rating.error.forbidden'), 403);
        }

        $rating->delete();
    }
}
