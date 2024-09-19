<?php

namespace App\Jobs\Monitors\ImapServer;

use App\Models\Monitor;
use App\Services\Monitors\ImapJobService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImapServerJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public readonly Monitor $monitor)
    {
        //
    }

    public function handle(): void
    {
        $service = new ImapJobService(monitor: $this->monitor);

        $service->run();
    }
}
