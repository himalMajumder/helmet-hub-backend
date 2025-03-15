<?php

namespace App\Imports;

use App\Models\BikeModel;
use App\Services\ProductService;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToArray, WithValidation, WithHeadingRow
{
    /**
     * LabourHourImport constructor
     *
     * @param  EmployeeService  $employeeService
     * @param int $userId
     */
    public function __construct(
        private ProductService $productService,
        private int $userId
    ) {

    }

    /**
     * @param array $rows
     */
    public function array(array $rows)
    {

        foreach ($rows as $row) {
            $bikeModel = BikeModel::where('uuid', $row['bike_model_id'])->first();

            $productData = [
                'name'              => $row['name'],
                'bike_model_id'     => $bikeModel->id,
                'model_number'      => $row['model_number'],
                'type'              => $row['type'],
                'size'              => $row['size'],
                'color'             => $row['color'],
                'price'             => $row['price'],
                'warranty_duration' => $row['warranty_duration'],
                'user_id'           => $this->userId,
            ];
            $this->productService->create($productData);
        }

    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:191'],
            'bike_model_id'     => ['required', 'string', 'size:36', Rule::exists(BikeModel::class, 'uuid')],
            'model_number'      => ['required', 'max:191'],
            'type'              => ['required', 'max:191'],
            'size'              => ['required', 'max:191'],
            'color'             => ['required', 'string', 'max:191'],
            'price'             => ['nullable', 'numeric', 'max:191'],
            'warranty_duration' => ['required', 'numeric'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required'              => 'Product Name field is required.',
            'bike_model_id.required'     => 'Bike Model field is required.',
            'model_number.required'      => 'Model Number field is required.',
            'type.required'              => 'Type field is required.',
            'size.required'              => 'Size field is required.',
            'color.required'             => 'Color field is required.',
            'warranty_duration.required' => 'Warranty Duration field is required.',
        ];
    }

}
