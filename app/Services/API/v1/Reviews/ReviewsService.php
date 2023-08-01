<?php

namespace App\Services\API\v1\Reviews;

use App\Contracts\API\v1\Reviews\ReviewsContract;
use App\Facades\ExceptionHelper;
use App\Models\API\v1\Film;
use App\Models\API\v1\Review;
use App\Traits\API\v1\HasWatch;

class ReviewsService implements ReviewsContract {

    use HasWatch;

    private function isReviewExists(array $data): bool {
        return Review::query()
            ->where('film_id', $data['film_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
    }

    public function storeReview(array $data): Review {
        $data['user_id'] = auth()->id();

        if ($this->isReviewExists($data)) {
            ExceptionHelper::make(__('review.error.exists'), 422);
        }

        $film = Film::findOrFail($data['film_id']);
        if (!$this->isWatched($film)) {
            $this->watching($film);
        }

        return Review::query()->create($data);
    }

    public function updateReview(Review $review, array $data): void {
        if ($review->user_id !== auth()->id()) {
            ExceptionHelper::make(__('review.error.forbidden'), 403);
        }

        $review->update($data);
    }

    public function destroyReview(Review $review): void {
        if ($review->user_id !== auth()->id()) {
            ExceptionHelper::make(__('review.error.forbidden'), 403);
        }

        $review->delete();
    }

}
