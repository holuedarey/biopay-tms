<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Models\GeneralLedger;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(Status::forLoans())],
            'decline_reason' => 'required_if:status,' . Status::DECLINED->value,
            'amount' => ['nullable', 'numeric', 'min:500', 'max:' . $this->loan->amount,
                Rule::prohibitedIf($this->status != Status::APPROVED->value)
            ]
        ];
    }

    protected function passedValidation(): void
    {
        // If confirmation is to be done by admin
        if ($this->status == Status::CONFIRMED->value) {
            // If the loan ledger balance is less than the requested amount
            if (GeneralLedger::forService('loan')->first()->balance < $this->loan->amount) {
                throw ValidationException::withMessages([
                    'status' => 'Insufficient loan ledger balance.'
                ]);
            }
        }

        $this->loan->update($this->only(['status', 'decline_reason']));
    }
}
