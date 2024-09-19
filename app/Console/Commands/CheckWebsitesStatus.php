<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Jobs\CheckWebsiteStatus;

class CheckWebsitesStatus extends Command
{
    protected $signature = 'websites:check-status';
    protected $description = 'Check the status of all websites';

    public function handle()
    {
        Website::chunk(100, function ($websites) {
            foreach ($websites as $website) {
                CheckWebsiteStatus::dispatch($website);
            }
        });

        $this->info('Website status check jobs dispatched successfully.');
    }
}
