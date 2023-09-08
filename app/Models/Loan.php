<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\BelongsToSuperAgent;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory, BelongsToSuperAgent;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => Status::class,
        'items' => 'array'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function declinedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'declined_by');
    }

    public function isPending(): bool
    {
        return $this->status === Status::PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === Status::CONFIRMED;
    }

    public function isDeclined(): bool
    {
        return $this->status === Status::DECLINED;
    }

    public function isRepaid(): bool
    {
        return $this->status === Status::REPAID;
    }

    public function details(): array
    {
        $loan = $this->only(['info', 'decline_reason', 'amount', 'status', 'items']);

        return array_merge($loan, [
            'transaction' => $this->only('amount'),
            'user' => $this->agent->only(['name', 'email']),
            'confirmed_by' => $a = auth()->user()->isAdmin() ? $this->confirmedBy?->name : null,
            'declined_by' => $a ? $this->declinedBy?->name : null,
        ]);
    }

    /**
     * Process the loan transaction by updating the status, transferring to the wholesaler &
     *  impacting the general ledger; if certain conditions.
     * @return void
     */
    public function processTransaction(): void
    {
        $transaction = $this->transaction;

        // Update the transaction amount if the loan amount is changed by wholesaler
        if ($amount = request('amount')) $transaction->amount = $amount;

        // If loan status was updated
        if ($this->wasChanged('status')) {
            if ($this->isConfirmed()) {
                $service = Service::whereSlug('loan')->first();

                $this->agent->getSuperAgentWallet()->credit(
                    $transaction->amount,
                    $service,
                    $transaction->reference,
                    "Loan Request for {$this->agent->name}"
                );

                $transaction->status = Status::SUCCESSFUL;
            }

            if ($this->isDeclined()) $transaction->status = Status::FAILED;
        }

        $transaction->save();
    }
}
