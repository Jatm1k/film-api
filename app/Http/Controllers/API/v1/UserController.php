<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\Film\FilmMinifiedResource;
use App\Http\Resources\API\v1\Review\ReviewResource;
use App\Http\Resources\API\v1\UserResource;

class UserController extends Controller
{
    public function profile()
    {
        return response()->json(new UserResource(auth()->user()));
    }

    public function watchedFilms()
    {
        return response()->json(
            FilmMinifiedResource::collection(auth()->user()->watchedFilms)
        );
    }

    public function favoriteFilms()
    {
        return response()->json(
            FilmMinifiedResource::collection(auth()->user()->favoriteFilms)
        );
    }

    public function getReviews()
    {
        return response()->json(
            ReviewResource::collection(auth()->user()->reviews)
        );
    }
}
