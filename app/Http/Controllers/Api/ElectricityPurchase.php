<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Helpers\Purchase;
use App\Helpers\WalletHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ElectricityPurchaseRequest;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Services\Electricity;
use Illuminate\Http\Request;

class ElectricityPurchase extends Controller
{
    public function distributors()
    {
        return MyResponse::success('Available distributors fetched',
            Electricity::provider()->distributors()->sortBy('name')->values());
    }

    public function validateMeter(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'meterNo' => 'required|numeric|max_digits:20',
            'code' => 'required',
            'type' => 'required|in:prepaid,postpaid'
        ]);

        $meterNo = $request->meterNo;
        $service = Service::whereSlug(Electricity::NAME)->firstOrFail();
        $terminal = Terminal::forAuthDevice();

        $charge = $terminal->group->charge($service, $request->amount);

        $res = Electricity::provider()->validateMeter($meterNo, $request->code, $request->type, $request->amount);

        return MyResponse::success('Meter validated.', $res->put('charge', $charge));
    }

    public function purchase(ElectricityPurchaseRequest $request)
    {
        $provider = Electricity::provider();
        $service = Service::whereSlug(Electricity::NAME)->firstOrFail();

        $reference = General::generateReference();

        $phone = $request->get('phone');
        $amount = (double) $request->get('amount');
        $code = $request->get('code');
        $meter = $request->get('meterNo');
        $recipient = $meter . '|' . $request->paymentData['recipient'] . "|$phone";

        $narration = 'Payment for ' . strtoupper($code)  ." electricity bill: $meter - " . moneyFormat($amount);

        $charge = $request->terminal->group->charge($service, $amount);
        $totalAmount = $amount + $charge;

        // save transaction
        $transaction = Transaction::createPendingFor(
            $request->terminal,
            $service,
            $amount,
            $totalAmount,
            $reference,
            $narration,
            $provider::name(),
            $recipient
        );

        return Purchase::process($transaction, $request->wallet,
            fn () => WalletHelper::processDebit($request->wallet, $amount, $service, $reference, $narration, $charge),
            fn() => $provider->purchaseElectricity($amount, $phone, $reference, $request->paymentData)
        );
    }
}
