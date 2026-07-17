<?php

namespace App\Livewire\Inventory;

use App\Models\Project;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Inventory')]
class Index extends Component
{
    use WithPagination, WithFileUploads;

    // Filters
    public string $selectedProjectId = '';
    public string $inventory_type = 'Plot Project';
    public string $statusFilter = '';
    public string $facingFilter = '';
    public string $searchPlot = '';
    public string $activeTab = 'all';

    // Selections
    public array $selectedInventories = [];
    public bool $selectAll = false;
    public int $perPage = 10;

    // Right Sidebar selected unit
    public ?string $selectedUnitId = null;
    public string $sidebarTab = 'general';

    // Modals & Temp States
    public bool $importModalOpen = false;
    public $importFile = null;
    public bool $priceModalOpen = false;
    public bool $statusModalOpen = false;
    public ?string $actionUnitId = null;
    public string $tempPrice = '';
    public string $tempStatus = '';
    public string $tempHoldBy = '';
    public string $tempHoldTill = '';
    public string $tempRemarks = '';

    protected $queryString = [
        'selectedProjectId' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'facingFilter' => ['except' => ''],
        'searchPlot' => ['except' => ''],
        'activeTab' => ['except' => 'all'],
    ];

    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('projects.view'),
            403
        );

        // Set default project to first active project
        $firstProject = Project::query()
            ->where('status', 'active')
            ->where('is_active', 'active')
            ->first();

        if ($firstProject) {
            $this->selectedProjectId = $firstProject->id;
            $this->updateInventoryType();
        }
    }

    public function updateInventoryType(): void
    {
        if (!$this->selectedProjectId) {
            $this->inventory_type = 'Plot Project';
            return;
        }
        $project = Project::find($this->selectedProjectId);
        if (!$project) {
            $this->inventory_type = 'Plot Project';
            return;
        }
        $typeName = $project->projectType ? $project->projectType->name : '';
        if (stripos($typeName, 'plot') !== false) {
            $this->inventory_type = 'Plot Project';
        } else {
            $this->inventory_type = 'Flat Project';
        }
    }

    public function updatedSelectedProjectId(): void
    {
        $this->resetPage();
        $this->selectedUnitId = null;
        $this->selectedInventories = [];
        $this->selectAll = false;
        $this->updateInventoryType();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
        $this->activeTab = $this->statusFilter ?: 'all';
    }

    public function updatedFacingFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSearchPlot(): void
    {
        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->statusFilter = ($tab === 'all') ? '' : $tab;
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedInventories = Inventory::query()
                ->where('project_id', $this->selectedProjectId)
                ->pluck('id')
                ->map(fn($id) => (string)$id)
                ->toArray();
        } else {
            $this->selectedInventories = [];
        }
    }

    public function selectUnit(string $id): void
    {
        $this->selectedUnitId = $id;
    }

    public function setSidebarTab(string $tab): void
    {
        $this->sidebarTab = $tab;
    }

    // Modal Actions
    public function openPriceModal(string $id): void
    {
        $unit = Inventory::find($id);
        if ($unit) {
            $this->actionUnitId = $id;
            $this->tempPrice = (string)$unit->price;
            $this->priceModalOpen = true;
        }
    }

    public function updatePrice(): void
    {
        $this->validate([
            'tempPrice' => 'required|numeric|min:0',
        ]);

        $unit = Inventory::find($this->actionUnitId);
        if ($unit) {
            $oldPrice = $unit->price;
            $unit->update([
                'price' => $this->tempPrice
            ]);

            // Log history
            InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $unit->status,
                'to_status' => $unit->status,
                'changed_by' => auth()->user()->name,
                'notes' => 'Price updated from ₹' . number_format($oldPrice, 2) . ' to ₹' . number_format($unit->price, 2),
            ]);

            $this->priceModalOpen = false;
            $this->dispatch('swal:alert', [
                'title' => 'Price Updated!',
                'text' => 'Unit price has been updated successfully.',
                'icon' => 'success'
            ]);
        }
    }

    public function openStatusModal(string $id): void
    {
        $unit = Inventory::find($id);
        if ($unit) {
            $this->actionUnitId = $id;
            $this->tempStatus = $unit->status;
            $this->tempHoldBy = $unit->hold_by ?? '';
            $this->tempHoldTill = $unit->hold_till ? $unit->hold_till->format('Y-m-d') : '';
            $this->tempRemarks = $unit->remarks ?? '';
            $this->statusModalOpen = true;
        }
    }

    public function updateStatus(): void
    {
        $this->validate([
            'tempStatus' => 'required|string',
            'tempHoldBy' => 'required_if:tempStatus,Hold',
            'tempHoldTill' => 'required_if:tempStatus,Hold',
        ]);

        $unit = Inventory::find($this->actionUnitId);
        if ($unit) {
            $oldStatus = $unit->status;
            
            $updateData = [
                'status' => $this->tempStatus,
                'remarks' => $this->tempRemarks,
            ];

            if ($this->tempStatus === 'Hold') {
                $updateData['hold_by'] = $this->tempHoldBy;
                $updateData['hold_till'] = $this->tempHoldTill;
            } elseif ($this->tempStatus === 'Available') {
                $updateData['hold_by'] = null;
                $updateData['hold_till'] = null;
                $updateData['booked_by'] = null;
                $updateData['booked_on'] = null;
            }

            $unit->update($updateData);

            // Log history
            InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $oldStatus,
                'to_status' => $this->tempStatus,
                'changed_by' => auth()->user()->name,
                'notes' => 'Status changed from ' . $oldStatus . ' to ' . $this->tempStatus . ($this->tempRemarks ? '. Remarks: ' . $this->tempRemarks : ''),
            ]);

            $this->statusModalOpen = false;
            $this->dispatch('swal:alert', [
                'title' => 'Status Changed!',
                'text' => 'Unit status has been updated successfully.',
                'icon' => 'success'
            ]);
        }
    }

    public function deleteUnit(string $id): void
    {
        $unit = Inventory::find($id);
        if ($unit) {
            $unit->delete();
            if ($this->selectedUnitId === $id) {
                $this->selectedUnitId = null;
            }
            $this->dispatch('swal:alert', [
                'title' => 'Deleted!',
                'text' => 'Unit has been deleted successfully.',
                'icon' => 'success'
            ]);
        }
    }

    // Bulk Actions
    public function bulkChangeStatus(string $status): void
    {
        if (empty($this->selectedInventories)) {
            $this->dispatch('swal:alert', [
                'title' => 'No Selection',
                'text' => 'Please select at least one unit.',
                'icon' => 'warning'
            ]);
            return;
        }

        foreach ($this->selectedInventories as $id) {
            $unit = Inventory::find($id);
            if ($unit) {
                $oldStatus = $unit->status;
                $unit->update(['status' => $status]);
                
                InventoryHistory::create([
                    'inventory_id' => $unit->id,
                    'from_status' => $oldStatus,
                    'to_status' => $status,
                    'changed_by' => auth()->user()->name,
                    'notes' => 'Bulk Status changed from ' . $oldStatus . ' to ' . $status,
                ]);
            }
        }

        $this->selectedInventories = [];
        $this->selectAll = false;
        $this->dispatch('swal:alert', [
            'title' => 'Success!',
            'text' => 'Bulk status updated successfully.',
            'icon' => 'success'
        ]);
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedInventories)) {
            $this->dispatch('swal:alert', [
                'title' => 'No Selection',
                'text' => 'Please select at least one unit.',
                'icon' => 'warning'
            ]);
            return;
        }

        Inventory::whereIn('id', $this->selectedInventories)->delete();
        $this->selectedInventories = [];
        $this->selectAll = false;
        $this->selectedUnitId = null;
        $this->dispatch('swal:alert', [
            'title' => 'Deleted!',
            'text' => 'Selected units deleted successfully.',
            'icon' => 'success'
        ]);
    }

    // Import / Export
    public function openImportModal(): void
    {
        $this->importFile = null;
        $this->importModalOpen = true;
    }

    public function importUnits(): void
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $filePath = $this->importFile->getRealPath();
        $file = fopen($filePath, 'r');
        
        // Skip header
        $header = fgetcsv($file);
        
        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 5) continue;
            
            Inventory::create([
                'project_id' => $this->selectedProjectId,
                'plot_no' => $row[0],
                'area' => (float)$row[1],
                'road_size' => $row[2],
                'plc_percentage' => (float)($row[3] ?? 0.0),
                'facing_type' => $row[4] ?? null,
                'price' => (float)$row[5],
                'status' => 'Available',
            ]);
            $count++;
        }
        fclose($file);

        $this->importModalOpen = false;
        $this->dispatch('swal:alert', [
            'title' => 'Import Completed',
            'text' => "Successfully imported {$count} units.",
            'icon' => 'success'
        ]);
    }

    public function exportUnits()
    {
        $query = Inventory::query()
            ->where('project_id', $this->selectedProjectId);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->facingFilter) {
            $query->where('facing_type', $this->facingFilter);
        }
        if ($this->searchPlot) {
            $query->where('plot_no', 'like', "%{$this->searchPlot}%");
        }

        $units = $query->orderBy('plot_no')->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=inventory-export-" . date('Ymd-His') . ".csv",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($units) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Plot No.', 'Area (Sq. Yards)', 'Road Size', 'PLC %', 'Facing Type', 'Price', 'Status']);

            foreach ($units as $unit) {
                fputcsv($file, [
                    $unit->plot_no,
                    $unit->area,
                    $unit->road_size,
                    $unit->plc_percentage,
                    $unit->facing_type,
                    $unit->price,
                    $unit->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        // Load all active projects
        $projects = Project::query()
            ->where('status', 'active')
            ->where('is_active', 'active')
            ->orderBy('name')
            ->get();

        $selectedProject = Project::find($this->selectedProjectId);

        // Counts for metric cards based on selected project
        $counts = [
            'total' => 0,
            'available' => 0,
            'hold' => 0,
            'booked' => 0,
            'registered' => 0,
            'blocked' => 0,
        ];

        if ($this->selectedProjectId) {
            $counts['total'] = Inventory::where('project_id', $this->selectedProjectId)->count();
            $counts['available'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Available')->count();
            $counts['hold'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Hold')->count();
            $counts['booked'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Booked')->count();
            $counts['registered'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Registered')->count();
            $counts['blocked'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Blocked')->count();
        }

        // Facing filters distinct
        $facingTypes = Inventory::query()
            ->where('project_id', $this->selectedProjectId)
            ->whereNotNull('facing_type')
            ->where('facing_type', '!=', '')
            ->distinct()
            ->orderBy('facing_type')
            ->pluck('facing_type');

        // Query units table
        $unitsQuery = Inventory::query()
            ->where('project_id', $this->selectedProjectId);

        if ($this->statusFilter) {
            $unitsQuery->where('status', $this->statusFilter);
        }
        if ($this->facingFilter) {
            $unitsQuery->where('facing_type', $this->facingFilter);
        }
        if ($this->searchPlot) {
            $unitsQuery->where('plot_no', 'like', "%{$this->searchPlot}%");
        }

        $units = $unitsQuery->orderBy('plot_no')
            ->paginate($this->perPage);

        // Sidebar unit load
        if ($this->selectedUnitId) {
            $selectedUnit = Inventory::find($this->selectedUnitId);
        } else {
            $selectedUnit = $units->first();
            if ($selectedUnit) {
                $this->selectedUnitId = $selectedUnit->id;
            }
        }

        return view('livewire.inventory.index', [
            'projects' => $projects,
            'selectedProject' => $selectedProject,
            'counts' => $counts,
            'facingTypes' => $facingTypes,
            'units' => $units,
            'selectedUnit' => $selectedUnit,
        ]);
    }
}
