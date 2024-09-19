<?php

namespace App\Extensions\Mapper\Traits;

use App\Extensions\Mapper\Contracts\WithMapper;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionProperty;

/**
 * Use it when your DTO injected as property in your request file
 *
 * Trait MapRequestToDto
 * @package Mupay\Extension\Packages\RequestMapper\Traits
 */
trait MapRequestToDto
{
    use Caster;

    public WithMapper $object;

    /**
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $reflectionClass = new ReflectionClass($this);

        $requestValues = app('request')->all();

        $dtoProps = array_filter(
            $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC),
            static function (ReflectionProperty $property) {
                return is_subclass_of($property->getType()?->getName(), WithMapper::class);
            }
        );

        foreach ($dtoProps as $dtoProp) {
            $dtoVariable = $dtoProp->getName();
            $dtoPropertyType = $dtoProp->getType()?->getName();

            /** @var WithMapper $cls */
            $cls = new $dtoPropertyType();

            $dtoClass = new ReflectionClass($dtoPropertyType);
            $dtoProps = $dtoClass->getProperties(ReflectionProperty::IS_PUBLIC);

            foreach ($dtoProps as $dtoProp) {
                foreach ($requestValues as $requestParamName => $requestValue) {
                    if ($this->matches($requestParamName, $dtoProp->getName())) {
                        $cls->{$dtoProp->getName()} = $this->cast(
                            $dtoProp->getType()?->getName(),
                            $requestValue
                        );
                    }
                }
            }

            $this->{$dtoVariable} = $cls;
        }
    }

    private function matches(string $requestParamName, string $dtoPropName): bool
    {
        return Str::camel($requestParamName) === Str::camel($dtoPropName);
    }
}
