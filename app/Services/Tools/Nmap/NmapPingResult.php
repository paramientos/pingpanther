<?php

namespace App\Services\Tools\Nmap;

class NmapPingResult
{
    public bool $status;

    public function __construct(public ?int $count = null, public ?string $statusAsText = null, public ?float $latencyInSeconds = null)
    {
        $this->status = $statusAsText === 'up' && $this->count === 1;
    }
}
