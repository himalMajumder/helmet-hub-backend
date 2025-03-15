<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * UserController constructor
     *
     * @param  UserService  $userService
     */
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * All User
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

        $users = $this->userService->allWithRoles($attributes);
        $data  = resource_to_array(UserResource::collection($users));

        return $this->successResponse($data, 'Users found successfully');
    }

    /**
     * Search User
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

        $users = $this->userService->allWithRoles($attributes);
        $data  = resource_to_array(UserResource::collection($users));

        return $this->successResponse($data, 'Users found successfully');
    }

    /**
     * Store a User
     *
     * @param UserRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $user       = $this->userService->create($attributes);

        $userResource = resource_to_array(new UserResource($user));

        return $this->successResponse($userResource, 'User created successfully');
    }

    /**
     * Show a User
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        $user = resource_to_array(new UserResource($this->userService->firstByUuid($uuid)));

        return $this->successResponse($user, 'User found successfully');
    }

    /**
     * Update a User
     *
     * @param UserRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function update(UserRequest $request, string $uuid): JsonResponse
    {
        $attributes = $request->validated();

        $this->userService->update($attributes, $uuid);

        $user = resource_to_array(new UserResource($this->userService->firstByUuid($uuid)));

        return $this->successResponse($user, 'User updated successfully');
    }

    /**
     * Delete a User
     *
     * @param UserRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $this->userService->destroy($uuid);

        return $this->successResponse([], 'User deleted successfully');
    }

    /**
     * Activate a User
     *
     * @param  string  $uuid
     * @throws AuthorizationException
     * @throws Exception
     * @return JsonResponse
     */
    public function activate(Request $request, string $uuid): JsonResponse
    {
        $this->userService->activate($uuid);

        return $this->successResponse([], 'User activated successfully');
    }

    /**
     * Suspend a User
     *
     * @param  string  $uuid
     * @throws AuthorizationException
     * @throws Exception
     * @return JsonResponse
     */
    public function suspended(Request $request, string $uuid): JsonResponse
    {
        $this->userService->suspend($uuid);

        return $this->successResponse([], 'User suspended successfully');
    }

}
