<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
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
     * Undocumented function
     *
     * @param LoginRequest $request
     * @throws ValidationException
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $user = User::where('email', $attributes['email'])->first();

        if (!$user || !Hash::check($attributes['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = $this->userService->firstWithRolesPermissionsById($user->id);

        $data = [
            'token' => $user->createToken('my-app-token', ['*'], now()->addHours(2))->plainTextToken,
            'user'  => resource_to_array(new UserResource($user)),

        ];

        return $this->successResponse($data);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->tokens()->delete();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }

    /**
     * User
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $user = $this->userService->firstWithRolesPermissionsById($user->id);
        $user = resource_to_array(new UserResource($user));

        return $this->successResponse($user);
    }

}
