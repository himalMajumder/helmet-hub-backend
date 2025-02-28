<?php

namespace App\Services;

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
    public function all(array $attributes = [])
    {
        return BikeModel::get();
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

            $bikeModel = BikeModel::create($attributes);

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

}
