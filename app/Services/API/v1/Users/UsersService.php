<?php

namespace App\Services\API\v1\Users;

use App\Contracts\API\v1\Users\UsersContract;
use App\Facades\ExceptionHelper;
use App\Models\API\v1\User;

use function Symfony\Component\String\u;

class UsersService implements UsersContract
{
    private function checkSubscribe(User $user): bool
    {
        return $user->subscribers()->where('subscriber_id', auth()->id())->exists();
    }

    public function subscribe(User $user): void
    {
        if ($this->checkSubscribe($user)) {
            ExceptionHelper::make(__('user.error.subscribed'), 422);
        }
        $user->subscribers()->attach(auth()->id());
    }

    public function unsubscribe(User $user): void
    {
        if (!$this->checkSubscribe($user)) {
            ExceptionHelper::make(__('user.error.unsubscribed'), 422);
        }
        $user->subscribers()->detach(auth()->id());
    }
}