<?php

namespace App\Http\Resources\API\v1\Film;

use App\Http\Resources\API\v1\Genre\GenreMinifiedResource;
use App\Http\Resources\API\v1\Review\ReviewMinifiedResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'production_year' => $this->production_year,
            'duration' => $this->duration,
            'poster' => $this->poster,
            'images' => $this->images,
            'trailer' => $this->trailer,
            'genres' => GenreMinifiedResource::collection($this->genres),
            'reviews' => ReviewMinifiedResource::collection($this->filmReviewsWithoutAuthUserReview()),
            'rating' => $this->rating,
            $this->mergeWhen(auth()->check(), [
                'watched' => $this->isWatched(),
                'my_rating' => $this->userRating(),
                'my_review' => new ReviewMinifiedResource($this->userReview()),
            ]),
            'my_rating' => $this->when(auth()->check(), $this->isWatched()),
        ];
    }

    private function filmReviewsWithoutAuthUserReview()
    {
        return $this->reviews->where('id', '!=', $this->userReview()?->id);
    }

    private function isWatched()
    {
        return $this->viewers()->where('user_id', auth()->id())->exists();
    }

    private function userRating()
    {
        return $this->ratings()->where('user_id', auth()->id())->first()?->rating;
    }

    private function userReview()
    {
        return $this->reviews()->where('user_id', auth()->id())->first();
    }
}
