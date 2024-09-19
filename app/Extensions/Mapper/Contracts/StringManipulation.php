<?php

namespace App\Extensions\Mapper\Contracts;

use Illuminate\Support\Str;

class StringManipulation
{
    protected function toCase(string $caseType = 'camel|snake|studly'): array
    {
        $items = [];

        if (method_exists(Str::class, $caseType)) {
            foreach ($this->toArray() as $key => $value) {
                $items[Str::{$caseType}($key)] = $value;
            }
        }

        return $items;
    }

    public function toArray(): array
    {
        return (array)$this;
    }

    public function exists(): bool
    {
        return count($this->toArray()) > 0;
    }

    public function toCamelcase(): array
    {
        return $this->toCase('camel');
    }

    public function toSnakeCase(): array
    {
        return $this->toCase('snake');
    }

    public function toStudlyCase(): array
    {
        return $this->toCase('studly');
    }
}
