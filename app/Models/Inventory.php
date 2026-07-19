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
        'inventory_type',
        'price',
        'status',
        'remarks',
        
        // Plot specific fields
        'plot_no',
        'area_sq_yards',
        'road_size',
        'plc_percentage',
        'plc_status',

        // Flat specific fields
        'floor',
        'flat_no',
        'unit_type',
        'area_sbup',
        'carpet_area',
        'super_buildup_area',
    ];

    protected $casts = [
        'price' => 'float',
        'area_sq_yards' => 'float',
        'plc_percentage' => 'float',
        'area_sbup' => 'float',
        'carpet_area' => 'float',
        'super_buildup_area' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    public function getInventoryTypeLabelAttribute(): string
    {
        return $this->inventory_type === 'flat' ? 'Flat Project' : 'Plot Project';
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

    public function deal(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Deal::class, 'allotted_inventory_id');
    }
}
