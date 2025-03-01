<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum CommonStatusEnum: string
{
    use EnumToArray;

    case ACTIVE = 'Active';
    case IN_ACTIVE = 'Inactive';
}
