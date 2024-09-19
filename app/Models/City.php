<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CityModel
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @property int $country_id
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCountryId($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $guarded = [];

    public $timestamps = false;
}
