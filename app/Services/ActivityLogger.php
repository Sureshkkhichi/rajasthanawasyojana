<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Lead;
use App\Models\Deal;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log a general activity.
     */
    public static function log(
        string $logType,
        string $title,
        ?string $description = null,
        ?string $event = null,
        ?Model $subject = null,
        array $properties = [],
        ?string $userId = null,
        bool $isSystemGenerated = false
    ): ActivityLog {
        $actingUserId = $userId ?? Auth::id();

        $leadId = null;
        $dealId = null;
        $inventoryId = null;

        if ($subject) {
            if ($subject instanceof Lead) {
                $leadId = $subject->id;
            } elseif ($subject instanceof Deal) {
                $dealId = $subject->id;
                $leadId = $subject->lead_id;
                $inventoryId = $subject->allotted_inventory_id;
            } elseif ($subject instanceof Inventory) {
                $inventoryId = $subject->id;
            }
        }

        // Allow direct setting from properties if passed explicitly
        if (isset($properties['lead_id'])) {
            $leadId = $properties['lead_id'];
        }
        if (isset($properties['deal_id'])) {
            $dealId = $properties['deal_id'];
        }
        if (isset($properties['inventory_id'])) {
            $inventoryId = $properties['inventory_id'];
        }

        return ActivityLog::create([
            'user_id' => $actingUserId,
            'log_type' => $logType,
            'lead_id' => $leadId,
            'deal_id' => $dealId,
            'inventory_id' => $inventoryId,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->id : null,
            'title' => $title,
            'event' => $event,
            'description' => $description,
            'properties' => $properties,
            'is_system_generated' => $isSystemGenerated,
        ]);
    }

    /**
     * Helper for Lead logs
     */
    public static function logLead(Lead $lead, string $event, string $title, ?string $description = null, array $properties = []): ActivityLog
    {
        return self::log('lead', $title, $description, $event, $lead, $properties);
    }

    /**
     * Helper for Deal logs
     */
    public static function logDeal(Deal $deal, string $event, string $title, ?string $description = null, array $properties = []): ActivityLog
    {
        return self::log('deal', $title, $description, $event, $deal, $properties);
    }

    /**
     * Helper for Inventory logs
     */
    public static function logInventory(Inventory $inventory, string $event, string $title, ?string $description = null, array $properties = []): ActivityLog
    {
        return self::log('inventory', $title, $description, $event, $inventory, $properties);
    }
}
