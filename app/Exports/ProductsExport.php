<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Excel;

class ProductsExport implements FromArray, WithHeadings, Responsable
{
    use Exportable;

    /**
     * ProductsExport constructor
     * @param array $exportData
     */
    public function __construct(
        protected array $exportData,
    ) {
    }

    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private string $fileName = 'products_template.csv';

    /**
     * Optional Writer Type
     */
    private string $writerType = Excel::CSV;

    /**
     * Optional headers
     */
    private array $headers = [
        'Content-Type' => 'text/csv',
    ];

    /**
     * @inheritdoc
     */
    public function array(): array
    {
        $data = [];

        foreach ($this->exportData['bikeModels'] as $exportDatum) {
            $data[] = [
                null,
                $exportDatum['uuid'],
                null,
                null,
                null,
                null,
                null,
                null,
            ];
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function headings(): array
    {
        $heading = [
            'name',
            'bike_model_id',
            'model_number',
            'type',
            'size',
            'color',
            'price',
            'warranty_duration',
        ];

        return $heading;
    }

}
