<?php

namespace App\Jobs\ObserverJobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class DeleteScreenShotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public function __construct(public string $monitorId)
    {
    }

    public function handle(): void
    {
        $image = sprintf('/ss/%s.png', md5($this->monitorId));
        $path = public_path($image);

        if (file_exists($path)) {
            File::delete($path);
        }
    }
}
