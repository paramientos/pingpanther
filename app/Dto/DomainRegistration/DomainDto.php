<?php

namespace App\Dto\DomainRegistration;

use App\Services\StringManipulation;
use Carbon\Carbon;

class DomainDto extends StringManipulation
{
    public function __construct(
        public ?string         $domainName,
        public ?string         $whoisServer,
        public ?array          $nameServers,
        public int|string|null $creationDate,
        public int|string|null $expirationDate,
        public int|string|null $updatedDate,
        public ?string         $owner,
        public ?string         $registrar,
        public ?string         $dnssec)
    {
        //
    }

    public function remainDays(): int
    {
        return now()->diffInDays(Carbon::parse($this->expirationDate), absolute: false);
    }

    public function willExpire(int $dayBefore): bool
    {
        return $this->remainDays() <= $dayBefore;
    }

    public function nameServers(): null|bool|string
    {
        return json_encode($this->nameServers);
    }

    public function creationDate(): ?Carbon
    {
        return $this->creationDate
            ? Carbon::parse($this->creationDate)
            : null;
    }

    public function expirationDate(): ?Carbon
    {
        return $this->expirationDate
            ? Carbon::parse($this->expirationDate)
            : null;
    }

    public function updatedDate(): ?Carbon
    {
        return $this->updatedDate
            ? Carbon::parse($this->updatedDate)
            : null;
    }
}
