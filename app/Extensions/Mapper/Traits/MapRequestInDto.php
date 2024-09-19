<?php

namespace App\Extensions\Mapper\Traits;

use ReflectionClass;
use ReflectionProperty;

/**
 * Use it when your DTO injected in your controller like as Request object
 *
 * Trait MapRequest
 * @package Mupay\Extension\Packages\RequestMapper\Traits
 */
trait MapRequestInDto
{
    use Caster;

    public \Illuminate\Http\Request $requestObject;

    public function __construct()
    {
        $reflectionClass = new ReflectionClass($this);
        $this->requestObject = app('request');
        $requestValues = $this->requestObject->all();

        $dtoProps = array_filter(
            $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC),
            static function (ReflectionProperty $property) {
                return $property->getType()->getName() !== \Illuminate\Http\Request::class;
            }
        );

        foreach ($dtoProps as $dtoProp) {
            $propertyName = $dtoProp->getName();
            $propertyType = $dtoProp->getType()?->getName();

            foreach ($requestValues as $requestParam => $requestValue) {
                if ($requestParam === $propertyName) {
                    $this->$propertyName = $this->cast($propertyType, $requestValue);
                }
            }
        }
    }
}
