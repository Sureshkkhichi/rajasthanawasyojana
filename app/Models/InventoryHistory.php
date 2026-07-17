<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryHistory extends Model
{
    use HasUuids;

    protected $fillable = [
        'inventory_id',
        'from_status',
        'to_status',
        'changed_by',
        'notes',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
