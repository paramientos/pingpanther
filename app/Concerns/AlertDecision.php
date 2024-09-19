<?php

namespace App\Concerns;

use App\Models\AlertLog;
use App\Models\Monitor;

trait AlertDecision
{
    public function shouldAlert(Monitor $monitor): bool
    {
        $log = AlertLog::where([
            'check_id' => $monitor->id,
        ])
            ->latest()
            ->first();

       /* // Check if it is first success event
        if (!$log && $this->occurredEvent === $this->resolveEvent) {
            return false;
        }*/

        if (!$monitor->isFrequencyTyped()) {
            $shouldAlert = true;
        } else {
            $shouldAlert = $monitor->alert_count < $monitor->frequency;

            if (!$shouldAlert) {
                $frequencyTypeInSeconds = get_frequency_type_as_seconds($monitor->frequency_type);

                if ($monitor->isSuitableToAlertAgain($frequencyTypeInSeconds)) {
                    $shouldAlert = true;
                    $monitor->clearFrequencyValues();
                }
            }
        }

        return (!$log || $log->event === $this->viceVersaEvent) && $shouldAlert;
    }
}
