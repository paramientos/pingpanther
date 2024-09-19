<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\PostMortem
 *
 * @property string $id
 * @property string $monitor_id
 * @property string|null $incident_id
 * @property string $notes
 * @property bool $is_resolved
 * @property string $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereIncidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereIsResolved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMortem whereNotes($value)
 * @mixin \Eloquent
 */
class PostMortem extends Model
{
    use HasUuids;

    protected $table = 'post_mortems';
    protected $guarded = [];

    public const UPDATED_AT = null;

    public function monitor(): HasOne
    {
        return $this->hasOne(Monitor::class, 'id', 'monitor_id');
    }

    public function incident(): HasOne
    {
        return $this->hasOne(Incident::class, 'id', 'incident_id');
    }

    public function createdBy(): HasOne
    {
        return $this->hasOne(Administrator::class, 'id', 'created_by');
    }
}
