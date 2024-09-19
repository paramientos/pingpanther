<?php

namespace App\Extensions\Mapper;

use App\Extensions\Mapper\Contracts\WithConvert;
use App\Extensions\Mapper\Contracts\WithExclude;
use App\Extensions\Mapper\Contracts\WithExtra;
use App\Extensions\Mapper\Contracts\WithMapper;
use App\Extensions\Mapper\Mappings\ArrayMapping;
use App\Extensions\Mapper\Mappings\ObjectMapping;
use App\Extensions\Mapper\Traits\Caster;
use Closure;
use Exception;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;


class Mapper
{
    use Caster;

    /**
     * @param string|array|object|null $source
     * @param string $destination
     * @return object
     * @throws ReflectionException
     * @throws Exception
     */
    public static function map(string|array|object|null $source, string $destination): WithMapper
    {
        if (!class_exists($destination)) {
            throw new Exception("Destination object not found! : '{$destination}'");
        }

        if (!is_subclass_of($destination, WithMapper::class)) {
            throw new Exception("Destination object not implements to WithMapper interface'");
        }

        $destinationRef = new ReflectionClass($destination);
        $destinationProps = $destinationRef->getProperties(ReflectionProperty::IS_PUBLIC);
        $destinationClass = $destinationRef->newInstance();

        if ($source == null) {
            return $destinationClass;
        }

        [$controlType, $sourceProps] = match (gettype($source)) {
            'array' => [false, ArrayMapping::getKeys($source)],
            'object' => [true, ObjectMapping::getProps(new ReflectionClass($source))],
            'string' => class_exists($source) ? [true, ObjectMapping::getProps(new ReflectionClass($source))] : throw new Exception('Class not found!')
        };

        $convertValues = [];

        if (is_subclass_of($destination, WithConvert::class)) {
            foreach ($destinationClass->convert() as $key => $value) {
                $convertValues[Str::camel($key)] = $value;
            }
        }

        $extraValues = [];

        if (is_subclass_of($destination, WithExtra::class)) {
            foreach ($destinationClass->extra() as $key => $value) {
                $extraValues[Str::camel($key)] = $value;
            }
        }

        $mapper = new Mapper();

        /** @var ReflectionProperty|string $sourceProp */
        foreach ($sourceProps as $sourceProp) {
            foreach ($destinationProps as $destinationProp) {
                [$sourcePropName, $sourcePropType, $sourcePropValue] = match (gettype($sourceProp)) {
                    'string' => [$sourceProp, gettype($sourceProp), $source[$sourceProp]],
                    'object' => [$sourceProp->getName(), $sourceProp->getType()->getName(), $sourceProp->getDefaultValue()]
                };

                $destinationPropType = $destinationProp->getType()->getName();
                $destinationPropName = $destinationProp->getName();

                if (self::matchesPropNames($sourcePropName, $destinationPropName)) {
                    if ($controlType && !self::matchesPropTypes($sourcePropType, $destinationPropType)) {
                        throw new Exception("The types of '{$sourcePropName}' does not match! ({$sourcePropType} and {$destinationPropType})");
                    }

                    if (!empty($convertValues[Str::camel($destinationPropName)])) {
                        if ($convertValues[Str::camel($destinationPropName)] instanceof Closure) {
                            $sourcePropValue = $convertValues[Str::camel($destinationPropName)]($sourcePropValue);
                        }
                    }

                    $destinationClass->{$destinationProp->getName()} = $mapper->cast($destinationPropType, $sourcePropValue);
                }
            }
        }

        foreach ($extraValues as $key => $value) {
            $value = $value instanceof Closure ? $value() : $value;

            $destinationClass->{$key} = $value;
        }

        if (is_subclass_of($destination, WithExclude::class)) {
            foreach ($destinationClass->exclude() as $key) {
                unset($destinationClass->{$key});
            }
        }

        return $destinationClass;
    }

    private static function matchesPropNames(string $sourceName, string $destName): bool
    {
        return Str::camel($sourceName) === Str::camel($destName);
    }

    private static function matchesPropTypes(string $sourceType, string $destType): bool
    {
        return $sourceType === $destType;
    }
}
