<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Helpers\Purchase;
use App\Helpers\WalletHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataPurchaseRequest;
use App\Models\Service;
use App\Models\Transaction;
use App\Services\Data;
use Illuminate\Http\Request;

class DataPurchase extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['network' => 'required|in:mtn,airtel,glo,9mobile']);

        $provider = Data::provider();

        $data_plans = $provider->getDataPlans($request->network);

        return MyResponse::success(strtoupper($request->network) . ' data plans fetched.', $data_plans);
    }

    public function store(DataPurchaseRequest $request)
    {
        $provider = Data::provider();
        $service = Service::whereSlug(Data::NAME)->firstOrFail();

        $reference = General::generateReference();

        $amount = (double) $request->get('amount');
        $network = $request->get('network');
        $phone = $request->get('phone');

        $narration = 'Data purchase of ' . strtoupper($network) . ' - ' . moneyFormat($amount) . " for $phone";

        // save transaction
        $transaction = Transaction::createPendingFor(
            $request->terminal,
            $service,
            $amount,
            $amount,
            $reference,
            $narration,
            $provider::name()
        );

        return Purchase::process(
            $transaction,
            $request->wallet,
            fn () => WalletHelper::processDebit($request->wallet, $amount, $service, $reference, $narration),
            fn() => $provider->purchaseData($phone, $request->code, $amount, $network, $reference, $request->paymentData)
        );
    }
}
