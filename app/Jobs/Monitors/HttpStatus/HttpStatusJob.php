<?php

namespace App\Jobs\Monitors\HttpStatus;

use App\Models\Monitor;
use App\Services\Monitors\HttpStatusJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HttpStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public readonly Monitor $monitor)
    {
        //
    }

    public function handle(): void
    {
        $httpMethod = $this->monitor->parameter('http_method_endpoint');
        $expectedStatusCodes = (array)$this->monitor->parameter('expected_status_codes_endpoint');

        $this->monitor->willCheckDomainExpire() && $this->monitor->runDomainExpirationJob();

        $this->monitor->willCheckSSLExpire() && $this->monitor->runSSLExpirationJob();

        $this->monitor->willCheckTLSVerification() && $this->monitor->runTLSVerificationJob();

        $service = new HttpStatusJobService(
            monitor: $this->monitor,
            expectedStatusCodes: $expectedStatusCodes,
            method: $httpMethod
        );

        $service->run();
    }
}
