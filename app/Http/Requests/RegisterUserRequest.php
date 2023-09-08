<?php

namespace App\Http\Requests;

use App\Helpers\RoleHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{

    public string $name;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|string',
            'other_names'   => 'required|string',
            'email'     => ['required', 'email:dns,rfc', 'unique:users,email'],
            'phone'     => ['required', 'digits:11', 'unique:users,phone'],
            'state'     => 'required|string',
            'address'   => 'required|string',
            'dob'       => 'required|date',
            'gender'    => 'required',
            'role'      => 'required|exists:roles,name',
            'super_agent_id' => 'nullable|exists:users,id'
        ];
    }
}
