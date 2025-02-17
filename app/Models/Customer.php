<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'product',
        'model',
        'serial_number',
        'memo_number',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'uuid'          => 'string',
            'name'          => 'string',
            'phone'         => 'string',
            'email'         => 'string',
            'address'       => 'string',
            'product'       => 'string',
            'model'         => 'string',
            'serial_number' => 'string',
            'memo_number'   => 'string',
        ];
    }

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }

        });
    }

}
