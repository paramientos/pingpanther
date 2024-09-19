<?php

namespace App\Extensions\Mapper\Mappings;

class ArrayMapping
{
    public static function getKeys(array $data): array
    {
        return array_keys($data);
    }
}
