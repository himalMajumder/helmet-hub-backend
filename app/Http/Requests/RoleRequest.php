<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleRequest extends FormRequest
{
    /**
     * Role uuid
     *
     * @var string|null
     */
    private ?string $roleId;

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
        $uniqueRule = Rule::unique(Role::class);

        if ($this->roleId) {
            $uniqueRule->ignore($this->roleId);
        }

        return [
            'name'          => ['required', 'min:3', $uniqueRule],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['required', 'integer'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->roleId = $this->route('role');
    }

}
