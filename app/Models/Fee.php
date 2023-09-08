<?php

namespace App\Models;

use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Fee extends Model
{
    use HasFactory, LogsActivity, MustBeApproved;

    const CHARGE = 'CHARGE';
    const COMMISSION = 'COMMISSION';
    const FIXED = 'FIXED';
    const PERCENT = 'PERCENTAGE';

    protected $guarded = ['id'];

    protected $casts = [
        'config'    => 'array'
    ];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function group()
    {
        return $this->belongsTo(TerminalGroup::class);
    }


    /**
     * Create Default fees for the specified group.
     *
     * @param $groupId
     * @return void
     */
    public static function createDefault($groupId)
    {
        Service::whereNotIn('slug', ['airtime', 'internetdata'])->each(function (Service $service) use ( $groupId ) {

            $config = collect();
            if ( $service->slug == 'banktransfer' ) {
                $config->merge([
                    '0-5000'        => 10.00,
                    '5001-50000'    => 21.51,
                    '50001-1000000' => 30.00
                ]);
            }

            Fee::upsert([
                'title'         => $service->name,
                'amount'        => 10.00,
                'config'        => $config,
                'group_id'       => $groupId,
                'service_id'    => $service->id,
            ], [
                'group_id'       => $groupId,
                'service_id'    => $service->id,
            ]);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Fee')
            ->logOnly(['title']);
    }

    public function getChargeFor(float $amount): float
    {
        return match ($this->amount_type) {
            self::FIXED => $this->getFixedCharge($amount),
            self::PERCENT => $this->getPercentageCharge($amount),
        };
    }

    public function getFixedCharge(float $amount): float
    {
        if (empty($this->config)) return $this->amount;

        foreach ($this->config as $range => $value) {
            $min = (int) str($range)->before('-')->trim()->value();
            $max = (int) str($range)->afterLast('-')->trim()->value();

            if ($amount > $min && $amount < $max) return $value;
        }

        return  $this->amount;
    }

    public function getPercentageCharge(float $amount): float
    {
        $charge = ($this->amount / 100) * $amount;

        if ($this->cap != 0 and $charge > $this->cap) return $this->cap;

        return $charge;
    }
}
