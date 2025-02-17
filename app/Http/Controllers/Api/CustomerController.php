<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegistrationRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponse;

    /**
     * CustomerController constructor
     *
     * @param  CustomerService  $customerService
     */
    public function __construct(protected CustomerService $customerService)
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
        $user = $request->user();

        $customer = $this->customerService->all();

        $data = [
            'customers' => CustomerResource::collection($customer),
        ];

        return $this->successResponse($data);
    }

    /**
     * Customer Registration
     *
     * @param CustomerRegistrationRequest $request
     * @return JsonResponse
     */
    public function registration(CustomerRegistrationRequest $request): JsonResponse
    {
        $user       = $request->user();
        $attributes = $request->validated();

        $data = [
            'user'       => $user,
            'attributes' => gettype($attributes),
        ];

        $this->customerService->create($attributes);

        return $this->successResponse($data, 'Customer created successfully');
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->customerService->destroy($uuid);

        $data = [
            'user' => $user,
            'uuid' => $uuid,
        ];

        return $this->successResponse($data, 'Customer deleted successfully');
    }
}
