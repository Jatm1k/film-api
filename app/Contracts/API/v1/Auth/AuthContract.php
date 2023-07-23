<?php

namespace App\Contracts\API\v1\Auth;

use App\Models\API\v1\User;

interface AuthContract
{
    /**
     * @param  array  $userData
     * @return User
     */
    public function register(array $userData): User;

    /**
     * @param  array  $userData
     * @return User
     */
    public function login(array $userData): User;

    /**
     * @return void
     */
    public function logout(): void;
}
