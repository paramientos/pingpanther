<?php

namespace App\Jobs\Monitors\PingUdp;

use App\Attributes\Override;
use App\Enums\ProtocolSocketType;
use App\Jobs\Monitors\Ping\PingJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class PingUdpJob extends PingJob implements ShouldQueue
{
    #[Override]
    protected ProtocolSocketType $portType = ProtocolSocketType::UDP;
}
