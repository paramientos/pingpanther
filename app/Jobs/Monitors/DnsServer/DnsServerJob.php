<?php

namespace App\Jobs\Monitors\DnsServer;

use App\Enums\DnsTypes;
use App\Models\Monitor;
use App\Services\Monitors\DnsServerJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DnsServerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public readonly Monitor $monitor)
    {
        //
    }

    public function handle(): void
    {
        $service = new DnsServerJobService(
            monitor: $this->monitor,
            dnsType: DnsTypes::from($this->monitor->parameter('dns_type')) ?? DnsTypes::default(),
            expectedValues: (array)$this->monitor->parameter('expected_dns_values') ?? []
        );

        $service->run();
    }
}
