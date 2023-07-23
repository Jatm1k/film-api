<?php

namespace App\Services\API\v1\Auth;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Models\API\v1\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthContract
{

    public function register(array $userData): string
    {
        $user = User::query()->create($userData);

        return $this->getToken($user);
    }

    public function login(array $userData): string
    {
        $user = User::where('login', $userData['login'])->first();

        if (!$user || !Hash::check($userData['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => [__('auth.failed')]
            ]);
        }

        return $this->getToken($user);
    }

    private function getToken(User $user): string
    {
        return $user
            ->createToken('api_token')
            ->plainTextToken;
    }
}
