<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    use ApiResponse;

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

        $data = [
            'token' => $user->createToken('my-app-token')->plainTextToken,
            'user'  => $user,
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
    public function user(Request $request): JsonResponse
    {
        $user = $request->user()->toArray();

        return $this->successResponse($user);
    }

}
