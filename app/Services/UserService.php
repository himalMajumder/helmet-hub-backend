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
     * All User
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function allWithRoles(array $attributes = [], $limit = null)
    {
        return User::with('roles')
            ->where(function ($query) use ($attributes) {

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
        return User::with('roles')->where('uuid', $uuid)->first();
    }

     /**
     * First User with roles and permissions by id
     *
     * @param  int  $id
     * @return Collection
     */
    public function firstWithRolesPermissionsById(int $id)
    {
        return User::with('roles.permissions')->where('id', $id)->first();
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
            $role_ids = [];

            if ($attributes['role']) {
                $role_ids = $attributes['role'];
            }

            unset($attributes['role']);

            $attributes['status']   = CommonStatusEnum::ACTIVE->value;
            $attributes['password'] = bcrypt($attributes['password']);
            $user                   = User::create($attributes);

            $user->syncRoles($role_ids);

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

            $role_ids = [];

            if ($attributes['role']) {
                $role_ids = $attributes['role'];
            }

            unset($attributes['role']);

            $user = User::where('uuid', $uuid)->first();
            $user->update($attributes);

            $user->syncRoles($role_ids);

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
