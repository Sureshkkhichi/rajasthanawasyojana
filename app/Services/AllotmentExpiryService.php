<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use Illuminate\Support\Facades\Log;

class AllotmentExpiryService
{
    /**
     * Check and expire unit allotments older than 7 days.
     *
     * @return int Number of expired deals processed
     */
    public function expireOldAllotments(): int
    {
        $expiredDeals = Deal::query()
            ->whereNotNull('allotted_inventory_id')
            ->where('status', '!=', 'Sold')
            ->where(function ($q) {
                $q->where('allotted_at', '<=', now()->subDays(7))
                  ->orWhere(function ($sub) {
                      $sub->whereNull('allotted_at')
                          ->where('updated_at', '<=', now()->subDays(7));
                  });
            })
            ->get();

        $count = 0;

        foreach ($expiredDeals as $deal) {
            $unit = Inventory::find($deal->allotted_inventory_id);

            if ($unit) {
                $oldStatus = $unit->status;
                $unit->update(['status' => 'Available']);

                InventoryHistory::create([
                    'inventory_id' => $unit->id,
                    'from_status' => $oldStatus,
                    'to_status' => 'Available',
                    'changed_by' => 'System (Auto-expiry)',
                    'notes' => 'Unit allotment automatically cancelled after 7 days without being marked Sold.',
                ]);

                ActivityLogger::logInventory(
                    $unit,
                    'allotment_expired',
                    "Allotment for unit #{$unit->unit_number} automatically cancelled after 7 days.",
                    $oldStatus,
                    'Available',
                    $deal->id,
                    $deal->lead_id
                );
            }

            ActivityLogger::logDeal(
                $deal,
                'allotment_expired',
                "Unit allotment for deal #{$deal->id} automatically cancelled after 7 days without being marked Sold.",
                [
                    'unit_id' => $deal->allotted_inventory_id,
                    'unit_number' => $unit?->unit_number,
                ]
            );

            $deal->update([
                'allotted_inventory_id' => null,
                'allotted_at' => null,
            ]);

            $count++;
        }

        if ($count > 0) {
            Log::info("AllotmentExpiryService: Expired {$count} unit allotment(s) older than 7 days.");
        }

        return $count;
    }
}
