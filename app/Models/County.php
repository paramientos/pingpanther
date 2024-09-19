<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CountyModel
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|County newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|County newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|County query()
 * @method static \Illuminate\Database\Eloquent\Builder|County whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|County whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|County whereName($value)
 * @mixin \Eloquent
 */
class County extends Model
{
    use HasFactory;

    protected $table = 'counties';
    protected $guarded = [];

    public $timestamps = false;
}
