<?php

namespace App\Contracts\API\v1\Auth;

interface AuthContract
{
    /**
     * @param array $userData
     * @return string
     */
    public function register(array $userData): string;

    /**
     * @param array $userData
     * @return string
     */
    public function login(array $userData): string;
}
