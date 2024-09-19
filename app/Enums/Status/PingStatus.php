<?php

namespace App\Enums\Status;

use App\Concerns\EnumToArray;
use Illuminate\Support\Str;

enum PingStatus: string
{
    use EnumToArray;

    case PINGABLE = 'pingable';
    case NOT_PINGABLE = 'not_pingable';
}
