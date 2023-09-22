<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Terminal;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Transactions extends Controller
{
    public function index(Request $request)
    {
        $transactions = TransactionResource::collection(
            Terminal::forAuthDevice()
                ->transactions()->latest()
                ->paginate($request->get('limit', 100))
        );

        return MyResponse::success('Transactions fetched.', $transactions);
    }

    public function show(Transaction $transaction) {
        return MyResponse::success('Transaction details', $transaction);
    }
}
