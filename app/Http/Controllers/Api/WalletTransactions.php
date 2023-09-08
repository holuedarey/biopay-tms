<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletTransactions extends Controller
{
    public function index(Request $request)
    {
        $transactions = auth()->user()->walletTransactions()->latest()
            ->without('wallet')->paginate($request->get('limit'));

        return MyResponse::success('Wallet transactions fetched.', $transactions);
    }
}
