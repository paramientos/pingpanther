<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum ActivityLogPeriod: string
{
    use EnumToArray;

    case HOURLY = 'h';
    case DAILY = 'd';
    case WEEKLY = 'w';
    case MONTHLY = 'm';

    public static function default(): ActivityLogPeriod
    {
        return self::HOURLY;
    }

    public function text(): string
    {
        return match ($this) {
            self::HOURLY => 'Hourly',
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::MONTHLY => 'Mothly',
        };
    }

    public function getDatePeriod(): array
    {
        return match ($this) {
            self::HOURLY => [now()->subHour(), now()],
            self::DAILY => [now()->startOfDay(), now()->endOfDay()],
            self::WEEKLY => [now()->startOfWeek(), now()->endOfWeek()],
            self::MONTHLY => [now()->startOfMonth(), now()->endOfMonth()],
        };
    }
}
