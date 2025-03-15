<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'bike_model_id',
        'model_number',
        'type',
        'size',
        'color',
        'price',
        'warranty_duration',
        'status',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid'              => 'string',
        'name'              => 'string',
        'bike_model_id'     => 'integer',
        'model_number'      => 'string',
        'type'              => 'string',
        'size'              => 'string',
        'color'             => 'string',
        'price'             => 'float',
        'warranty_duration' => 'integer',
        'status'            => 'string',
        'user_id'           => 'integer',
    ];

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

    /**
     * Bike Model
     *
     * @return void
     */
    public function bikeModel(): BelongsTo
    {
        return $this->belongsTo(BikeModel::class);
    }

}
