<?php

namespace App\Models;

use App\Concerns\UuidModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Incident
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Incident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Incident query()
 * @property string $id
 * @property string $check_id
 * @property string $occurred_at
 * @property string|null $resolved_at
 * @method static \Illuminate\Database\Eloquent\Builder|Incident whereCheckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incident whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incident whereOccurredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Incident whereResolvedAt($value)
 * @property-read \App\Models\Monitor|null $check
 * @method static Builder|Incident toResolve()
 * @method static Builder|Incident inLastWeek()
 * @method static Builder|Incident inToday()
 * @method static Builder|Incident inYesterday()
 * @method static Builder|Incident inLastYear()
 * @method static Builder|Incident inLastMonth()
 * @property-read \App\Models\Monitor|null $monitor
 * @mixin \Eloquent
 */
class Incident extends Model
{
    use HasUuids;

    protected $table = 'incidents';
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'occurred_at' => 'datetime',
        'resolved_at' => 'datetime'
    ];

    public function isResolved(): bool
    {
        return !empty($this->resolved_at);
    }

    public function suitableToPostMortem(): bool
    {
        return $this->isResolved() && $this->doesntHavePostMortem();
    }

    public function isNotResolved(): bool
    {
        return empty($this->resolved_at);
    }

    public function hasPostMortem(): bool
    {
        return $this->postMortem()->exists();
    }

    public function doesntHavePostMortem(): bool
    {
        return $this->postMortem()->doesntExist();
    }

    // Relations
    public function monitor(): HasOne
    {
        return $this->hasOne(Monitor::class, 'id', 'check_id');
    }

    public function postMortem(): HasOne
    {
        return $this->hasOne(PostMortem::class, 'incident_id', 'id');
    }

    // Scopes
    public function scopeToResolve(Builder $query): Builder
    {
        return $query->whereNotNull('occurred_at')->whereNull('resolved_at');
    }

    public function scopeInToday(Builder $query): Builder
    {
        return $query
            ->where('occurred_at', '>=', Carbon::today())
            ->where('occurred_at', '<=', Carbon::tomorrow());
    }

    public function scopeInYesterday(Builder $query): Builder
    {
        return $query
            ->where('occurred_at', '>=', Carbon::yesterday())
            ->where('occurred_at', '<=', Carbon::yesterday());
    }

    public function scopeInLastWeek(Builder $query): Builder
    {
        return $query
            ->where('occurred_at', '>=', Carbon::now()->startOfWeek())
            ->where('occurred_at', '<=', Carbon::now()->endOfWeek());
    }

    public function scopeInLastMonth(Builder $query): Builder
    {
        return $query
            ->where('occurred_at', '>=', Carbon::now()->startOfMonth())
            ->where('occurred_at', '<=', Carbon::now()->endOfMonth());
    }

    public function scopeInLastYear(Builder $query): Builder
    {
        return $query
            ->where('occurred_at', '>=', Carbon::now()->startOfYear())
            ->where('occurred_at', '<=', Carbon::now()->endOfYear());
    }
}
