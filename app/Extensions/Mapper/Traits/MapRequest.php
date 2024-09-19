<?php

namespace App\Extensions\Mapper\Traits;
use function get_class;
use ReflectionClass;
use ReflectionProperty;

trait MapRequest
{
    use Caster;

    public function __construct()
    {
        $reflectionClass = new ReflectionClass($this);
        $requestClassName = get_class($this);

        $requestValues = app('request')->all();

        $requestProps = array_filter(
            $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC),
            static fn (ReflectionProperty $property) => $property->class === $requestClassName
        );

        foreach ($requestProps as $requestProp) {
            $propertyName = $requestProp->getName();
            $propertyType = $requestProp->getType()?->getName();

            foreach ($requestValues as $requestParam => $requestValue) {
                if ($requestParam === $propertyName) {
                    $this->{$propertyName} = $this->cast($propertyType, $requestValue);
                }
            }
        }
    }
}
