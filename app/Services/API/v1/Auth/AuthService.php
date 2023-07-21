<?php

namespace App\Services\API\v1\Auth;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Models\API\v1\User;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthContract
{

    public function register(array $userData): string
    {
        $user = User::query()->create($userData);

        auth()->login($user);

        return $this->getToken();
    }

    public function login(array $userData): string
    {
        if (!auth()->attempt($userData)) {
            throw ValidationException::withMessages([
                'login' => [__('auth.failed')]
            ]);
        }
        return $this->getToken();
    }

    private function getToken(): string
    {
        return auth()->user()
            ->createToken('auth-token')
            ->plainTextToken;
    }
}
