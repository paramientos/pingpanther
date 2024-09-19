<?php

namespace App\Channels;

use App\Models\AlertLog;
use App\Models\Monitor;
use App\Notifications\NotificationTemplate;
use Notification;

class EmailChannel
{
    public function send(string $message, Monitor $check, AlertLog $log): void
    {
        $to = 'soysaltann@gmail.com';

        Notification::route('mail', $to)
            ->notify(new NotificationTemplate($message));
    }
}
