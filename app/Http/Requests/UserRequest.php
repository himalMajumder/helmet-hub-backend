<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRequest extends FormRequest
{
    /**
     * User uuid
     *
     * @var string|null
     */
    private ?string $userUuid;

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
        $uniqueRule    = Rule::unique(User::class);
        $password_rule = ['required', 'min:6'];

        if ($this->userUuid) {
            $uniqueRule->ignore($this->userUuid, 'uuid');
            $password_rule = ['nullable', 'min:6'];
        }

        return [
            'name'     => ['required', 'min:3'],
            'email'    => ['required', 'email', $uniqueRule],
            'password' => $password_rule,
            'role'     => ['nullable', 'array'],
            'role.*'   => ['integer', Rule::exists(Role::class, 'id')],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->userUuid = $this->route('user');
    }

}
