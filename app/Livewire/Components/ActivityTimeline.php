<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\ActivityLog;

class ActivityTimeline extends Component
{
    public $leadId = null;
    public $dealId = null;
    public $inventoryId = null;
    public $logType = null;
    public $limit = 20;

    protected $listeners = ['activityLogged' => '$refresh', 'refreshTimeline' => '$refresh'];

    public function render()
    {
        $query = ActivityLog::with(['user', 'deal', 'inventory', 'lead'])->recent();

        if ($this->leadId) {
            $query->where('lead_id', $this->leadId);
        } elseif ($this->dealId) {
            $query->where('deal_id', $this->dealId);
        } elseif ($this->inventoryId) {
            $query->where('inventory_id', $this->inventoryId);
        } elseif ($this->logType) {
            $query->where('log_type', $this->logType);
        }

        $activities = $query->take($this->limit)->get();

        return view('livewire.components.activity-timeline', [
            'activities' => $activities,
        ]);
    }
}
