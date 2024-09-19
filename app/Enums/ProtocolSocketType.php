<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum ProtocolSocketType: string
{
    use EnumToArray;

    case BOTH = 'both';
    case TCP = 'tcp';
    case UDP = 'udp';

    public function getNmapParameter(): string
    {
        return match ($this) {
            self::BOTH => '',
            self::TCP => '-sS',
            self::UDP => '-sU',
        };
    }
}
