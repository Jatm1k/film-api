<?php

namespace App\Http\Resources\API\v1\Film;

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
            'reviews' => ReviewMinifiedResource::collection($this->reviews),
        ];
    }
}
