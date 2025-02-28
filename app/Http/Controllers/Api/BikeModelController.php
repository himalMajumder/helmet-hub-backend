<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BikeModelRequest;
use App\Http\Resources\BikeModelResource;
use App\Models\BikeModel;
use App\Services\BikeModelService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BikeModelController extends Controller
{
    use ApiResponse;

    /**
     * BikeModelController constructor
     *
     * @param  BikeModelService  $bikeModelService
     */
    public function __construct(protected BikeModelService $bikeModelService)
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

        $customer = $this->bikeModelService->all();

        $data = [
            'bikeModels' => BikeModelResource::collection($customer),
        ];

        return $this->successResponse($data);
    }

    /**
     * Bike Model Registration
     *
     * @param BikeModelRequest $request
     * @return JsonResponse
     */
    public function create(BikeModelRequest $request): JsonResponse
    {
        $user       = $request->user();
        $attributes = $request->validated();

        $data = [
            'user'       => $user,
            'attributes' => $attributes,
        ];

        $this->bikeModelService->create($attributes);

        return $this->successResponse($data, 'Bike Model created successfully');
    }

    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->bikeModelService->destroy($uuid);

        $data = [
            'user' => $user,
            'uuid' => $uuid,
        ];

        return $this->successResponse($data, 'Bike Model deleted successfully');
    }
}
