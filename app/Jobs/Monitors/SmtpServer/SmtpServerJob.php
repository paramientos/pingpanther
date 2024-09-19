<?php

namespace App\Jobs\Monitors\SmtpServer;

use App\Models\Monitor;
use App\Services\Monitors\SmtpJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmtpServerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public Monitor $monitor)
    {
        //
    }

    public function handle(): void
    {
        $service = new SmtpJobService(monitor: $this->monitor);

        $service->run();
    }
}
