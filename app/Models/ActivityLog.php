<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'log_type',
        'lead_id',
        'deal_id',
        'inventory_id',
        'subject_type',
        'subject_id',
        'title',
        'event',
        'description',
        'properties',
        'is_system_generated',
    ];

    protected $casts = [
        'properties' => 'array',
        'is_system_generated' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    // Badge color helper
    public function getBadgeColorAttribute(): string
    {
        return match ($this->event) {
            'created' => 'primary',
            'status_changed' => 'info',
            'sms_sent' => 'warning',
            'email_sent' => 'primary',
            'pdf_downloaded' => 'purple',
            'unit_allotted' => 'info',
            'marked_sold' => 'success',
            'marked_refund' => 'warning',
            'marked_cancel' => 'danger',
            'marked_not_alloted' => 'secondary',
            'allotment_mail_sent', 'demand_mail_sent' => 'success',
            default => 'dark',
        };
    }

    // Icon helper
    public function getIconAttribute(): string
    {
        return match ($this->event) {
            'created' => 'ri-add-circle-line',
            'status_changed' => 'ri-git-commit-line',
            'sms_sent' => 'ri-message-2-line',
            'email_sent', 'allotment_mail_sent', 'demand_mail_sent' => 'ri-mail-send-line',
            'pdf_downloaded' => 'ri-file-pdf-2-line',
            'unit_allotted' => 'ri-building-line',
            'marked_sold' => 'ri-checkbox-circle-line',
            'marked_refund' => 'ri-refund-2-line',
            'marked_cancel' => 'ri-close-circle-line',
            'marked_not_alloted' => 'ri-subtract-line',
            default => 'ri-history-line',
        };
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at ? $this->created_at->diffForHumans() : '';
    }

    // Scopes
    public function scopeForLead($query, $leadId)
    {
        return $query->where('lead_id', $leadId);
    }

    public function scopeForDeal($query, $dealId)
    {
        return $query->where('deal_id', $dealId);
    }

    public function scopeForInventory($query, $inventoryId)
    {
        return $query->where('inventory_id', $inventoryId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('log_type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
