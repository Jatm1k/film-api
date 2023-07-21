<?php

namespace App\Services\API\v1\Auth;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Models\API\v1\User;

class AuthService implements AuthContract
{

    public function register(array $userData): string
    {
        $user = User::query()->create($userData);

        return $user->createToken('auth-token')->plainTextToken;
    }

    public function login(array $userData): string
    {
        return '123';
    }
}
