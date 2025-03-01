<?php

namespace App\Services;

use App\Enums\AuthGuardEnum;
use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * RoleService constructor
     *
     */
    public function __construct(
    ) {
    }

    /**
     * All Role
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function all(array $attributes = [], $limit = null)
    {
        return Role::where(function ($query) use ($attributes) {

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
     * All Role
     *
     * @param  array  $attributes
     * @return Collection
     */
    public function allWithPermissions(array $attributes = [], $limit = null)
    {
        return Role::with('permissions')->where(function ($query) use ($attributes) {

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
     * First Role by int
     *
     * @param  int  $int
     * @return Collection
     */
    public function firstById(int $int)
    {
        return Role::where('id', $int)->first();
    }

    /**
     * First Role by int
     *
     * @param  int  $int
     * @return Collection
     */
    public function firstWithPermissionsById(int $int)
    {
        return Role::with('permissions')->where('id', $int)->first();
    }

    /**
     * Create Role
     *
     * @param  array  $attributes
     * @throws Exception
     */
    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();
            $permissions = $attributes['permissions'];

            $role = Role::create([
                'name'       => $attributes['name'],
                'guard_name' => AuthGuardEnum::ADMIN->value,
            ]);

            if ($permissions) {
                $role->syncPermissions($permissions);
            }

            DB::commit();

            return $role;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Update Role
     *
     * @param  array  $attributes
     * @param  int  $id
     * @throws Exception
     */
    public function update(array $attributes, int $id)
    {

        try {
            DB::beginTransaction();
            $permissions = $attributes['permissions'];

            $role = Role::where('id', $id)->update([
                'name' => $attributes['name'],
            ]);

            $role = $this->firstById($id);

            if ($permissions) {
                $role->syncPermissions($permissions);
            }

            DB::commit();

            return $role;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

    /**
     * Delete Role
     *
     * @param  int  $id
     * @return bool
     * @throws Exception
     */
    public function destroy(int $id): bool
    {

        try {
            DB::beginTransaction();

            $role = $this->firstById($id);

            if ($role) {
                $role->syncPermissions([]);
            }


            $role->delete();

            DB::commit();

            return true;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }

    }

}
