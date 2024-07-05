<?php

namespace App\Http\Controllers\WebApi;

use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Http\Requests\TerminalTransactionRequest;
use App\Http\Resources\LoanResource;
use App\Models\Loan;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Loans extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Loan::class);
    }

    public function index()
    {
        return MyResponse::success('Loans fetched',
            LoanResource::collection(Loan::viewable()->latest()->get())
        );
    }

    public function store(TerminalTransactionRequest $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'items' => 'required|array',
            'info' => 'nullable|string'
        ]);

        \DB::transaction(function () use ($request) {
            $reference = General::generateReference();

            $amount = $request->float('amount');

            $info = $request->get('info', 'Loan request for ' . moneyFormat($amount));

            $service = Service::whereSlug('loan')->first();

            // Create loan transaction
            $t = Transaction::createPendingFor($request->terminal, $service, $amount, $amount, $reference, $info, 'INTERNAL');

            $request->merge(['transaction_id' => $t->id]);

            // Create loan
            auth()->user()->loans()->create($request->only(['items', 'info', 'amount', 'transaction_id']));
        });

        return MyResponse::success('Loan request created.');
    }


    public function update(LoanRequest $request, Loan $loan)
    {
        return MyResponse::success('Loan status updated', $loan->refresh());
    }

    public function destroy(Loan $loan)
    {
        if (! $loan->isConfirmed()) {
            $loan->delete();
            return MyResponse::success('Loan request deleted.');
        }

        return MyResponse::failed('Loan request cannot be deleted. Already approved.');
    }
}
