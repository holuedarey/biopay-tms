<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataPurchaseRequest extends TerminalTransactionRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required',
            'network' => 'required',
            'amount' => 'required|numeric|min:50',
            'phone' => 'required|digits:11',
            'paymentData' => 'array'
        ];
    }
}
