<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General;
use App\Helpers\MyResponse;
use App\Helpers\Purchase;
use App\Helpers\WalletHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CableTvPurchaseRequest;
use App\Models\Service;
use App\Models\Terminal;
use App\Models\Transaction;
use App\Services\Cabletv;
use Illuminate\Http\Request;

class CableTvPurchase extends Controller
{
    public function plans(Request $request)
    {
        $request->validate(['decoder' => 'required|in:dstv,gotv,startimes']);

        return MyResponse::success(
            strtoupper($request->decoder) . ' plans loaded',
            Cabletv::provider()->getCablePlans($request->decoder)->sortBy('price')->values()
        );
    }


    public function validateAccount(Request $request)
    {
        $request->validate([
            'account_id' => 'required',
            'decoder' => 'required|in:dstv,gotv,startimes',
            'amount' => 'required|numeric|min:500'
        ]);

        $service = Service::whereSlug(Cabletv::NAME)->firstOrFail();
        $terminal = Terminal::forAuthDevice();

        $charge = $terminal->group->charge($service, $request->amount);

        $res = Cabletv::provider()->validateCablePlan($request->decoder, $request->account_id, $request->type);

        return MyResponse::success('Validation complete.', $res->put('charge', $charge));
    }


    public function purchase(CableTvPurchaseRequest $request)
    {
        $provider = Cabletv::provider();
        $service = Service::whereSlug(Cabletv::NAME)->firstOrFail();

        $reference = General::generateReference();

        $amount = (double) $request->get('amount');
        $decoder = $request->get('decoder');
        $phone = $request->get('phone');
        $planCode = $request->get('planCode');
        $decoderId  = $request->get('account_id');
        $recipient = $decoderId . '|' . $request->paymentData['recipient'] . "|$phone";

        $narration = 'Purchase for ' . strtoupper($decoder)  .": $planCode - " . moneyFormat($amount) . " for $decoderId";

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
            fn() => $provider->purchaseCablePlan($decoder, $planCode, $phone, $amount, $reference, $request->get('months'), $request->get('paymentData'))
        );
    }
}
