<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum RequestTimeoutInSecLength: int
{
    use EnumToArray;

    case SEC_2 = 2;
    case SEC_3 = 3;
    case SEC_5 = 5;
    case SEC_10 = 10;
    case SEC_15 = 15;
    case SEC_30 = 30;
    case SEC_45 = 45;
    case SEC_60 = 60;

    public static function default(): int
    {
        return self::SEC_5->value;
    }

    public function text(): string
    {
        return match ($this) {
            self::SEC_2 => "2 Seconds",
            self::SEC_3 => '3 Seconds',
            self::SEC_5 => '5 Seconds',
            self::SEC_10 => '10 Seconds ',
            self::SEC_15 => '15 Seconds',
            self::SEC_30 => '30 Seconds',
            self::SEC_45 => '45 Seconds',
            self::SEC_60 => '60 Seconds',
        };
    }
}
