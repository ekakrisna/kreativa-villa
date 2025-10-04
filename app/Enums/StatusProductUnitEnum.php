<?php

namespace App\Enums;

enum StatusProductUnitEnum: string
{
    case AVAILABLE = 'available';
    case MAINTENANCE = 'maintenance';
    case RETIRED = 'retired';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
