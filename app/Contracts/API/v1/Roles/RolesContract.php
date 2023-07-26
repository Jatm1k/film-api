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
     * @return void
     */
    public function updateRole(Role $role, array $data): void;

    /**
     * @param  Role  $role
     * @return void
     */
    public function destroyRole(Role $role): void;
}
