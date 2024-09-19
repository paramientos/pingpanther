<?php

namespace App\Concerns;

use App\Models\AlertLog;
use App\Models\Monitor;
use App\Services\Alert;
use Illuminate\Database\Eloquent\Model;

class LogAlert
{
    use LogMonitors;

    public function logAlert(Model $model, Monitor $monitor, string $message, bool $forceAlert = false, ?string $jsonData = null): void
    {
        // We will update the log every time, so that keep on top the alert message
        $alertLog = AlertLog::updateOrCreate([
            'check_id' => $monitor->id,
            'event' => $this->occurredEvent,
        ], [
            'params' => $monitor->params,
            'alert_message' => $message,
            'result' => $jsonData,
        ]);

        if (($forceAlert || $model->hasNotNotified()) && $monitor->hasOnCallMethods()) {
            $this->logActivity($monitor, $message, $alertLog->id);

            $channels = $monitor->getChannels();

            if (!empty($channels) && !$monitor->isMaintenanceSlot()) {
                Alert::notify($message, $monitor, $alertLog, $channels);

                $model->notified = true;
                $model->save();
            }
        }
    }
}
