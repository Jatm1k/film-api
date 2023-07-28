<?php

namespace App\Http\Resources\API\v1\Review;

use App\Http\Resources\API\v1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewMinifiedResource extends JsonResource
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
            'text' => $this->text,
            'type' => $this->type,
            'author' => new UserResource($this->author),
        ];
    }
}
