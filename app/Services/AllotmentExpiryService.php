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
                $q->where('allotted_at', '<=', now()->subMinutes(5))
                  ->orWhere(function ($sub) {
                      $sub->whereNull('allotted_at')
                          ->where('updated_at', '<=', now()->subMinutes(5));
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
                    'notes' => 'Unit allotment automatically cancelled after 5 minutes without being marked Sold.',
                ]);

                ActivityLogger::logInventory(
                    $unit,
                    'allotment_expired',
                    'Allotment Expired',
                    "Allotment for unit {$unit->unit_name} automatically cancelled after 5 minutes without being marked Sold."
                );
            }

            ActivityLogger::logDeal(
                $deal,
                'allotment_expired',
                'Allotment Expired',
                "Unit allotment for {$deal->first_name} {$deal->last_name} automatically cancelled after 5 minutes without being marked Sold."
            );

            $deal->update([
                'status' => 'Not Alloted',
                'deal_status' => 'Not Alloted',
                'allotted_inventory_id' => null,
                'allotted_at' => null,
            ]);

            $count++;
        }

        if ($count > 0) {
            Log::info("AllotmentExpiryService: Expired {$count} unit allotment(s) older than 5 minutes.");
        }

        return $count;
    }
}
