<?php

namespace App\Http\Controllers\WebApi;

use App\Enums\Action;
use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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



    public function update(Request $request, Wallet $wallet)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'action' => ['required', Rule::in(Action::values())],
            'info' => 'required|string|max:100'
        ]);

        $action = $request->get('action');

        Approval::create([
            'approvalable_type' => Wallet::class,
            'approvalable_id' => $wallet->id,
            'performed_by' => auth()->id(),
            'new_data' => [
                'info' => $request->get('info') . ' - By ' . auth()->user()->name,
                'account_number' => $wallet->account_number,
                'account_holder' => $wallet->agent->name,
                'amount' => (float) $request->get('amount'),
                'action' => $action,
            ]
        ]);

        return back()->with('pending', "Awaiting approval for wallet $action!");
    }
}
