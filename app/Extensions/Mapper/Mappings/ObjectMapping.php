<?php

namespace App\Extensions\Mapper\Mappings;

use ReflectionClass;
use ReflectionProperty;

class ObjectMapping
{
    public static function getProps(ReflectionClass $reflection): array
    {
        return $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
    }
}
