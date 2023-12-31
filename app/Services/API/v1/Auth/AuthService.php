<?php

namespace App\Services\API\v1\Auth;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Facades\ExceptionHelper;
use App\Models\API\v1\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthContract
{

    public function register(array $userData): User
    {
        $user = User::query()->create($userData)->refresh();

        auth()->login($user);

        return $user;
    }

    public function login(array $userData): User
    {
        if (!Auth::attempt($userData)) {
            ExceptionHelper::make(__('auth.failed'), 422);
        }

        return auth()->user();
    }

    public function logout(): void
    {
        auth()->logout();
    }
}
