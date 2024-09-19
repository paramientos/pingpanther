<?php

namespace App\Enums\Status;

use App\Concerns\EnumToArray;
use Illuminate\Support\Str;

enum HttpStatus: string
{
    use EnumToArray;

    case ACCESSIBLE = 'accessible';
    case NOT_ACCESSIBLE = 'not_accessible';

    public function text(): string
    {
        return Str::headline($this->value);
    }
}
