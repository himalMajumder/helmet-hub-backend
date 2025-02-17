<?php

namespace App\Services;

use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    /**
     * CustomerService constructor
     *
     */
    public function __construct(
    ) {
    }

    /**
     * All steel
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function all(array $attributes = [])
    {
        return Customer::get();
    }

    /**
     * Create Customer
     *
     * @param  array  $attributes
     * @throws Exception
     */
    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();

            $customer = Customer::create($attributes);

            DB::commit();

            return $customer;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Delete Customer
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(string $uuid): bool
    {

        try {
            DB::beginTransaction();

            Customer::where('uuid', $uuid)->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

}
