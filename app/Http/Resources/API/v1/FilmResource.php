<?php

namespace App\Http\Resources\API\v1;

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
            'title' => $this->title,
            'production_year' => $this->production_year,
            'duration' => $this->duration,
            'poster' => $this->poster,
            'images' => $this->images,
            'trailer' => $this->trailer,
        ];
    }
}
