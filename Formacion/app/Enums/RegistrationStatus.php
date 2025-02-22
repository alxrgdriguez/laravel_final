<?php
namespace App\Enums;
enum RegistrationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case CANCELLED = 'cancelled';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }
}





