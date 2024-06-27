<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
//    public function rules(): array
//    {
//        $prohibited = Rule::prohibitedIf(!$this->user()->isAdmin());
//        $unique = Rule::unique('users')->ignoreModel($this->user);
//
//        return [
//            'first_name' => 'string',
//            'other_names' => 'string',
//            'email' => ['email:rfc,dns', $unique],
//            'phone' => ['digits:11', $unique],
//            'gender' => 'nullable|in:MALE,FEMALE',
//            'state' => [$prohibited, 'nullable',  'string'],
//            'address' => [$prohibited, 'nullable', 'string'],
//            'dob' => 'nullable|date',
//            'status' => [$prohibited, 'nullable', Rule::in(User::ALL_STATUS)],
//            'password' => 'confirmed',
//            'current' => 'required_with:password|current_password',
//            'avatar' => 'image|max:2000'
//        ];
//    }
    public function rules(): array
    {
        $prohibited = Rule::prohibitedIf(!$this->user()->isAdmin());
        $unique = Rule::unique('users');

        // Ensure the $this->user() is not null and has the necessary methods.
        $user = $this->user();

        if ($user) {
            $unique->ignore($user->getKey(), $user->getKeyName());
        }

        return [
            'first_name' => 'string',
            'other_names' => 'string',
            'email' => ['email:rfc,dns', $unique],
            'phone' => ['digits:11', $unique],
            'gender' => 'nullable|in:MALE,FEMALE',
            'state' => [$prohibited, 'nullable',  'string'],
            'address' => [$prohibited, 'nullable', 'string'],
            'dob' => 'nullable|date',
            'status' => [$prohibited, 'nullable', Rule::in(User::ALL_STATUS)],
            'password' => 'confirmed',
            'current' => 'required_with:password|current_password',
            'avatar' => 'image|max:2000'
        ];
    }
}
