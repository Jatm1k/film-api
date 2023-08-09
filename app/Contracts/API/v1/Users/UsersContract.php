<?php

namespace App\Contracts\API\v1\Users;

use App\Models\API\v1\User;

interface UsersContract
{
    /**
     * @param User $user
     * @return void
     */
    public function subscribe(User $user): void;

    /**
     * @param User $user
     * @return void
     */
    public function unsubscribe(User $user): void;
}