<?php

namespace App\Services\API\v1\Roles;

use App\Contracts\API\v1\Roles\RolesContract;
use App\Models\API\v1\Role;

class RolesService implements RolesContract
{

    public function storeRole(array $data): Role
    {
        return Role::query()->create($data);
    }

    public function updateRole(Role $role, array $data): void
    {
        $role->update($data);
    }

    public function destroyRole(Role $role): void
    {
        $role->delete();
    }
}