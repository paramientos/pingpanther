<?php

namespace App\Jobs;

use App\Events\ExceptionTraceMonitor\ExceptionOccurred;
use App\Models\Administrator;
use App\Models\Monitor;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TraceExceptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public Monitor $check;

    public function __construct(public array $log)
    {
    }

    public function handle(): void
    {
        Administrator::firstWhere('api_token', $this->log['token'])->sole();
        $this->check = Monitor::findOrFail($this->log['check_id']);

        event(new ExceptionOccurred($this->check, $this->log));
    }


}
