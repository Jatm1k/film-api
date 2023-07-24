<?php

namespace Database\Seeders;

use App\Models\API\v1\Role;
use App\Enums\API\v1\Role as EnumRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(EnumRole::cases())
            ->each(
                fn(EnumRole $role) => Role::factory()->createOne(['name' => $role->value])
            );
    }
}
