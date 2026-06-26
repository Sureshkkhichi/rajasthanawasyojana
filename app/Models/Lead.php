<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Lead extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'project_id',

        'status',
        'payment_status',

        'first_name',
        'last_name',
        'father_husband_name',

        'pan_number',
        'gender',
        'email',
        'phone',
        'date_of_birth',
        'occupation',

        'address',
        'state_id',
        'state_name',
        'city_id',
        'city',

        'co_applicant_name',
        'flat_size',

        'waiver_code',

        'ip_address',
        'user_agent',

        'is_submitted',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'is_submitted' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSubmitted($query)
    {
        return $query->where('is_submitted', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('is_submitted', false);
    }

    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeInProcess($query)
    {
        return $query->where('status', 'in_process');
    }
}