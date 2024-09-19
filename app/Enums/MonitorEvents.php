<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum MonitorEvents: string
{
    use EnumToArray;

    case UP = 'up';
    case DOWN = 'down';
    case DOMAIN_WILL_EXPIRE = 'domain_will_expire';
    case SSL_WILL_EXPIRE = 'ssl_will_expire';
}
