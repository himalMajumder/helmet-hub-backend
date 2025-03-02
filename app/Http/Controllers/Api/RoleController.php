<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ApiResponse;

    /**
     * RoleController constructor
     *
     * @param  RoleService  $roleService
     */
    public function __construct(protected RoleService $roleService)
    {
    }

    /**
     * All Role
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $attributes = [];
        $search     = $request->get('search') ?? null;

        if ($search) {
            $attributes['search'] = $search;
        }

        $roles = $this->roleService->all($attributes);

        $data  = resource_to_array(RoleResource::collection($roles));

        return $this->successResponse($data, 'Roles found successfully');
    }

     /**
     * Search Role
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function rolesWithPermissions(Request $request): JsonResponse
    {
        $attributes = [];

        $roles = resource_to_array(RoleResource::collection($this->roleService->all($attributes, 'permissions')));

        return $this->successResponse($roles, 'Roles found successfully');
    }

    /**
     * Search Role
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $attributes = [];
        $search     = $request->get('search') ?? null;

        if ($search) {
            $attributes['search'] = $search;
        }

        $roles = resource_to_array(RoleResource::collection($this->roleService->all($attributes)));

        return $this->successResponse($roles, 'Roles found successfully');
    }

    /**
     * Store a Role
     *
     * @param RoleRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function store(RoleRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $user       = $this->roleService->create($attributes);
        $data       = resource_to_array(new RoleResource($user));

        return $this->successResponse($data, 'Role created successfully');
    }

    /**
     * Show a Role
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $data = resource_to_array(new RoleResource($this->roleService->firstWithPermissionsById($id)));

        return $this->successResponse($data, 'Role found successfully');
    }

    /**
     * Update a Role
     *
     * @param RoleRequest $request
     * @param int $id
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function update(RoleRequest $request, string $id): JsonResponse
    {
        $attributes = $request->validated();

        $this->roleService->update($attributes, $id);

        $user = resource_to_array(new RoleResource($this->roleService->firstById($id)));

        return $this->successResponse($user, 'Role updated successfully');
    }

    /**
     * Delete a Role
     *
     * @param RoleRequest $request
     * @param int $id
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->roleService->destroy($id);

        return $this->successResponse([], 'Role deleted successfully');
    }

}
