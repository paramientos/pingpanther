<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasUuids;

    protected $table = 'teams';
    protected $guarded = [];

    public static string $teamId = 'E5FF9D51-B739-45C0-A767-86B88E6DC7BD';

    public function plan(): HasOne
    {
        return $this->hasOne(Subscription::class, 'team_id', 'id')->where('status', true);
    }
}
