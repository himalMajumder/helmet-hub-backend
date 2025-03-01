<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    /**
     * PermissionService constructor
     *
     */
    public function __construct(
    ) {
    }

    /**
     * All Permission
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function all(array $attributes = [])
    {
        return Permission::get();
    }

}
