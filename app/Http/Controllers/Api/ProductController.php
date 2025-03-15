<?php

namespace App\Http\Controllers\Api;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImportRequest;
use App\Http\Resources\ProductResource;
use App\Imports\ProductsImport;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    use ApiResponse;

    /**
     * ProductController constructor
     *
     * @param  ProductService  $productService
     */
    public function __construct(protected ProductService $productService)
    {
    }

    /**
     * All Product
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user       = $request->user();
        $attributes = [];
        $search     = $request->get('search') ?? null;

        if ($search) {
            $attributes['search'] = $search;
        }

        $products = $this->productService->all($attributes);
        $data     = resource_to_array(ProductResource::collection($products));

        return $this->successResponse($data, 'Products found successfully');
    }

    /**
     * Search Bike Model
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $user       = $request->user();
        $attributes = [];
        $search     = $request->get('search') ?? null;

        if ($search) {
            $attributes['search'] = $search;
        }

        $products = $this->productService->all($attributes);
        $data     = resource_to_array(ProductResource::collection($products));

        return $this->successResponse($data, 'Bike Models found successfully');
    }

    /**
     * Store a Product
     *
     * @param ProductImportRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function store(ProductImportRequest $request): JsonResponse
    {
        $user                  = $request->user();
        $attributes            = $request->validated();
        $attributes['user_id'] = $user->id;

        Excel::import(new ProductsImport(), $attributes['file']);

        return response()->json($attributes);

        dd($attributes);

        $bikeModel         = $this->productService->create($attributes);
        $bikeModelResource = resource_to_array(new BikeModelResource($bikeModel));

        return $this->successResponse($bikeModelResource, 'Product created successfully');
    }

    /**
     * Store a Product
     *
     * @param ProductImportRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function storeImport(ProductImportRequest $request): JsonResponse
    {
        $user   = $request->user();
        $userId = $user->id;
        Excel::import(new ProductsImport($this->productService, $userId), $request->file('file'));

        return $this->successResponse([], 'Product imported successfully');
    }

    /**
     * Import Template Download
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function importTemplate(Request $request): JsonResponse
    {
        $fileName = 'products_template.csv';
        $filePath = 'templates/' . $fileName;

        $exportData = $this->productService->exportFormData();

        Excel::store(new ProductsExport($exportData), $filePath, 'public');

        $downloadUrl = Storage::url($filePath);

        $data = [
            'download_url' => url($downloadUrl),
        ];

        return $this->successResponse($data, 'Product CSV template found successfully');
    }

    /**
     * Activate a Product
     *
     * @param  string  $uuid
     * @throws AuthorizationException
     * @throws Exception
     * @return JsonResponse
     */
    public function activate(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->productService->activate($uuid);

        return $this->successResponse([], 'Product activated successfully');
    }

    /**
     * Suspend a Product
     *
     * @param  string  $uuid
     * @throws AuthorizationException
     * @throws Exception
     * @return JsonResponse
     */
    public function suspended(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->productService->suspend($uuid);

        return $this->successResponse([], 'Product suspended successfully');
    }

    /**
     * Delete a Product
     *
     * @param BikeModelRequest $request
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function destroy(Request $request, string $uuid): JsonResponse
    {
        $user = $request->user();

        $this->productService->destroy($uuid);

        return $this->successResponse([], 'Product deleted successfully');
    }

}
