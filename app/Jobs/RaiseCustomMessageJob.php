<?php

namespace App\Jobs;

use App\Events\CustomMessageMonitor\CustomMessageArrived;
use App\Models\Administrator;
use App\Models\Monitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RaiseCustomMessageJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Monitor $check;

    public function __construct(public array $log)
    {
    }

    public function handle(): void
    {
        Administrator::firstWhere('api_token', $this->log['token'])->sole();
        $this->check = Monitor::findOrFail($this->log['check_id']);


        event(new CustomMessageArrived($this->check, $this->log));
    }


}
