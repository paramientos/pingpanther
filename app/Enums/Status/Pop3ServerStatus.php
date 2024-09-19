<?php

namespace App\Enums\Status;

use App\Attributes\Override;
use App\Concerns\EnumToArray;

enum Pop3ServerStatus: string
{
    use EnumToArray;

    case POP3_WORKS = 'pop3_works';
    case POP3_DOESNT_WORK = 'pop3_doesnt_work';

    #[Override]
    public function text(): string
    {
        return match ($this) {
            self::POP3_WORKS => 'pop3 server works',
            self::POP3_DOESNT_WORK => "pop3 server doesn't work",
        };
    }
}
