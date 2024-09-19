<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendDiscordNotification
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $webhookUrl = 'https://discord.com/api/webhooks/1236256190481043516/A2f6jcDbmcKbqLfW44tKJpnoC9adbk2jojIRuSr013lSd1CfxTlKa6URyb2j2AB3MnqS';

    public function __construct(private readonly string $url)
    {
        //
    }

    public function handle()
    {
        $message = "Gibinin yeni bölümü yayınlandı. Şu adresten izleyebilirsiniz : {$this->url}";

        $data = [
            'content' => $message
        ];

        Http::post($this->webhookUrl, $data);
    }
}
