<?php

namespace App\Enums\Status;

use App\Concerns\EnumToArray;

enum BecomesUnavailableStatus: string
{
    use EnumToArray;

    case UP = 'up';
    case DOWN = 'down';
    case DOMAIN_WILL_EXPIRE = 'domain_will_expire';
    case SSL_WILL_EXPIRE = 'ssl_will_expire';
    case TLS_IS_VERIFIED = 'tls_is_verified';
    case TLS_IS_UNVERIFIED = 'tls_is_unverified';
}
