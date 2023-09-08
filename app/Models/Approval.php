<?php

namespace App\Models;

use App\Enums\Action;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends \Cjmellor\Approval\Models\Approval
{
    protected $appends = ['resource', 'action'];

    public function action(): Attribute
    {
        return Attribute::get(function () {
            if (empty($this->original_data?->toArray())) {
                if ($this->approvalable instanceof Wallet) return $this->new_data['action'] . 'ED';

                if ($this->approvalable instanceof GeneralLedger) return 'FUNDED';

                return 'created';
            }

            elseif (empty($this->new_data?->toArray())) return 'deleted';

            else return 'updated';
        });
    }

    public function resource(): Attribute
    {
        return Attribute::get(fn() => str($this->approvalable_type)->remove("App\Models\\"));
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /**
     * Approve impact for wallet.
     *
     * @return void
     */
    public function updateForWallet(): void
    {
        $wallet = Wallet::find($this->approvalable_id);
        $data = $this->new_data;
        $service = Service::whereSlug('fundinginbound')->first();

        if ($this->new_data['action'] == Action::DEBIT->value) {
            $wallet->debit($data['amount'], $service, 'TRANSACTION', info: $data['info']);
        }
        if ($this->new_data['action'] == Action::CREDIT->value) {
            $wallet->credit($data['amount'], $service, info: $data['info']);
        }
    }

    /**
     * Approve impact for General ledger.
     *
     * @return void
     */
    public function updateForGL(): void
    {
        $gl = GeneralLedger::find($this->approvalable_id);
        $data = $this->new_data;

        $gl->recordTransaction(Action::CREDIT, $this->performed_by, $data['amount'], $data['info']);
    }
}
