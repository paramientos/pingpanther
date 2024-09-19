<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum FrequencyTypedChecks: string
{
    use EnumToArray;

    case EXCEPTION_TRACE = 'ExceptionTrace';
    case CUSTOM_MESSAGE = 'CustomMessage';
}
