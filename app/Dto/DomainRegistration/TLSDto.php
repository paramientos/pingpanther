<?php

namespace App\Dto\DomainRegistration;

use App\Services\StringManipulation;

class TLSDto extends StringManipulation
{
    public function __construct(
        public string  $domainName,
        public bool    $isVerified = false,
        public ?string $result = null,
    )
    {
        //
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function result(): ?string
    {
        return $this->result;
    }

    public function color(): string
    {
        return $this->isVerified() ? 'green' : 'red';
    }
}
