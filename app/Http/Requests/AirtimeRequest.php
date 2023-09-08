<?php

namespace App\Http\Requests;

use App\Enums\Network;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AirtimeRequest extends TerminalTransactionRequest
{
    const NAME = 'airtime';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'network'       => ['required', Rule::in(Network::values())],
            'amount'        => 'required|numeric|min:50',
            'phone'         => 'required|digits:11',
        ];
    }
}
