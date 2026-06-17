<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Country extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'code',
        'iso2',
        'iso3',
        'phonecode',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}