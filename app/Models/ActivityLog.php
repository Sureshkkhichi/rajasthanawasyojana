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

    public function getFormattedDescriptionHtmlAttribute(): string
    {
        $desc = e($this->description ?? '');

        $dealModel = $this->deal;
        if (!$dealModel && $this->deal_id) {
            $dealModel = Deal::find($this->deal_id);
        }

        if ($dealModel) {
            $customerName = e($dealModel->first_name . ' ' . $dealModel->last_name);
            $dealUrl = route('deals.show', $dealModel->id);
            $dealLink = '<a href="' . $dealUrl . '" class="fw-semibold text-primary text-decoration-underline" title="View Deal">' . $customerName . '</a>';

            $desc = preg_replace('/Deal\s*#[0-9a-f\-]{36}\s*\([^)]+\)/i', "Deal ({$dealLink})", $desc);
            $desc = preg_replace('/Deal\s*#[0-9a-f\-]{36}/i', "Deal ({$dealLink})", $desc);
        }

        $inventoryModel = $this->inventory;
        if (!$inventoryModel && $this->inventory_id) {
            $inventoryModel = Inventory::find($this->inventory_id);
        }

        if ($inventoryModel) {
            $unitName = e($inventoryModel->unit_name);
            $invUrl = route('inventories.edit', $inventoryModel->id);
            $unitLink = '<a href="' . $invUrl . '" class="fw-semibold text-info text-decoration-underline" target="_blank" title="View Inventory">' . $unitName . '</a>';

            $desc = preg_replace('/Unit\s*#[0-9a-f\-]{36}/i', "Unit {$unitLink}", $desc);
            $desc = preg_replace('/Unit\s*#/i', "Unit {$unitLink}", $desc);
        }

        $desc = preg_replace('/\s*#[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i', '', $desc);

        return $desc;
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
