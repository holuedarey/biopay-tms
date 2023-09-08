<?php

namespace App\Http\Requests;

use App\Helpers\AppConfig;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->routeIs('roles.store') ?
            $this->createRequest() : $this->updateRequest();
    }

    public function createRequest(): array
    {
        return [
            'name' => 'required|string|unique:roles,name',
            'type' => ['required', Rule::in(User::GROUPS)],
            'permissions' => 'nullable|array'
        ];
    }

    public function updateRequest(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('roles', 'name')->ignoreModel($this->role)],
            'permissions' => 'nullable|array'
        ];
    }
}
