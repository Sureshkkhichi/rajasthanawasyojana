<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'code',
        'commission_type',
        'commission_value',
        'status',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'waiver_code', 'code');
    }
}
