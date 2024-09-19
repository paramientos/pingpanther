<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class DiscordChannel
{
    public function send($notifiable, Notification $notification): void
    {
        if (!$url = $notifiable->routeNotificationFor('discord')) {
            return;
        }

        $args = $notification->toDiscord($notifiable);

        $payload = ['username' => 'Testing BOT', 'content' => $args['message']];

        Http::post($url, $payload);
    }
}
