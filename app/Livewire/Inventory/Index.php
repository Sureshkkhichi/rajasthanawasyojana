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
    public string $tempRemarks = '';

    // Sold Allotment Popup Modals & Properties
    public bool $soldModalOpen = false;
    public ?string $soldUnitId = null;
    public ?string $selectedDealId = null;
    public array $selectedDealDetails = [];
    public bool $createNewDealMode = false;
    public array $newDealForm = [
        'first_name' => '',
        'last_name' => '',
        'phone' => '',
        'email' => '',
        'booking_amount' => 21100,
        'total_amount' => '',
    ];
    public $unallottedDeals = [];

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
        $this->inventory_type = $project->inventory_type === 'flat' ? 'Flat Project' : 'Plot Project';
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
            $this->tempRemarks = $unit->remarks ?? '';
            $this->statusModalOpen = true;
        }
    }

    public function updateStatus(): void
    {
        $this->validate([
            'tempStatus' => 'required|string',
            'tempRemarks' => 'nullable|string',
        ]);

        $unit = Inventory::find($this->actionUnitId);
        if ($unit) {
            $oldStatus = $unit->status;
            
            $unit->update([
                'status' => $this->tempStatus,
                'remarks' => $this->tempRemarks ?: null,
            ]);

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

    public function changeSingleStatusDirectly(string $id, string $newStatus): void
    {
        $unit = Inventory::find($id);
        if ($unit) {
            $oldStatus = $unit->status;
            
            $unit->update([
                'status' => $newStatus,
            ]);

            // Log history
            InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'changed_by' => auth()->user()->name,
                'notes' => 'Status changed directly to ' . $newStatus,
            ]);

            $this->dispatch('swal:alert', [
                'title' => 'Status Changed!',
                'text' => 'Unit status updated to ' . $newStatus . ' successfully.',
                'icon' => 'success'
            ]);
        }
    }

    public function openSoldModal(string $unitId): void
    {
        $unit = Inventory::find($unitId);
        if ($unit) {
            $this->soldUnitId = $unitId;
            $this->selectedDealId = null;
            $this->selectedDealDetails = [];
            $this->createNewDealMode = false;
            $this->newDealForm = [
                'first_name' => '',
                'last_name' => '',
                'phone' => '',
                'email' => '',
                'booking_amount' => 21100,
                'total_amount' => $unit->price,
            ];
            
            $this->unallottedDeals = \App\Models\Deal::where('project_id', $unit->project_id)
                ->whereNull('allotted_inventory_id')
                ->get();

            $this->soldModalOpen = true;
        }
    }

    public function updatedSelectedDealId($value): void
    {
        if ($value) {
            $deal = \App\Models\Deal::find($value);
            if ($deal) {
                $this->selectedDealDetails = [
                    'name' => $deal->first_name . ' ' . $deal->last_name,
                    'phone' => $deal->phone,
                    'email' => $deal->email,
                    'booking_amount' => $deal->booking_amount,
                    'total_amount' => $deal->total_amount,
                ];
            }
        } else {
            $this->selectedDealDetails = [];
        }
    }

    public function submitSoldAllotment(): void
    {
        $unit = Inventory::find($this->soldUnitId);
        if (!$unit) {
            $this->soldModalOpen = false;
            return;
        }

        if ($this->createNewDealMode) {
            $this->validate([
                'newDealForm.first_name' => 'required|string|max:255',
                'newDealForm.last_name' => 'nullable|string|max:255',
                'newDealForm.phone' => 'required|string|max:20',
                'newDealForm.email' => 'nullable|email|max:255',
                'newDealForm.booking_amount' => 'required|numeric|min:0',
                'newDealForm.total_amount' => 'required|numeric|min:0',
            ]);

            $deal = \App\Models\Deal::create([
                'project_id' => $unit->project_id,
                'first_name' => $this->newDealForm['first_name'],
                'last_name' => $this->newDealForm['last_name'] ?: '',
                'phone' => $this->newDealForm['phone'],
                'email' => $this->newDealForm['email'] ?: '',
                'booking_amount' => $this->newDealForm['booking_amount'],
                'total_amount' => $this->newDealForm['total_amount'],
                'booking_date' => now(),
                'status' => 'Paid',
                'allotted_inventory_id' => $unit->id,
            ]);

            $oldStatus = $unit->status;
            $unit->update(['status' => 'Alloted']);

            InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $oldStatus,
                'to_status' => 'Alloted',
                'changed_by' => auth()->user()->name,
                'notes' => 'Unit allotted via new Deal creation: ' . $deal->first_name . ' ' . $deal->last_name,
            ]);
        } else {
            $this->validate([
                'selectedDealId' => 'required|exists:deals,id',
            ]);

            $deal = \App\Models\Deal::find($this->selectedDealId);
            if ($deal) {
                $deal->update(['allotted_inventory_id' => $unit->id]);

                $oldStatus = $unit->status;
                $unit->update(['status' => 'Alloted']);

                InventoryHistory::create([
                    'inventory_id' => $unit->id,
                    'from_status' => $oldStatus,
                    'to_status' => 'Alloted',
                    'changed_by' => auth()->user()->name,
                    'notes' => 'Unit allotted to existing Deal: ' . $deal->first_name . ' ' . $deal->last_name,
                ]);
            }
        }

        $this->soldModalOpen = false;

        $this->dispatch('swal:alert', [
            'title' => 'Allotment Successful!',
            'text' => 'Unit has been successfully allotted and marked as Alloted.',
            'icon' => 'success'
        ]);
    }

    public function vacateUnit(string $id): void
    {
        $unit = Inventory::find($id);
        if ($unit) {
            $oldStatus = $unit->status;

            // Reset status to Available
            $unit->update([
                'status' => 'Available',
                'remarks' => null,
            ]);

            // Clear active allotments
            \App\Models\Deal::where('allotted_inventory_id', $unit->id)
                ->update(['allotted_inventory_id' => null]);

            // Log history
            InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $oldStatus,
                'to_status' => 'Available',
                'changed_by' => auth()->user()->name,
                'notes' => 'Unit vacated and reset to Available.',
            ]);

            $this->dispatch('swal:alert', [
                'title' => 'Unit Vacated!',
                'text' => 'Unit has been successfully vacated and is now Available.',
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

        $project = Project::findOrFail($this->selectedProjectId);
        $inventoryType = $project->inventory_type;

        $filePath = $this->importFile->getRealPath();
        $file = fopen($filePath, 'r');
        
        // Skip header
        $header = fgetcsv($file);
        
        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 5) continue;
            
            if ($inventoryType === 'flat') {
                // Flat columns: 0: Sr. No., 1: Floor, 2: Flat No., 3: Type, 4: Unit Type, 5: Area (SBUP), 6: Carpet Area
                $floor = $row[1] ?? '';
                $flatNo = $row[2] ?? '';
                $flatType = $row[3] ?? '';
                $unitType = $row[4] ?? '';
                $areaSbup = (float)($row[5] ?? 0.0);
                $carpetArea = (float)($row[6] ?? 0.0);
                
                Inventory::create([
                    'project_id' => $project->id,
                    'inventory_type' => 'flat',
                    'floor' => $floor,
                    'flat_no' => $flatNo,
                    'flat_type' => $flatType,
                    'unit_type' => $unitType,
                    'area_sbup' => $areaSbup,
                    'carpet_area' => $carpetArea,
                    'price' => 0.0, // Default price
                    'status' => 'Available',
                ]);
            } else {
                // Plot columns: 0: Sr. No., 1: Plot No., 2: Area (Sq. Yards), 3: Road Size, 4: PLC %, 5: PLC Status, 6: Sold
                $plotNo = $row[1] ?? '';
                $areaSqYards = (float)($row[2] ?? 0.0);
                $roadSize = $row[3] ?? '';
                $plcPercentage = (float)($row[4] ?? 0.0);
                $plcStatus = $row[5] ?? '';
                $soldStatus = $row[6] ?? 'Available';
                
                // Map 'Sold' status
                $status = (stripos($soldStatus, 'sold') !== false) ? 'Sold' : 'Available';

                Inventory::create([
                    'project_id' => $project->id,
                    'inventory_type' => 'plot',
                    'plot_no' => $plotNo,
                    'area_sq_yards' => $areaSqYards,
                    'road_size' => $roadSize,
                    'plc_percentage' => $plcPercentage,
                    'plc_status' => $plcStatus,
                    'price' => 0.0, // Default price
                    'status' => $status,
                ]);
            }
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
        $project = Project::findOrFail($this->selectedProjectId);
        $inventoryType = $project->inventory_type;

        $query = Inventory::query()
            ->where('project_id', $this->selectedProjectId);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }
        if ($this->facingFilter) {
            $filterCol = ($inventoryType === 'flat') ? 'unit_type' : 'plc_status';
            $query->where($filterCol, $this->facingFilter);
        }
        if ($this->searchPlot) {
            $searchCol = ($inventoryType === 'flat') ? 'flat_no' : 'plot_no';
            $query->where($searchCol, 'like', "%{$this->searchPlot}%");
        }

        $units = $query->orderBy($inventoryType === 'flat' ? 'flat_no' : 'plot_no')->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=inventory-export-" . date('Ymd-His') . ".csv",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($units, $inventoryType) {
            $file = fopen('php://output', 'w');
            
            if ($inventoryType === 'flat') {
                fputcsv($file, ['Floor', 'Flat No.', 'Type', 'Unit Type', 'Area (SBUP)', 'Carpet Area', 'Price', 'Status']);
                foreach ($units as $unit) {
                    fputcsv($file, [
                        $unit->floor,
                        $unit->flat_no,
                        $unit->flat_type,
                        $unit->unit_type,
                        $unit->area_sbup,
                        $unit->carpet_area,
                        $unit->price,
                        $unit->status
                    ]);
                }
            } else {
                fputcsv($file, ['Plot No.', 'Area (Sq. Yards)', 'Road Size', 'PLC %', 'PLC Status / Location', 'Price', 'Status']);
                foreach ($units as $unit) {
                    fputcsv($file, [
                        $unit->plot_no,
                        $unit->area_sq_yards,
                        $unit->road_size,
                        $unit->plc_percentage,
                        $unit->plc_status,
                        $unit->price,
                        $unit->status
                    ]);
                }
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
            'sold' => 0,
            'alloted' => 0,
            'blocked' => 0,
        ];

        if ($this->selectedProjectId) {
            $counts['total'] = Inventory::where('project_id', $this->selectedProjectId)->count();
            $counts['available'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Available')->count();
            $counts['hold'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Hold')->count();
            $counts['sold'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Sold')->count();
            $counts['alloted'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Alloted')->count();
            $counts['blocked'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Blocked')->count();
        }

        // Facing/PLC/Unit Type filters distinct
        $facingTypes = [];
        if ($selectedProject) {
            $isFlat = ($selectedProject->inventory_type === 'flat');
            $filterCol = $isFlat ? 'unit_type' : 'plc_status';
            $facingTypes = Inventory::query()
                ->where('project_id', $this->selectedProjectId)
                ->whereNotNull($filterCol)
                ->where($filterCol, '!=', '')
                ->distinct()
                ->orderBy($filterCol)
                ->pluck($filterCol);
        }

        // Query units table
        $unitsQuery = Inventory::query()
            ->where('project_id', $this->selectedProjectId);

        if ($this->statusFilter) {
            $unitsQuery->where('status', $this->statusFilter);
        }
        if ($this->facingFilter) {
            $filterCol = ($selectedProject && $selectedProject->inventory_type === 'flat') ? 'unit_type' : 'plc_status';
            $unitsQuery->where($filterCol, $this->facingFilter);
        }
        if ($this->searchPlot) {
            $searchCol = ($selectedProject && $selectedProject->inventory_type === 'flat') ? 'flat_no' : 'plot_no';
            $unitsQuery->where($searchCol, 'like', "%{$this->searchPlot}%");
        }

        $orderByCol = ($selectedProject && $selectedProject->inventory_type === 'flat') ? 'flat_no' : 'plot_no';
        $units = $unitsQuery->orderBy($orderByCol)
            ->paginate($this->perPage);

        return view('livewire.inventory.index', [
            'projects' => $projects,
            'selectedProject' => $selectedProject,
            'counts' => $counts,
            'facingTypes' => $facingTypes,
            'units' => $units,
        ]);
    }
}
