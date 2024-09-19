<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Website;
use Illuminate\Support\Facades\Http;

class CheckWebsiteStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function handle()
    {
        try {
            $response = Http::get($this->website->url);

            if ($response->successful()) {
                $this->website->update(['status' => 'up']);
                $this->website->resolveLastIncident();
            } else {
                $this->website->update(['status' => 'down']);
                $this->website->createIncident();
            }
        } catch (\Exception $e) {
            $this->website->update(['status' => 'down']);
            $this->website->createIncident();
        }
    }
}
