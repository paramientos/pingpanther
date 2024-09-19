<?php

namespace App\Jobs\Monitors\PingTcp;

use App\Attributes\Override;
use App\Enums\ProtocolSocketType;
use App\Jobs\Monitors\Ping\PingJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class PingTcpJob extends PingJob implements ShouldQueue
{
    #[Override]
    protected ProtocolSocketType $portType = ProtocolSocketType::TCP;
}
