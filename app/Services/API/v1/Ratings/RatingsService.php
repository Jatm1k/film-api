<?php

namespace App\Services\API\v1\Ratings;

use App\Contracts\API\v1\Ratings\RatingsContract;
use App\Facades\ExceptionHelper;
use App\Models\API\v1\Film;
use App\Models\API\v1\Rating;
use App\Traits\API\v1\HasWatch;

class RatingsService implements RatingsContract {

    use HasWatch;

    private function isReviewExists(array $data): bool {
        return Rating::query()
            ->where('film_id', $data['film_id'])
            ->where('user_id', $data['user_id'])
            ->exists();
    }

    public function storeRating(array $data): Rating {
        $data['user_id'] = auth()->id();

        if ($this->isReviewExists($data)) {
            ExceptionHelper::make(__('rating.error.exists'), 422);
        }

        $film = Film::findOrFail($data['film_id']);
        if (!$this->isWatched($film)) {
            $this->watching($film);
        }

        return Rating::query()->create($data);
    }

    public function updateRating(Rating $rating, array $data): void {
        if ($rating->user_id !== auth()->id()) {
            ExceptionHelper::make(__('rating.error.forbidden'), 403);
        }

        $rating->update($data);
    }

    public function destroyRating(Rating $rating): void {
        if ($rating->user_id !== auth()->id()) {
            ExceptionHelper::make(__('rating.error.forbidden'), 403);
        }

        $rating->delete();
    }

}
