<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;

class Wallets extends Controller
{
    public function index()
    {
        $wallet = auth()->user()->wallet;

        return MyResponse::success('Wallet summary loaded.', [
            'wallet' => $wallet->only(['account_number', 'balance', 'status', 'updated_at']),
            'summary' => $wallet->getSummary(),
            'services' => auth()->user()->transactionStats(),
        ]);
    }
}
