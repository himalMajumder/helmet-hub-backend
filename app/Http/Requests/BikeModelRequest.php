<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BikeModelRequest extends FormRequest
{
    /**
     * Bike Model uuid
     *
     * @var string|null
     */
    private ?string $bikeModelUuid;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => ['required'],
            'detail' => ['nullable'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->bikeModelUuid = $this->route('bike_model');
    }
}
