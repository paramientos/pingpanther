<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TeamSetting
 *
 * @property int $id
 * @property string $team_id
 * @property string $key
 * @property string|null $value
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamSetting whereValue($value)
 * @mixin \Eloquent
 */
class TeamSetting extends Model
{
    protected $table = 'team_settings';
    protected $guarded = [];
}
