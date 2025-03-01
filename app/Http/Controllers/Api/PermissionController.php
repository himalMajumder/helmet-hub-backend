<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use ApiResponse;

    /**
     * PermissionController constructor
     *
     * @param  PermissionService  $permissionService
     */
    public function __construct(protected PermissionService $permissionService)
    {
    }

    /**
     * Index
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

        $permissions = $this->permissionService->all($attributes);
        $data  = resource_to_array(PermissionResource::collection($permissions));

        return $this->successResponse($data, 'Permissions found successfully');
    }

}
