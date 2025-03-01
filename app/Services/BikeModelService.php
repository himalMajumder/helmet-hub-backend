<?php

namespace App\Services;

use App\Enums\CommonStatusEnum;
use App\Models\BikeModel;
use Exception;
use Illuminate\Support\Facades\DB;

class BikeModelService
{
    /**
     * BikeModelService constructor
     *
     */
    public function __construct(
    ) {
    }

    /**
     * All Bike Model
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function all(array $attributes = [], $limit = null)
    {
        return BikeModel::where(function($query) use ($attributes) {
            if (isset($attributes['search'])) {
                $query->where('name', 'like', '%' . $attributes['search'] . '%');
            }
        })
        ->limit($limit)
        ->get();
    }

    /**
     * First Bike Model by int
     *
     * @param  int  $int
     * @return Collection
     */
    public function firstById(int $int)
    {
        return BikeModel::where('id', $int)->first();
    }

    /**
     * First Bike Model by uuid
     *
     * @param  string  $uuid
     * @return Collection
     */
    public function firstByUuid(string $uuid)
    {
        return BikeModel::where('uuid', $uuid)->first();
    }

    /**
     * Create Bike Model
     *
     * @param  array  $attributes
     * @throws Exception
     */
    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();

            $attributes['status'] = CommonStatusEnum::ACTIVE->value;
            $bikeModel            = BikeModel::create($attributes);

            DB::commit();

            return $bikeModel;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Update Bike Model
     *
     * @param  array  $attributes
     * @param  string  $uuid
     * @throws Exception
     */
    public function update(array $attributes, string $uuid)
    {
        try {
            DB::beginTransaction();

            $bikeModel = BikeModel::where('uuid', $uuid)->update($attributes);

            DB::commit();

            return $bikeModel;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Delete Bike Model
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(string $uuid): bool
    {

        try {
            DB::beginTransaction();

            BikeModel::where('uuid', $uuid)->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Activate Bike Model
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function activate(string $uuid): bool
    {
        try {
            DB::beginTransaction();

            BikeModel::where('uuid', $uuid)->update([
                'status' => CommonStatusEnum::ACTIVE->value,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Suspend Bike Model
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function suspend(string $uuid): bool
    {
        try {
            DB::beginTransaction();

            BikeModel::where('uuid', $uuid)->update([
                'status' => CommonStatusEnum::IN_ACTIVE->value,
            ]);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

}
