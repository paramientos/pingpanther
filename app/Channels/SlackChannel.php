<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SlackChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!$url = $notifiable->routeNotificationFor('slack')) {
            return;
        }

        $args = $notification->toSlack($notifiable);

        $payload = ['type' => $args['type'], 'text' => $args['message']];

        Http::post($url, $payload);
    }
}
