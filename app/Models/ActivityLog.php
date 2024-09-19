<?php

namespace App\Models;

use App\Concerns\UuidModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\ActivityLog
 *
 * @property string $id
 * @property string $check_id
 * @property string $monitor_type
 * @property string|null $alert_log_id
 * @property string|null $event
 * @property string|null $result_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Models\Monitor|null $check
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereAlertLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCheckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereMonitorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereResultText($value)
 * @property-read \App\Models\Monitor|null $monitor
 * @property float|null $response_time
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereResponseTime($value)
 * @mixin \Eloquent
 */
class ActivityLog extends Model
{
    use  UuidModel;

    protected $table = 'activity_logs';
    protected $guarded = [];

    public const UPDATED_AT = null;

    // Relations
    public function monitor(): HasOne
    {
        return $this->hasOne(Monitor::class, 'id', 'check_id');
    }

    public function getAlertCount(): int
    {
        return $this->whereIn('event', get_only_negative_events($this->monitor_type))->count();
    }
}
