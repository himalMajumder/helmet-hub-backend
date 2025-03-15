<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportRequest extends FormRequest
{

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
            'file' => ['required', 'mimes:csv,txt', 'max:2048'], // Allowing 'txt' as some CSV files may be detected as text/plain
            // 'file' => ['required', 'max:2048', 'file', function ($attribute, $value, $fail) {
            //     if ($value->getClientOriginalExtension() !== 'csv') {
            //         $fail('The file must be a CSV.');
            //     }
            // },
            // ],
        ];
    }

}
