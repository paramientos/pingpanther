<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum MonitorFrequencyPeriods: int
{
    use EnumToArray;

    case SEC_30 = 30;
    case MIN_1 = 60;
    case MIN_2 = 120;
    case MIN_3 = 180;
    case MIN_5 = 300;
    case MIN_10 = 600;
    case MIN_15 = 900;

    public function text(): string
    {
        return match ($this) {
            self::SEC_30 => '30 seconds',
            self::MIN_1 => '1 minute',
            self::MIN_2 => '2 minutes',
            self::MIN_3 => '3 minutes',
            self::MIN_5 => '5 minutes',
            self::MIN_10 => '10 minutes',
            self::MIN_15 => '15 minutes',
        };
    }

    public static function byOrder(): array
    {
        return [
            self::SEC_30,
            self::MIN_1,
            self::MIN_2,
            self::MIN_3,
            self::MIN_5,
            self::MIN_10,
            self::MIN_15,
        ];
    }

    public static function isInSeconds(int $period): bool
    {
        return $period == self::SEC_30->value;
    }

    public static function isInMinutes(int $period): bool
    {
        return in_array($period, [
            self::MIN_1->value,
            self::MIN_2->value,
            self::MIN_3->value,
            self::MIN_5->value,
            self::MIN_10->value,
            self::MIN_15->value,
        ]);
    }
}
