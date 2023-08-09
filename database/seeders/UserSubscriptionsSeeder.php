<?php

namespace Database\Seeders;

use App\Models\API\v1\User;
use Illuminate\Database\Seeder;

class UserSubscriptionsSeeder extends Seeder
{
    public function run(): void
    {
        User::get()->each(
            fn($user) => $user->subscribers()->saveMany($this->randomSubscribers($user))
        );
    }

    private function randomSubscribers(User $user)
    {
        $users = User::query()->where('id', '!=', $user->id)->get();

        return $users->random(rand(1, count($users)));
    }
}
