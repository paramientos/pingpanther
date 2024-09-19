<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum MonitorEventType: int
{
    use EnumToArray;

    case NEGATIVE = 0;
    case POSITIVE = 1;
    case ALL = 2;

    public function getTypes(): array
    {
        return match ($this) {
            self::NEGATIVE => [false],
            self::POSITIVE => [true],
            self::ALL => [false, true],
        };
    }
}
