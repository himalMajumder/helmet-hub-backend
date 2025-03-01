<?php

namespace App\Enums\Permission;

use App\Traits\EnumToArray;

enum UserPermissionEnum: string {
    use EnumToArray;

    case READ       = 'Preview User';
    case CREATE     = 'Create User';
    case EDIT       = 'Edit User';
    case DELETE     = 'Delete User';
    case ACTIVATE   = 'Activate User';
    case DEACTIVATE = 'Deactivate User';
}
