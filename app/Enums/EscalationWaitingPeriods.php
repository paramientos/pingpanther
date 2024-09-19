<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum EscalationWaitingPeriods: string
{
    use EnumToArray;

    case URL = 'Website/URL';
    case SSL_CERT = 'SSL Certificate';
    case SERVER = 'Server';
    case PORT = 'Server Port';
    case EXCEPTION_TRACE = 'Exception Trace';
    case CUSTOM_MESSAGE = 'Custom Message';
    case CRON = 'CronJob';
    case ENDPOINT = 'Endpoint';

    public static function byOrder(): array
    {
        return [
            self::URL->name => self::URL->value,
            self::SERVER->name => self::SERVER->value,
            self::SSL_CERT->name => self::SSL_CERT->value,
            self::PORT->name => self::PORT->value,
            //self::CRON->name => self::CRON->value,
            //self::ENDPOINT->name => self::ENDPOINT->value,
            //self::EXCEPTION_TRACE->name => self::EXCEPTION_TRACE->value,
            //self::CUSTOM_MESSAGE->name => self::CUSTOM_MESSAGE->value,
        ];
    }
}
