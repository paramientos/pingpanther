<?php

namespace App\Enums\Status;

use App\Attributes\Override;
use App\Concerns\EnumToArray;

enum ImapServerStatus: string
{
    use EnumToArray;

    case IMAP_WORKS = 'imap_works';
    case IMAP_DOESNT_WORK = 'imap_doesnt_work';

    #[Override]
    public function text(): string
    {
        return match ($this) {
            self::IMAP_WORKS => 'imap server works',
            self::IMAP_DOESNT_WORK => "imap server doesn't work",
        };
    }
}
