<?php

namespace Database\Seeders;

use App\Enums\API\v1\Role;
use App\Models\API\v1\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        
        User::factory()->createOne([
            'login' => 'admin',
            'role_id' => Role::Admin->getId()
        ]);
    }
}
