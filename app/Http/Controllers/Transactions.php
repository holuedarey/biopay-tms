<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Helpers\MyResponse;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Transactions extends Controller
{
    public function index(Request $request)
    {
        $request->user()->can('read transactions');

        return view('pages.transactions.index');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->user()->can('update transactions');

        $request->validate([
            'status' => ['required', Rule::in([Status::SUCCESSFUL->value, Status::FAILED->value])]
        ]);

        $transaction->update(['status' => $status = $request->get('status')]);

        if ($status == Status::FAILED->value && $transaction->wallet_debited) {
            $transaction->agent->wallet->credit($transaction->total_amount, $transaction->service, info: "REVERSAL:: $transaction->info");
        }

        return back()->with('success', "Transaction marked as $status!");
    }
}
