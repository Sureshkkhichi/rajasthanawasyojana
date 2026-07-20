<?php

namespace App\Livewire\Deal;

use App\Models\Deal;
use App\Models\Inventory;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Allot Unit')]
class Allot extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public Deal $deal;

    // Filters
    public string $statusFilter = '';
    public string $facingFilter = '';
    public string $searchPlot = '';

    public function mount(Deal $deal): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );

        $this->deal = $deal->load(['project', 'allottedInventory']);

        // If unit is already allotted, redirect to deal details page
        if ($this->deal->allotted_inventory_id) {
            session()->flash('warning', 'A unit is already allotted to this customer.');
            redirect()->route('deals.show', $this->deal->id);
        }
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingFacingFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSearchPlot(): void
    {
        $this->resetPage();
    }

    public function allotInventory($unitId)
    {
        $unit = Inventory::findOrFail($unitId);

        if ($unit->status !== 'Available') {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'This unit is not available for allotment.',
                'icon' => 'error'
            ]);
            return;
        }

        // Lock unit status
        $unit->update(['status' => 'Alloted']);

        // Link unit to deal
        $this->deal->update([
            'allotted_inventory_id' => $unit->id,
            'allotted_at' => now()
        ]);

        // Create history log
        \App\Models\InventoryHistory::create([
            'inventory_id' => $unit->id,
            'from_status' => 'Available',
            'to_status' => 'Alloted',
            'changed_by' => auth()->user()->name,
            'notes' => 'Unit allotted via Deals Allotment Page to: ' . $this->deal->first_name . ' ' . $this->deal->last_name,
        ]);

        session()->flash('success', 'Unit has been successfully allotted.');
        return redirect()->route('deals.show', $this->deal->id);
    }

    public function render()
    {
        $project = $this->deal->project;
        $isFlat = ($project && $project->inventory_type === 'flat');
        $inventoryTypeLabel = $isFlat ? 'Flat' : 'Plot';

        // 1. Calculate Status Counts
        $countsQuery = Inventory::query()
            ->where('project_id', $this->deal->project_id);

        $counts = [
            'total' => (clone $countsQuery)->count(),
            'available' => (clone $countsQuery)->where('status', 'Available')->count(),
            'hold' => (clone $countsQuery)->where('status', 'Hold')->count(),
            'sold' => (clone $countsQuery)->where('status', 'Sold')->count(),
            'alloted' => (clone $countsQuery)->where('status', 'Alloted')->count(),
        ];

        // 2. Fetch Facing/Unit Type Filters
        $facingTypes = [];
        if ($isFlat) {
            $facingTypes = Inventory::query()
                ->where('project_id', $this->deal->project_id)
                ->whereNotNull('unit_type')
                ->where('unit_type', '!=', '')
                ->distinct()
                ->orderBy('unit_type')
                ->pluck('unit_type');
        }

        // 3. Query units table with pagination
        $unitsQuery = Inventory::query()
            ->where('project_id', $this->deal->project_id);

        if ($this->statusFilter) {
            $unitsQuery->where('status', $this->statusFilter);
        }

        if ($this->facingFilter) {
            if ($isFlat) {
                $unitsQuery->where('unit_type', $this->facingFilter);
            }
        }

        if ($this->searchPlot) {
            $searchCol = $isFlat ? 'flat_no' : 'plot_no';
            $unitsQuery->where($searchCol, 'like', "%{$this->searchPlot}%");
        }

        $units = $unitsQuery->orderBy($isFlat ? 'flat_no' : 'plot_no')
            ->paginate(10);

        return view('livewire.deal.allot', [
            'project' => $project,
            'isFlat' => $isFlat,
            'inventoryTypeLabel' => $inventoryTypeLabel,
            'counts' => $counts,
            'facingTypes' => $facingTypes,
            'units' => $units,
        ]);
    }
}
