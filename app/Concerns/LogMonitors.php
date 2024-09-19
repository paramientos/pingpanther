<?php

namespace App\Concerns;

use App\Models\ActivityLog;
use App\Models\AlertLog;
use App\Models\Monitor;
use App\Services\Alert;
use Exception;

/**
 * @property string $occurredEvent
 * @property string $viceVersaEvent
 */
trait LogMonitors
{
    use IncidentDecision, AlertDecision, DescribeEvents;

    public function logMonitor(Monitor $monitor, string $message, ?string $result = null, bool $logActivity = true): void
    {
        $now = now();

        if ((property_exists($this, 'forceToSend') && $this->forceToSend === true) || $this->shouldAlert($monitor)) {

            $log = AlertLog::create([
                'check_id' => $monitor->id,
                'event' => $this->occurredEvent,
                'params' => $monitor->params,
                'alert_message' => $message,
                'result' => $result
            ]);

            if ($monitor->on_call_methods && !$monitor->isMaintenanceSlot()) {
                $channels = $monitor->getChannels();

                if (!empty($channels)) {
                    Alert::notify($message, $monitor, $log, $channels);
                }
            }

            if ($monitor->alert_count === 0) {
                $monitor->update([
                    'first_alerted_at' => $now
                ]);
            }

            $monitor->increment('alert_count');
            $monitor->increment('total_alert_count');
        }

        $isFirstLog = $this->isFirstLog($monitor->id);

        if ($this->isAHealthyEvent()) {
            if ($isFirstLog) {
                $monitor->update([
                    'first_seen_at' => $now
                ]);
            }

            $monitor->update([
                'last_seen_at' => $now
            ]);
        }

        $monitor->last_status = $this->isAHealthyEvent();

        $monitor->update([
            'last_run_at' => $now
        ]);

        //Create or update an incident depending on the status
        $this->handleIncident($monitor, $now);

        $logId = $log->id ?? null;

        if ($isFirstLog || $logActivity) {
            $this->logActivity($monitor, $result, $logId);
        }
    }

    public function isFirstLog(string $checkId): bool
    {
        return ActivityLog::whereCheckId($checkId)->doesntExist();
    }

    private function logActivity(Monitor $check, ?string $resultText = null, ?string $alertLogId = null): void
    {
        try {
            $responseTimeJson = json_decode($resultText, true);
            $responseTime = $responseTimeJson['response_in_sec'] ?? null;
        } catch (Exception) {
            $responseTime = null;
        }

        ActivityLog::create([
            'check_id' => $check->id,
            'monitor_type' => $check->monitor_type,
            'event' => $this->occurredEvent,
            'result_text' => $resultText,
            'alert_log_id' => $alertLogId,
            'response_time' => $responseTime
        ]);
    }
}
