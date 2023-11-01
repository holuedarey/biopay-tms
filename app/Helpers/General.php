<?php

namespace App\Helpers;

use App\Models\Transaction;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;

class General
{
    /**
     * @param string $type
     * @param int $length
     * @return string
     */
    public static function generateReference( string $type = 'transaction', int $length = 14 ): string
    {
        start: $reference = str(Str::random($length))->prepend('le')->upper();

        switch ($type) {
            case 'wallet':
                if ( WalletTransaction::whereReference($reference)->exists() ) goto start;
                break;

            default:
                if ( Transaction::whereReference($reference)->exists() ) goto start;
                break;
        }

        return $reference;
    }

    public static function generateNameLocation(string $name): string
    {
        $nl = substr($name, 0, 21) . '-'. substr(config('app.name'), 0, 11);

        return str_pad($nl, 35, ' ', STR_PAD_RIGHT) . 'LA NG';
    }
}
