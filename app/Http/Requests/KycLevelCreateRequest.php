<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class KycLevelCreateRequest extends FormRequest
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
            'name'          => ['required','string', 'unique:kyc_levels,name'],
            'daily_limit'   => ['required', 'numeric', 'max:' . $this->max_balance],
            'single_trans_max' => ['required', 'numeric', 'max:' .  $this->daily_limit],
            'max_balance'   => 'required|numeric',
        ];
    }

    protected function passedValidation()
    {
        Cache::forget('kyc-levels');
    }
}
