<?php

namespace App\Enums;

enum Status: string
{
    case ACTIVE = 'active';
    case FINALIZED = 'finalized';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
