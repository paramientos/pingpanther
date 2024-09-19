<?php

namespace App\Jobs\Monitors\Ping;

use App\Enums\ProtocolSocketType;
use App\Models\Monitor;
use App\Services\Monitors\PingJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected ProtocolSocketType $portType = ProtocolSocketType::BOTH;

    public function __construct(public Monitor $monitor)
    {
        //
    }

    public function handle(): void
    {

        $service = new PingJobService(
            monitor: $this->monitor,
            socketType: $this->portType,
            port: $this->monitor->parameter('ping_port')
        );

        $service->run();
    }
}
