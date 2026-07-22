<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Deal extends Model
{
    use HasUuids;

    protected $fillable = [
        'project_id',
        'allotted_inventory_id',
        'allotted_at',
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
        'booking_date',
        'booking_amount',
        'total_amount',
        'status',
        'deal_status',
        'payment_status',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'booking_date' => 'datetime',
            'allotted_at' => 'datetime',
            'booking_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'waiver_code', 'code');
    }

    public function allottedInventory()
    {
        return $this->belongsTo(Inventory::class, 'allotted_inventory_id');
    }
}
