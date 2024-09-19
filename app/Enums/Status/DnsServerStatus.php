<?php

namespace App\Enums\Status;

use App\Attributes\Override;
use App\Concerns\EnumToArray;

enum DnsServerStatus: string
{
    use EnumToArray;

    case MATCHED = 'matched';
    case UNMATCHED = 'unmatched';

    #[Override]
    public function text(): string
    {
        return match ($this) {
            self::MATCHED => 'has matched with DNS values',
            self::UNMATCHED => 'has not matched with DNS values',
        };
    }
}
