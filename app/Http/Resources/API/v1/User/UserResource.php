<?php

namespace App\Http\Resources\API\v1\User;

use App\Http\Resources\API\v1\Film\FilmMinifiedResource;
use App\Http\Resources\API\v1\Review\ReviewMinifiedResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'login' => $this->login,
            'email' => $this->email,
            'role' => $this->role->name,
            'subscriptions' => UserMinifiedResource::collection($this->subscriptions),
            'subscribers' => UserMinifiedResource::collection($this->subscribers),
            'watched_films' => FilmMinifiedResource::collection($this->watchedFilms),
            'reviews' => ReviewMinifiedResource::collection($this->reviews),
        ];
    }
}
