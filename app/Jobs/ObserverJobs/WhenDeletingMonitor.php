<?php

namespace App\Jobs\ObserverJobs;

use App\Models\ActivityLog;
use App\Models\AlertLog;
use App\Models\Domain;
use App\Models\Incident;
use App\Models\PostMortem;
use App\Models\SslCertificate;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WhenDeletingMonitor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public string $monitorId)
    {
    }

    public function handle(): void
    {
        ActivityLog::whereCheckId($this->monitorId)->delete();
        AlertLog::whereCheckId($this->monitorId)->delete();
        Domain::whereMonitorId($this->monitorId)->delete();
        Incident::whereCheckId($this->monitorId)->delete();
        PostMortem::whereMonitorId($this->monitorId)->delete();
        //Setting::whereTeamId($this->teamId)->delete();
        SslCertificate::whereMonitorId($this->monitorId)->delete();
    }
}
