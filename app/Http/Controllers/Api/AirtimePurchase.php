<?php

namespace App\Http\Controllers\Api;

use App\Enums\Network;
use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Helpers\Purchase;
use App\Helpers\WalletHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AirtimeRequest;
use App\Models\Service;
use App\Models\Transaction;
use App\Services\Airtime;

class AirtimePurchase extends Controller
{
    public function index()
    {
        return MyResponse::success('Network services fetched.', [
            ['id' => Network::MTN, 'name' => 'MTN'],
            ['id' => Network::AIRTEL, 'name' => 'Airtel'],
            ['id' => Network::GLO, 'name' => 'GLO'],
            ['id' => Network::ETISALAT, 'name' => '9Mobile'],
        ]);
    }

    public function store(AirtimeRequest $request)
    {
        $provider = Airtime::provider();
        $service = Service::whereSlug(Airtime::NAME)->firstOrFail();

        $reference = General::generateReference();

        $amount = (double) $request->get('amount');
        $network = $request->get('network');
        $phone = $request->get('phone');

        $narration = 'Airtime purchase of '. strtoupper($network) . ' - ' . moneyFormat($amount) . " for $phone";

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
            fn() => $provider->purchaseAirtime($amount, $phone, $reference, $network)
        );
    }
}
