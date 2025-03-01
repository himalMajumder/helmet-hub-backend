<?php

namespace App\Services;

use App\Enums\CommonStatusEnum;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * UserService constructor
     *
     */
    public function __construct(
    ) {
    }

    /**
     * All User
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function all(array $attributes = [], $limit = null)
    {
        return User::where(function ($query) use ($attributes) {
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
     * First User by int
     *
     * @param  int  $int
     * @return Collection
     */
    public function firstById(int $int)
    {
        return User::where('id', $int)->first();
    }

    /**
     * First User by uuid
     *
     * @param  string  $uuid
     * @return Collection
     */
    public function firstByUuid(string $uuid)
    {
        return User::where('uuid', $uuid)->first();
    }

    /**
     * Create User
     *
     * @param  array  $attributes
     * @throws Exception
     */
    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();

            $attributes['status']   = CommonStatusEnum::ACTIVE->value;
            $attributes['password'] = bcrypt($attributes['password']);
            $user                   = User::create($attributes);

            DB::commit();

            return $user;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Update User
     *
     * @param  array  $attributes
     * @param  string  $uuid
     * @throws Exception
     */
    public function update(array $attributes, string $uuid)
    {
        try {
            DB::beginTransaction();

            if ($attributes['password']) {
                $attributes['password'] = bcrypt($attributes['password']);
            } else {
                unset($attributes['password']);
            }

            $user = User::where('uuid', $uuid)->update($attributes);

            DB::commit();

            return $user;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Delete User
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(string $uuid): bool
    {

        try {
            DB::beginTransaction();

            User::where('uuid', $uuid)->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Activate User
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function activate(string $uuid): bool
    {
        try {
            DB::beginTransaction();

            User::where('uuid', $uuid)->update([
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
     * Suspend User
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function suspend(string $uuid): bool
    {
        try {
            DB::beginTransaction();

            User::where('uuid', $uuid)->update([
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
