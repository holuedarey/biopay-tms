<?php

namespace App\Enums;

enum Action: string
{
    case CREDIT = 'CREDIT';
    case DEBIT = 'DEBIT';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
