<?php

namespace App\Http\Requests;

use App\Exceptions\FailedApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends TerminalTransactionRequest
{
    const NAME = 'bank transfer';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bank_code' => 'required|string',
            'account_number' => 'required|string|size:10',
            'account_name' => 'required|string',
            'bank' => 'nullable|string',
            'amount' => 'required|numeric|min:100',
            'narration' => 'nullable|string',
            'paymentData' => 'required|array'
        ];
    }
}
