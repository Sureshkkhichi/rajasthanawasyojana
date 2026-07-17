<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'project_id',
        'plot_no',
        'area',
        'road_size',
        'plc_percentage',
        'facing_type',
        'length',
        'breadth',
        'shape',
        'remarks',
        'price',
        'price_in_words',
        'cost_price',
        'status',
        'status_effective_from',
        'notes',
        'documents',
        'map_layout',
        'hold_by',
        'hold_till',
        'booked_by',
        'booked_on',
    ];

    protected $casts = [
        'area' => 'float',
        'plc_percentage' => 'float',
        'length' => 'float',
        'breadth' => 'float',
        'price' => 'float',
        'cost_price' => 'float',
        'status_effective_from' => 'date',
        'hold_till' => 'date',
        'booked_on' => 'datetime',
        'documents' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getInventoryTypeAttribute(): string
    {
        if (!$this->project) {
            return 'Plot Project';
        }
        $typeName = $this->project->projectType ? $this->project->projectType->name : '';
        if (stripos($typeName, 'plot') !== false) {
            return 'Plot Project';
        }
        return 'Flat Project';
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class)->orderBy('created_at', 'desc');
    }
}
