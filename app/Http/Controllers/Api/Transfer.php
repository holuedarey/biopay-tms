<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Helpers\Purchase;
use App\Helpers\WalletHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Models\Service;
use App\Models\Terminal;
use App\Services\Transfer as TransferService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Transfer extends Controller
{

    public function index(Request $request)
    {
        $provider = TransferService::provider();
        $service = Service::whereSlug(TransferService::NAME)->firstOrFail();
        $terminal = Terminal::forAuthDevice();

        $request->validate([
            'account_number' => 'required|string|size:10',
            'bank_code' => ['required', 'string',
                Rule::exists('banks', 'code')->where('provider', $provider::name())
            ],
            'amount' => 'required|numeric|min:100'
        ]);

        $charge = $terminal->group->charge($service, $request->amount);

        $res = $provider->validateAccount($request->bank_code, $request->account_number);

        return $res->success ? MyResponse::success('Account validated', $res->data->put('charge', $charge)):
            MyResponse::failed($res->message);
    }

    /**
     * Handle the incoming request.
     */
    public function store(TransferRequest $request)
    {
        $provider = TransferService::provider();
        $service = Service::whereSlug(TransferService::NAME)->firstOrFail();

        $reference = General::generateReference();

        $amount = (float) $request->get('amount');
        $bank = $request->get('bank');
        $bank_code = $request->get('bank_code');
        $account_number = $request->get('account_number');
        $account_name = $request->get('account_name');

        $charge = $request->terminal->group->charge($service, $amount);
        $totalAmount = $amount + $charge;

        // info
        $narration = $request->get('narration') ?? 'Fund transfer of '. moneyFormat($amount) . " from your Wallet to $account_number";

        // save transaction
        $transaction = auth()->user()->transactions()->create([
            'terminal_id'   => $request->terminal->id,
            'amount'        => $amount,
            'charge'        => $charge,
            'total_amount'  => $totalAmount,
            'bank_name'     => $bank,
            'bank_code'     => $bank_code,
            'account_number'=> $account_number,
            'account_name'  => $account_name,
            'reference'     => $reference,
            'info'          => $narration,
            'type_id'       => $service->id,
            'status'        => Status::PENDING,
            'provider'      => $provider::name(),
            'version'       => request('VERSION'),
            'channel'       => request('CHANNEL'),
            'device'       => request('DEVICE'),
        ]);

        return Purchase::process(
            $transaction,
            $request->wallet,
            fn() => WalletHelper::processDebit($request->wallet, $amount, $service, $reference, $narration, $charge),
            fn() => $provider->transfer($bank_code, $account_number, $amount, $reference, $narration, $bank, $account_name)
        );
    }
}
