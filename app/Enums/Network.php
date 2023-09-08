<?php

namespace App\Enums;

enum Network: string
{
    case MTN = 'mtn';
    case AIRTEL = 'airtel';
    case GLO = 'glo';
    case ETISALAT = '9mobile';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
