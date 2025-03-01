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
     * All Bike Model
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $attributes = [];
        $search = $request->get('search') ?? null;
        if($search){
            $attributes['search'] = $search;
        }


        $customer = $this->bikeModelService->all($attributes);

        $data = [
            'bikeModels' => BikeModelResource::collection($customer),
        ];

        return $this->successResponse($data, 'Bike Models found successfully');
    }


    /**
     * Search Bike Model
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $user = $request->user();
        $attributes = [];
        $search = $request->get('search') ?? null;
        if($search){
            $attributes['search'] = $search;
        }

        $customer = resource_to_array(BikeModelResource::collection($this->bikeModelService->all($attributes)));

        return $this->successResponse($customer, 'Bike Models found successfully');
    }

    /**
     * Store a Bike Model
     *
     * @param BikeModelRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function store(BikeModelRequest $request): JsonResponse
    {
        $user                  = $request->user();
        $attributes            = $request->validated();
        $attributes['user_id'] = $user->id;

        $bikeModel         = $this->bikeModelService->create($attributes);
        $bikeModelResource = resource_to_array(new BikeModelResource($bikeModel));

        return $this->successResponse($bikeModelResource, 'Bike Model created successfully');
    }

    /**
     * Show a Bike Model
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $bikeModel = resource_to_array(new BikeModelResource($this->bikeModelService->firstByUuid($uuid)));

        return $this->successResponse($bikeModel, 'Bike Model found successfully');
    }

    /**
     * Update a Bike Model
     *
     * @param BikeModelRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function update(BikeModelRequest $request, string $uuid): JsonResponse
    {
        $user                  = $request->user();
        $attributes            = $request->validated();
        $attributes['user_id'] = $user->id;

        $this->bikeModelService->update($attributes, $uuid);
        $bikeModel = resource_to_array(new BikeModelResource($this->bikeModelService->firstByUuid($uuid)));

        return $this->successResponse($bikeModel, 'Bike Model updated successfully');
    }

    /**
     * Delete a Bike Model
     *
     * @param BikeModelRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->bikeModelService->destroy($uuid);

        return $this->successResponse([], 'Bike Model deleted successfully');
    }

    /**
     * Activate a Bike Model
     *
     * @param  string  $uuid
     * @throws AuthorizationException
     * @throws Exception
     * @return JsonResponse
     */
    public function activate(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->bikeModelService->activate($uuid);

        return $this->successResponse([], 'Bike Model activated successfully');
    }

    /**
     * Suspend a Bike Model
     *
     * @param  string  $uuid
     * @throws AuthorizationException
     * @throws Exception
     * @return JsonResponse
     */
    public function suspended(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->bikeModelService->suspend($uuid);

        return $this->successResponse([], 'Bike Model suspended successfully');
    }

}
