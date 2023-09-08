<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ElectricityPurchaseRequest extends TerminalTransactionRequest
{
    const NAME = 'electricity bill';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required|numeric|min:100',
            'code' => 'required',
            'type' => 'required|in:prepaid,postpaid',
            'meterNo' => 'required',
            'phone' => 'required|digits:11',
            'paymentData' => 'required|array'
        ];
    }
}
