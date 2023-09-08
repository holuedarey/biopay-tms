<?php

namespace App\Http\Requests;

use App\Models\GeneralLedger;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GlRequest extends FormRequest
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
        return request()->routeIs('general-ledger.update') ? $this->updateRequest() : $this->showRequest();
    }

    /**
     * Ensure that the service slug exists when available in the request.
     *
     * @return array|string[]
     */
    private function showRequest(): array
    {
        return $this->has('service') ? ['service' => 'exists:services,slug'] : [];
    }


    /**
     * Validate the amount for the gl update.
     *
     * @return string[]
     */
    public function updateRequest(): array
    {
        return ['amount' => 'required|numeric|min:50'];
    }

    public function messages(): array
    {
        return ['amount.min' => 'Invalid amount'];
    }
}
