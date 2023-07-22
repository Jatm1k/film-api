<?php

namespace App\Contracts\API\v1\Roles;

use App\Models\API\v1\Role;

interface RolesContract
{
    /**
     * @param  array  $data
     * @return Role
     */
    public function storeRole(array $data): Role;

    /**
     * @param  Role  $role
     * @param  array  $data
     * @return bool
     */
    public function updateRole(Role $role, array $data): bool;

    /**
     * @param  Role  $role
     * @return bool
     */
    public function destroyRole(Role $role): bool;
}
