<?php

namespace App\Enums\Permission;

use App\Traits\EnumToArray;

enum RolePermissionEnum: string {
    use EnumToArray;

    case READ       = 'Preview Role';
    case CREATE     = 'Create Role';
    case EDIT       = 'Edit Role';
    case DELETE     = 'Delete Role';
    case ACTIVATE   = 'Activate Role';
    case DEACTIVATE = 'Deactivate Role';
}
