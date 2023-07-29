<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\API\v1\Role;
use App\Models\API\v1\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            FilmSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            ReviewSeeder::class,
            RatingSeeder::class,
        ]);
    }
}
