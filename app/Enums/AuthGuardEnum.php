<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum AuthGuardEnum: string {
    use EnumToArray;

    case ADMIN   = 'admin';
    case SANCTUM = 'sanctum';
}
