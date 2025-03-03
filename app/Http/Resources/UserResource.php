<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Permission;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'uuid'        => $this->uuid,
            'name'        => $this->name,
            'email'       => $this->email,
            'status'      => $this->status,
            'super_admin' => $this->super_admin,
        ];

        $permissions = $this->permissions->pluck('id')->toArray();

        if ($this->relationLoaded('roles')) {

            foreach ($this->roles as $role) {
                $permissions = array_merge($permissions, $role->permissions->pluck('id')->toArray());
                $role->unsetRelation('permissions');
            }

            $data['roles'] = RoleResource::collection($this->roles);

        }

        $permissions = array_unique($permissions);

        $mergedPermissions = Permission::whereIn('id', $permissions)->get();

        if ($mergedPermissions) {
            $data['permissions'] = PermissionResource::collection($mergedPermissions);
        }

        return $data;
    }

}
