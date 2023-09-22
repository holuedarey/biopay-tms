<?php

namespace App\Helpers;

use App\Enums\Status;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;

class Purchase
{
    /**
     * Process the transaction by debiting the wallet and making purchase of the service from the provider.
     * <p>Then update the transaction status based on both outcomes.
     *
     * @param Transaction $transaction The created transaction.
     * @param Wallet $wallet The impacted wallet.
     * @param \Closure $debitCallable The wallet debit processing function.
     * @param \Closure $purchaseCallable The service purchase function from the provider
     * @return JsonResponse The <b>MyResponse</b> class
     */
    public static function process(Transaction $transaction, Wallet $wallet, \Closure $debitCallable, \Closure $purchaseCallable): JsonResponse
    {
        $debit = $debitCallable();

        if ($debit->success) {
            // Update transaction
            $transaction->update(['wallet_debited' => true]);

            // Process transfer
            $purchase = $purchaseCallable();

            if ( $purchase->success ) {
                $transaction->update([
                    'status' => Status::SUCCESSFUL,
                    'meta' => $purchase->data
                ]);

                return MyResponse::success("SUCCESSFUL: $transaction->info", $transaction);
            }
        }

        $transaction->update([
            'status' => Status::FAILED,
            'meta' => isset($purchase) ? $purchase->data : null
        ]);

        // Reverse failed purchase if wallet was debited.
        if ($debit->success) $wallet->credit($transaction->total_amount, $transaction->service, info: "REVERSAL:: $transaction->info");

        return MyResponse::failed(
            $purchase->message ?? $debit->message,
            $transaction,
            code: $debit->success ? 200 : 403
        );
    }
}
