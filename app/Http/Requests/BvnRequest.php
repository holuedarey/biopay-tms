<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BvnRequest extends FormRequest
{
    public User $agent;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->agent = $this->user ?? $this->user();

        return $this->user()->can('update', $this->agent);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bvn' => ['digits:11', 'unique:users,bvn'],
        ];
    }

    public function passedValidation()
    {
        // Todo: Implement BVN Validation with a provider and updated level.

        $this->agent->update(['bvn' => $this->input('bvn')]);
    }
}
