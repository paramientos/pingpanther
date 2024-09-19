<?php

namespace App\Services;

use App\Exceptions\JobClassDoesNotExist;
use App\Models\AlertLog;
use App\Models\Monitor;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Alert
{
    public static function notify(string $message, Monitor $monitor, ?AlertLog $log, string|array $channel): void
    {
        $channels = Arr::wrap($channel);

        foreach ($channels as $channel) {
            $channel = Str::studly($channel);
            $className = "\\App\\Notifications\\$channel";

            if (!class_exists($className)) {
                JobClassDoesNotExist::make($className);
            }

            $monitor->notify(new $className($message, $log, $monitor));
        }
    }
}
