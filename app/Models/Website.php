<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Website extends Model
{
    protected $guarded = [];

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }
}
