<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum DomainExpirationPeriods: int
{
    use EnumToArray;

    case DONT_CHECK = 0;
    case DAY_1 = 1;
    case DAY_2 = 2;
    case DAY_3 = 3;
    case DAY_7 = 7;
    case DAY_14 = 14;
    case DAY_30 = 30;
    case DAY_60 = 60;
    case DAY_90 = 90;

    public function text(): string
    {
        return match ($this) {
            self::DONT_CHECK => "Don't check for domain expiration",
            self::DAY_1 => 'Alert 1 day before',
            self::DAY_2 => 'Alert 2 day before',
            self::DAY_3 => 'Alert 3 day before',
            self::DAY_7 => 'Alert 7 day before',
            self::DAY_14 => 'Alert 14 day before',
            self::DAY_30 => 'Alert 1 month before',
            self::DAY_60 => 'Alert 2 month before',
            self::DAY_90 => 'Alert 3 month before',
        };
    }
}
