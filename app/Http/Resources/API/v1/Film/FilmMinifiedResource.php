<?php

namespace App\Http\Resources\API\v1\Film;

use App\Http\Resources\API\v1\Genre\GenreMinifiedResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmMinifiedResource extends JsonResource
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
            'rating' => $this->rating,
            'genres' => GenreMinifiedResource::collection($this->genres),
        ];
    }
}
