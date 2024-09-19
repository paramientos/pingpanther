<?php

namespace App\Concerns;

use App\Models\Monitor;
use App\Models\Incident;
use Illuminate\Support\Carbon;

trait IncidentDecision
{
    use DescribeEvents;

    public function handleIncident(Monitor $monitor, Carbon $timestamp): void
    {
        $incident = Incident::where([
            'check_id' => $monitor->id,
            'event' => $this->incidentEvent,
        ])
            ->toResolve();

        if ($incident->doesntExist() && $this->isAnIncidentEvent()) {
            Incident::create([
                'check_id' => $monitor->id,
                'occurred_at' => $timestamp,
                'event' => $this->occurredEvent,
            ]);

            $monitor->update([
                'last_incident_at' => $timestamp
            ]);
        }

        if ($incident->exists() && $this->isAHealthyEvent()) {
            Incident::query()
                ->where('check_id', $monitor->id)
                ->toResolve()
                ->update([
                    'resolved_at' => $timestamp
                ]);

            $monitor->update([
                'last_resolved_at' => $timestamp
            ]);
        }
    }
}
