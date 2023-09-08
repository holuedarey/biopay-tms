<?php

namespace App\Traits;

use App\Enums\Action;
use App\Exceptions\FailedApiResponse;
use App\Models\Service;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

trait HasWalletMethods
{
    /**
     * Check if the wallet is allowed to perform the transaction.
     *
     * @param float $amount
     * @param string $action <i>CREDIT</i> or <i>DEBIT</i>
     * @param bool $allow_negative
     * @return bool
     * @throws FailedApiResponse
     */
    public function canPerformTransaction(float $amount, string $action, bool $allow_negative = false): bool
    {
        if ($this->status != 'ACTIVE') throw new FailedApiResponse("Your Wallet is currently $this->status!");

        if ($this->disable_debit) throw new FailedApiResponse('Fund transfer failed!');

        if (strtolower($action) == 'debit' && $amount > $this->balance && !$allow_negative)
            throw new FailedApiResponse("Insufficient balance!");

        return true;
    }

    /**
     * Debit the wallet.
     *
     * @param float $amount The amount to be credited to wallet.
     * @param Service $service The service for which this action occurs
     * @param string|null $reference The transaction reference
     * @param string|null $info Reason for the credit
     * @param string $type <i>TRANSACTION</i> or <i>CHARGE</i>
     * @return void
     */
    public function debit(float $amount, Service $service, string $type, ?string $reference = null, ?string $info = null): void
    {
        DB::transaction(function () use ($amount, $service, $reference, $info, $type) {
            $prev_bal = $this->balance;

            $this->update(['balance' => $prev_bal - $amount]);

            $this->transactions()->create([
                'amount' => $amount,
                'action' => 'DEBIT',
                'reference' => $reference ?? self::newTransactionReference(str($type)->substr(0, 3)->lower()),
                'prev_balance' => $prev_bal,
                'new_balance' => $this->balance,
                'info' => $info,
                'type' => $type,
                'product_id' => $service->id,
            ]);

            $service->generalLedger->recordTransaction(Action::CREDIT, $this->user_id, $amount, $info);
        });
    }

    /**
     * Credit the wallet.
     *
     * @param float $amount The amount to be credited to wallet.
     * @param Service $service The service for which this action occurs
     * @param string|null $reference The transaction reference
     * @param string|null $info Reason for the credit
     * @return void
     */
    public function credit(float $amount, Service $service, ?string $reference = null, ?string $info = null): void
    {
        DB::transaction(function () use ($amount, $service, $reference, $info) {
            $prev_bal = $this->balance;

            $this->update(['balance' => $prev_bal + $amount]);

            $this->transactions()->create([
                'amount' => $amount,
                'action' => 'CREDIT',
                'reference' => $reference ?? self::newTransactionReference('tra'),
                'prev_balance' => $prev_bal,
                'new_balance' => $this->balance,
                'info' => $info,
                'product_id' => $service->id,
            ]);

            $service->generalLedger->recordTransaction(Action::DEBIT, $this->user_id, $amount, $info);
        });
    }

    public static function newTransactionReference(string $prefix): string
    {
        start: $ref = $prefix . \Str::random(12);

        if (WalletTransaction::whereReference($ref)->exists() ) goto start;

        return $ref;
    }
}
