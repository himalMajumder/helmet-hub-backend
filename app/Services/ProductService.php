<?php

namespace App\Services;

use App\Enums\CommonStatusEnum;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * ProductService constructor
     *
     * @param  BikeModelService  $bikeModelService
     */
    public function __construct(
        protected BikeModelService $bikeModelService
    ) {
    }

    /**
     * All Product
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function all(array $attributes = [], $limit = null)
    {
        return Product::with('bikeModel')->where(function ($query) use ($attributes) {

            if (isset($attributes['search'])) {
                $query->where('name', 'like', '%' . $attributes['search'] . '%');
            }

        })
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
            ->get();
    }

    /**
     * First Product by int
     *
     * @param  int  $int
     * @return Collection
     */
    public function firstById(int $int)
    {
        return Product::where('id', $int)->first();
    }

    /**
     * First Product by uuid
     *
     * @param  string  $uuid
     * @return Collection
     */
    public function firstByUuid(string $uuid)
    {
        return Product::where('uuid', $uuid)->first();
    }

    /**
     * Form data of product
     *
     * @return array
     */
    public function exportFormData(): array
    {
        $bikeModels = $this->bikeModelService->all(['status' => CommonStatusEnum::ACTIVE->value]);

        return compact('bikeModels');
    }

    /**
     * Create Product
     *
     * @param  array  $attributes
     * @throws Exception
     */
    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();

            $attributes['status'] = CommonStatusEnum::ACTIVE->value;
            $product              = Product::create($attributes);

            DB::commit();

            return $product;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Create Many Product
     *
     * @param  array  $attributes
     * @throws Exception
     */
    public function createMany(array $attributes)
    {
        try {
            array_walk($attributes, function (&$attribute) {
                $attribute['status'] = CommonStatusEnum::ACTIVE->value;
            });

            DB::beginTransaction();

            Product::insert($attributes);

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Update Product
     *
     * @param  array  $attributes
     * @param  string  $uuid
     * @throws Exception
     */
    public function update(array $attributes, string $uuid)
    {
        try {
            DB::beginTransaction();

            $product = Product::where('uuid', $uuid)->update($attributes);

            DB::commit();

            return $product;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Delete Product
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(string $uuid): bool
    {

        try {
            DB::beginTransaction();

            Product::where('uuid', $uuid)->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Activate Product
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function activate(string $uuid): bool
    {
        try {
            DB::beginTransaction();

            Product::where('uuid', $uuid)->update([
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
     * Suspend Product
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function suspend(string $uuid): bool
    {
        try {
            DB::beginTransaction();

            Product::where('uuid', $uuid)->update([
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
