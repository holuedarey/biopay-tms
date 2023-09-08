<?php

namespace App\Http\Requests;

use App\Rules\LimitIsLess;
use App\Rules\UniqueLevel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class KycLevelRequest extends FormRequest
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
        return $this->routeIs('kyc-levels.store') ?
            $this->createRequest() : $this->updateRequest();
    }

    private function createRequest(): array
    {
        return [
            'name'          => ['required','string', 'unique:kyc_levels,name'],
            'daily_limit'   => ['required', 'numeric', 'max:' . $this->max_balance],
            'single_trans_max' => ['required', 'numeric', 'max:' .  $this->daily_limit],
            'max_balance'   => 'required|numeric',
        ];
    }

    private function updateRequest(): array
    {
        return [
            'name'              => ['string', Rule::unique('kyc_levels', 'name')->ignoreModel($this->kyc_level)],
            'daily_limit'       => ['numeric', 'max:' . $this->max_balance],
            'single_trans_max'  => ['numeric', 'max:' .  $this->daily_limit],
            'max_balance'       => 'required|numeric',
        ];
    }

    protected function passedValidation()
    {
        Cache::forget('kyc-levels');
    }
}
