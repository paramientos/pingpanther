<?php

namespace App\Jobs\Monitors\BecomesUnavailable;

use App\Models\Monitor;
use App\Services\Monitors\BecomesUnavailableJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SSLExpirationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public readonly Monitor $monitor)
    {
        //
    }

    public function handle(): void
    {
        (new BecomesUnavailableJobService(monitor: $this->monitor))->checkSSLExpiration();
    }
}
