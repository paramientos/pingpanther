<?php

namespace App\Concerns;

use App\Models\ActivityLog;
use App\Models\AlertLog;
use App\Models\Monitor;
use App\Models\Client;
use App\Services\MetricAlert;

/**
 * @property string $occurredEvent
 * @property string $viceVersaEvent
 */
trait LogMetricAlarms
{
    use IncidentDecision, AlertDecision, DescribeEvents;

    public function logMetricAlarm(Client $server, string $message, string $result = null)
    {
        $now = now();

        if ((property_exists($this, 'forceToSend') && $this->forceToSend === true) || $this->shouldAlert($check)) {
            $log = AlertLog::create([
                'check_id' => $check->id,
                'event' => $this->occurredEvent,
                'params' => $check->params,
                'alert_message' => $message,
                'result' => $result
            ]);

            MetricAlert::send($message, $server, ['slack']);

            if ($check->alert_count === 0) {
                $check->update([
                    'first_alerted_at' => $now
                ]);
            }

            $check->increment('alert_count');
            $check->increment('total_alert_count');
        }

        if ($this->isAHealthyEvent()) {
            if ($this->checkForFirstLog($check->id)) {
                $check->update([
                    'first_seen_at' => $now
                ]);
            }

            $check->update([
                'last_seen_at' => $now
            ]);
        }

        $check->last_status = $this->isAHealthyEvent();

        $check->update([
            'last_run_at' => $now
        ]);

        //Create or update an incident depending on the status
        $this->handleIncident($check, $now);

        $logId = $log->id ?? null;

        $this->logActivity($check, $result, $logId);
    }

    public function checkForFirstLog(string $checkId): bool
    {
        return ActivityLog::whereCheckId($checkId)->doesntExist();
    }

    private function logActivity(Monitor $check, ?string $resultText = null, ?string $alertLogId = null)
    {
        ActivityLog::create([
            'check_id' => $check->id,
            'monitor_type' => $check->monitor_type,
            'event' => $this->occurredEvent,
            'result_text' => $resultText,
            'alert_log_id' => $alertLogId
        ]);
    }


}
