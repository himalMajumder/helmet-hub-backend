<?php

namespace App\Models\Sanctum;

use Laravel\Sanctum\PersonalAccessToken as SanctumAccessToken;

class PersonalAccessToken extends SanctumAccessToken
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'expires_at',
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'token',
    ];
}
