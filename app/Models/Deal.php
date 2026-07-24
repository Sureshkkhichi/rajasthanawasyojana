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

    public function getCalculatedTotalAmountAttribute(): float
    {
        // 1. If an inventory unit is allotted and has a price > 0, use that
        if ($this->allottedInventory && (float)$this->allottedInventory->price > 0) {
            return (float) $this->allottedInventory->price;
        }

        // 2. If project is plotting and flat_size (area_sq_yards) is numeric
        if ($this->project && $this->project->inventory_type === 'plot' && is_numeric($this->flat_size) && (float)$this->flat_size > 0 && is_numeric($this->project->price) && (float)$this->project->price > 0) {
            return (float)$this->project->price * (float)$this->flat_size;
        }

        // 3. If stored total_amount > 0
        if ($this->total_amount && (float)$this->total_amount > 0) {
            return (float) $this->total_amount;
        }

        // 4. Fallback to project price
        return (float) ($this->project?->price ?: 0);
    }
}
