<?php

namespace App\Enums\Status;

use App\Attributes\Override;
use App\Concerns\EnumToArray;

enum SmtpServerStatus: string
{
    use EnumToArray;

    case CAN_SEND_MAIL = 'can_send_mail';
    case CAN_NOT_SEND_MAIL = 'can_not_send_mail';

    #[Override]
    public function text(): string
    {
        return match ($this) {
            self::CAN_SEND_MAIL => 'can send mail',
            self::CAN_NOT_SEND_MAIL => 'can not send mail',
        };
    }
}
