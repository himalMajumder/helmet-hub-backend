<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\Permission\UserPermissionEnum;
use App\Enums\AuthGuardEnum;
use Spatie\Permission\Models\Permission;
use App\Enums\Permission\RolePermissionEnum;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = AuthGuardEnum::ADMIN->value;
        $modules   = [
            [
                'module'        => 'User',
                'sorting_order' => 1000,
                'permissions'   => UserPermissionEnum::toArray(),
            ],
            [
                'module'        => 'Role',
                'sorting_order' => 2000,
                'permissions'   => RolePermissionEnum::toArray(),
            ],
        ];

        $permissions = [];

        foreach ($modules as $module) {
            foreach ($module['permissions'] as $permission) {
                // ignore existing permission
                $permissionExists = Permission::query()
                                              ->where('guard_name', $guardName)
                                              ->where('name', $permission)
                                              ->exists();

                if (!$permissionExists) {
                    $permissions[] = [
                        'module'        => $module['module'],
                        'sorting_order' => $module['sorting_order'],
                        'name'          => $permission,
                        'guard_name'    => $guardName,
                    ];
                }
            }
        }

        if (!empty($permission)) {
            Permission::query()
                      ->insert($permissions);
        }
    }
}
