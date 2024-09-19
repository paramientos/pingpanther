<?php

namespace App\Dto\DomainRegistration;

use App\Services\StringManipulation;
use Carbon\Carbon;

class SSLDto extends StringManipulation
{
    public function __construct(
        public string    $url,
        public ?string $domainName,
        public bool    $isValid,
        public ?string $issuerName,
        public ?string $validFrom,
        public ?string $validTo,
        public int     $remainDays,
    )
    {
        //
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function remainDays(): int
    {
        return $this->remainDays;
    }

    public function willExpire(int $dayBefore): bool
    {
        return $this->remainDays() <= $dayBefore;
    }


    public function validFrom(): ?Carbon
    {
        return $this->validFrom
            ? Carbon::parse($this->validFrom)
            : null;
    }

    public function validTo(): ?Carbon
    {
        return $this->validTo
            ? Carbon::parse($this->validTo)
            : null;
    }
}
