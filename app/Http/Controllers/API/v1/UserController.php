<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Users\UsersContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\v1\Film\FilmMinifiedResource;
use App\Http\Resources\API\v1\Review\ReviewResource;
use App\Http\Resources\API\v1\User\UserResource;
use App\Models\API\v1\User;

class UserController extends Controller
{

    private UsersContract $service;

    public function __construct(UsersContract $service)
    {
        $this->service = $service;
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    public function subscribe(User $user)
    {
        $this->service->subscribe($user);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('user.message.subscribed', ['login' => $user->login]),
        ]);
    }

    public function unsubscribe(User $user)
    {
        $this->service->unsubscribe($user);
        return response()->json([
            'status' => __('response.status.success'),
            'message' => __('user.message.unsubscribed', ['login' => $user->login]),
        ]);
    }

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
