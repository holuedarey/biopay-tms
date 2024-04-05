<?php

namespace App\Models;

use App\Enums\Action;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GeneralLedger extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function glts(): HasMany
    {
        return $this->hasMany(GLT::class, 'gl_id');
    }

    /**
     * Impact the general ledger for the service instance after a transaction occurs.
     *
     * @param Action $action <b>true</b> for <i>credit</i> or <b>false</b> for <i>debit</i>
     * @param int $userId The user ID
     * @param float $amount Total amount for the transaction to impact this general ledger
     * @param float|null $impact_amount
     * @param string|null $info Extra information about the transaction
     * @return void
     */
    public function recordTransaction(Action $action, int $userId, float $amount, ?float $impact_amount = null, ?string $info = null): void
    {
        $prev_bal = $this->balance;

        $this->{strtolower($action->value)}($amount); // $this->credit() or $this->debit() below

        $this->glts()->create([
            'from_user_id'  => $userId,
            'amount'        => $amount,
            'impact_amount' => $impact_amount ?? $amount,
            'type'          => $action->value,
            'prev_balance'  => $prev_bal,
            'new_balance'   => $this->balance,
            'info'          => $info
        ]);
    }

    private function credit(float $amount)
    {
        $this->update(['balance' => $this->balance + $amount]);
    }

    private function debit(float $amount)
    {
        $this->update(['balance' => $this->balance - $amount]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('GL')
            ->logOnly(['balance']);
    }

    /**
     * Get the summarized balance for each service and the total balance.
     *
     * @return object<string, numeric>
     */
    public static function getBalances(): object
    {
        $gls = self::join('services', 'general_ledgers.service_id', 'services.id')->pluck('balance', 'slug');

        return (object) [
            'total' => collect($gls)->sum(),
            'cashout' => $gls['cashoutwithdrawal'] ?? 0,
            'airtime_data' => ($gls['airtime'] ?? 0) + ($gls['internetdata'] ?? 0),
            'bill_payments' => ($gls['cabletv'] ?? 0) + ($gls['electricity'] ?? 0),
            'transfer' => $gls['banktransfer'] ?? 0
        ];
    }

    public function scopeForService(Builder $builder, string $slug): void
    {
        $builder->whereRelation('service', 'slug', $slug);
    }
}
