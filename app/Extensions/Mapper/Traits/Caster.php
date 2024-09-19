<?php

namespace App\Extensions\Mapper\Traits;

trait Caster
{
    private function cast(string $type, mixed $value): mixed
    {
        return match ($type) {
            'int' => (int)$value,
            'string' => is_array($value) ? json_encode($value) : (string)$value,
            'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'float', 'double' => (float)$value,
            'array' => (array)$value,
            'object' => (object)$value,
            'default' => $value
        };
    }
}
