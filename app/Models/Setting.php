<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $group
 * @property string|null $type
 * @property string|null $label
 * @property string|null $help_text
 * @property string|null $possible_values
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereHelpText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting wherePossibleValues($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 * @property string|null $team_id
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereTeamId($value)
 * @mixin \Eloquent
 */
class Setting extends Model
{
    protected $table = 'settings';
    protected $guarded = [];

    public static function put(string $key, mixed $value): void
    {
        Setting::updateOrCreate([
            'key' => $key
        ], [
            'value' => $value
        ]);
    }

    public static function byKey(string $group, string $key): mixed
    {
        return Setting::firstWhere([
            'group' => $group,
            'key' => $key
        ])->value;
    }

    public static function byGroup(string $name): Collection|array
    {
        return Setting::where('group', $name)->get();
    }
}
