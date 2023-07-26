<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\Film\FilmMinifiedResource;
use App\Http\Resources\API\v1\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return response()->json(new UserResource(auth()->user()));
    }

    public function watched()
    {
        return response()->json(FilmMinifiedResource::collection(auth()->user()->watched));
    }
}
