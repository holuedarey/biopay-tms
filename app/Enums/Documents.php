<?php

namespace App\Enums;

enum Documents: string
{
    case ID = 'id-card';
    case UTILITY = 'utility-bill';
    case CAC = 'cac';

    public function name(): string
    {
        return match ($this) {
            self::ID => 'ID Card',
            self::CAC => 'CAC Document',
            self::UTILITY => 'Utility Bill',
        };
    }

    public function isCac(): bool
    {
        return $this == self::CAC;
    }

    public function isIdCard(): bool
    {
        return $this == self::ID;
    }

    public function isUtilityBill(): bool
    {
        return $this == self::UTILITY;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
