<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class TeamsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!$url = $notifiable->routeNotificationFor('teams')) {
            return;
        }

        $payload = $notification->toTeams($notifiable);

        Http::post($url, $payload);
    }
}
