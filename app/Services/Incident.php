<?php

namespace App\Services;

use App\Exceptions\JobClassDoesNotExist;
use App\Models\AlertLog;
use App\Models\Monitor;
use Illuminate\Support\Arr;

class Incident
{
    public static function count(): int
    {
        return \App\Models\Incident::whereNull('resolved_at')->count();
    }

    public static function text(): string
    {
        $unresolvedIncidentCount = self::count();
        return $unresolvedIncidentCount > 0 ? "<b>({$unresolvedIncidentCount})</b></span>" : '';
    }
}
