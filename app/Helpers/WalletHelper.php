<?php

namespace App\Helpers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletHelper
{

    public static function creditTransaction(Transaction $transaction): array
    {
        try {
            $wallet = $transaction->agent->wallet;

            // Check if wallet is active
            if (!$wallet->is_active) {
                return [
                    'success' => false,
                    'message' => "Wallet is {$wallet->status}"
                ];
            }

            $response = [
                'success' => false,
                'message' => 'Error crediting wallet'
            ];

            DB::transaction(function () use ($transaction, $wallet, &$response ) {

                $prev_bal = $wallet->balance;
                $wallet->balance += (double) $transaction->total_amount;

                $wallet->updated_at = now();
                $wallet->save();

                $wallet->transactions()->create([
                    'user_id' => $transaction->user_id,
                    'amount' => $transaction->total_amount,
                    'reference' => $transaction->reference,
                    'type' => 'CREDIT',
                    'prev_balance' => $prev_bal,
                    'new_balance' => $wallet->balance,
                    'status' => $transaction->status,
                    'info' => $transaction->info,
                    'product_id' => $transaction->type_id,
                ]);

                $response = [
                    'success' => true,
                    'message' => 'Wallet crediting was successful.'
                ];
            });

            return $response;

        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }


    /**
     * Credit user Wallet
     *
     * @param User $user
     * @param float $amount
     * @param string|null $info
     * @param string $reference
     * @param Service $service
     * @return array
     */
    public static function credit(User $user, float $amount, string|null $info, string $reference, Service $service): array
    {
        $wallet = $user->wallet;

        // Check if wallet is active
        if (!$wallet->is_active) {
            return [
                'success' => false,
                'message' => "Wallet is {$wallet->status}"
            ];
        }

        DB::transaction(function () use ($user, $wallet, $amount, $info, $service, &$response, $reference ) {

            $prev_bal = $wallet->balance;
            $wallet->balance += $amount;

            $wallet->updated_at = now();
            $wallet->save();

            $wallet->transactions()->create([
                'user_id' => $user->id,
                'product_id' => $service->id,
                'amount' => $amount,
                'reference' => $reference ?? General::generateReference('wallet'),
                'type' => 'CREDIT',
                'prev_balance' => $prev_bal,
                'new_balance' => $wallet->balance,
                'info' => $info,
            ]);
        });

        return [
            'success' => true,
            'message' => 'Wallet crediting was successful.'
        ];
    }


    /**
     * Process the debit the wallet transaction.
     *
     * @param Wallet $wallet
     * @param float $amount The amount to be debited from the wallet
     * @param Service $service Service for which debit occurs
     * @param string|null $reference The transaction unique reference
     * @param string|null $info Reason for the debit
     * @param float $charge
     * @param bool $allow_negative
     * @return Result
     */
    public static function processDebit(Wallet $wallet, float $amount, Service $service, string|null $reference, string|null $info, float $charge = 0, bool $allow_negative = false): Result
    {
        try {
            $wallet->canPerformTransaction(($amount + $charge), 'DEBIT', $allow_negative);

            DB::transaction(function () use ($wallet, $amount, $service, $reference, $info, $charge){
                $wallet->debit($amount, $service, 'TRANSACTION', $reference, $info);

                if ($charge > 0) $wallet->debit($charge, $service, 'CHARGE', info: 'Charge for '. strtolower($service->name));
            });

            return new Result(true);
        }
        catch (\Exception $e) {
            Log::error("Wallet Debit Error: {$e->getMessage()}");

            return new Result(false, message: $e->getMessage());
        }
    }
}
