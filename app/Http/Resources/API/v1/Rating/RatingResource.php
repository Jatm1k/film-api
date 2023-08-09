<?php

namespace App\Http\Resources\API\v1\Rating;

use App\Http\Resources\API\v1\Film\FilmMinifiedResource;
use App\Http\Resources\API\v1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'film' => new FilmMinifiedResource($this->film),
            'author' => new UserResource($this->author),
            'rating' => $this->rating,
        ];
    }
}
