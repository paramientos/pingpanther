<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\AlertLog
 *
 * @property string $id
 * @property string $check_id
 * @property string|null $params
 * @property string $event
 * @property string|null $result
 * @property string|null $notified_to
 * @property string|null $notified_with
 * @property string|null $alert_message
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Monitor|null $check
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereAlertMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereCheckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereNotifiedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereNotifiedWith($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlertLog whereResult($value)
 * @mixin \Eloquent
 */
class AlertLog extends Model
{
    use HasUuids;

    protected $table = 'alert_logs';
    protected $guarded = [];

    // Relations
    public function check(): HasOne
    {
        return $this->hasOne(Monitor::class, 'id', 'check_id');
    }
}
