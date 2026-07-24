<?php

namespace App\Livewire\Inventory;

use App\Models\Project;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\State;
use App\Models\City;
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
        'father_husband_name' => '',
        'pan_number' => '',
        'gender' => '',
        'email' => '',
        'phone' => '',
        'date_of_birth' => '',
        'occupation' => '',
        'address' => '',
        'state_id' => '',
        'city_id' => '',
        'co_applicant_name' => '',
        'flat_size' => '',
        'waiver_code' => '',
        'booking_amount' => 21100,
        'total_amount' => '',
    ];
    public $unallottedDeals = [];
    public $states = [];
    public $cities = [];

    // View Inventory Details Modal
    public bool $viewModalOpen = false;
    public ?Inventory $viewUnitModel = null;

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

        if ($this->statusFilter && $this->activeTab === 'all') {
            $this->activeTab = $this->statusFilter;
        }

        $this->updateInventoryType();
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

    public function updated($property, $value): void
    {
        if ($property === 'newDealForm.state_id') {
            if ($value) {
                $this->cities = City::query()
                    ->where('state_id', $value)
                    ->orderBy('name')
                    ->get();
            } else {
                $this->cities = [];
            }
            $this->newDealForm['city_id'] = '';
        }
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

    public function resetFilters(): void
    {
        $this->reset([
            'selectedProjectId',
            'statusFilter',
            'facingFilter',
            'searchPlot',
            'activeTab',
        ]);

        $this->updateInventoryType();
        $this->resetPage();
    }

    public function openViewModal(string $unitId): void
    {
        $unit = Inventory::with(['project', 'deal'])->find($unitId);
        if ($unit) {
            $this->viewUnitModel = $unit;
            $this->viewModalOpen = true;
        }
    }

    public function closeViewModal(): void
    {
        $this->viewModalOpen = false;
        $this->viewUnitModel = null;
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

            $flatSize = $unit->inventory_type === 'flat' ? $unit->unit_type : $unit->area_sq_yards;

            $this->newDealForm = [
                'first_name' => '',
                'last_name' => '',
                'father_husband_name' => '',
                'pan_number' => '',
                'gender' => '',
                'email' => '',
                'phone' => '',
                'date_of_birth' => '',
                'occupation' => '',
                'address' => '',
                'state_id' => '',
                'city_id' => '',
                'co_applicant_name' => '',
                'flat_size' => $flatSize,
                'waiver_code' => '',
                'booking_amount' => (float) \App\Models\FrontendSetting::getVal('booking_amount', 21100),
                'total_amount' => $unit->price,
            ];

            $this->states = State::query()
                ->where('country_id', 101)
                ->orderBy('name')
                ->get();

            $rajasthan = State::query()
                ->where('name', 'Rajasthan')
                ->first();

            if ($rajasthan) {
                $this->newDealForm['state_id'] = $rajasthan->id;
                $this->cities = City::query()
                    ->where('state_id', $rajasthan->id)
                    ->orderBy('name')
                    ->get();
            } else {
                $this->cities = [];
            }
            
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
                'newDealForm.last_name' => 'required|string|max:255',
                'newDealForm.father_husband_name' => 'nullable|string|max:255',
                'newDealForm.pan_number' => ['required', 'string', 'max:10'],
                'newDealForm.gender' => 'required',
                'newDealForm.email' => 'required|email|max:255',
                'newDealForm.phone' => ['required', 'string', 'regex:/^[6-9][0-9]{9}$/'],
                'newDealForm.date_of_birth' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                'newDealForm.occupation' => 'required',
                'newDealForm.address' => 'required|string',
                'newDealForm.state_id' => 'required',
                'newDealForm.city_id' => 'required',
                'newDealForm.co_applicant_name' => 'nullable|string|max:255',
                'newDealForm.flat_size' => 'required|string',
                'newDealForm.waiver_code' => ['nullable', 'numeric', 'digits:8'],
                'newDealForm.booking_amount' => 'required|numeric|min:0',
                'newDealForm.total_amount' => 'required|numeric|min:0',
            ], [
                'newDealForm.date_of_birth.before_or_equal' => 'Age must be 18 years or older.',
                'newDealForm.phone.regex' => 'Phone must be a valid 10-digit mobile number.',
                'newDealForm.waiver_code.numeric' => 'Waiver Code must contain only numbers.',
                'newDealForm.waiver_code.digits' => 'Waiver Code must be exactly 8 digits.',
            ]);

            $state = State::find($this->newDealForm['state_id']);
            $cityModel = City::find($this->newDealForm['city_id']);

            $deal = \App\Models\Deal::create([
                'project_id' => $unit->project_id,
                'first_name' => ucwords(strtolower(trim($this->newDealForm['first_name']))),
                'last_name' => ucwords(strtolower(trim($this->newDealForm['last_name']))),
                'father_husband_name' => $this->newDealForm['father_husband_name'] ? ucwords(strtolower(trim($this->newDealForm['father_husband_name']))) : null,
                'pan_number' => strtoupper(trim($this->newDealForm['pan_number'])),
                'gender' => $this->newDealForm['gender'],
                'email' => strtolower(trim($this->newDealForm['email'])),
                'phone' => trim($this->newDealForm['phone']),
                'date_of_birth' => $this->newDealForm['date_of_birth'],
                'occupation' => $this->newDealForm['occupation'],
                'address' => ucwords(strtolower(trim($this->newDealForm['address']))),
                'state_id' => $this->newDealForm['state_id'],
                'state_name' => $state ? $state->name : null,
                'city_id' => $this->newDealForm['city_id'],
                'city' => $cityModel ? $cityModel->name : '',
                'co_applicant_name' => $this->newDealForm['co_applicant_name'] ? ucwords(strtolower(trim($this->newDealForm['co_applicant_name']))) : null,
                'flat_size' => $this->newDealForm['flat_size'],
                'waiver_code' => $this->newDealForm['waiver_code'] ?: null,
                'booking_amount' => $this->newDealForm['booking_amount'],
                'total_amount' => $this->newDealForm['total_amount'],
                'booking_date' => now(),
                'status' => 'Paid',
                'allotted_inventory_id' => $unit->id,
            ]);

            $oldStatus = $unit->status;
            $unit->update(['status' => 'Sold']);

            InventoryHistory::create([
                'inventory_id' => $unit->id,
                'from_status' => $oldStatus,
                'to_status' => 'Sold',
                'changed_by' => auth()->user()->name,
                'notes' => 'Unit sold via new Deal creation: ' . $deal->first_name . ' ' . $deal->last_name,
            ]);
        } else {
            $this->validate([
                'selectedDealId' => 'required|exists:deals,id',
            ]);

            $deal = \App\Models\Deal::find($this->selectedDealId);
            if ($deal) {
                $deal->update(['allotted_inventory_id' => $unit->id]);

                $oldStatus = $unit->status;
                $unit->update(['status' => 'Sold']);

                InventoryHistory::create([
                    'inventory_id' => $unit->id,
                    'from_status' => $oldStatus,
                    'to_status' => 'Sold',
                    'changed_by' => auth()->user()->name,
                    'notes' => 'Unit sold and allotted to existing Deal: ' . $deal->first_name . ' ' . $deal->last_name,
                ]);
            }
        }

        $this->soldModalOpen = false;

        $this->dispatch('swal:alert', [
            'title' => 'Marked Sold!',
            'text' => 'Unit has been successfully marked as Sold.',
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
                // Flat columns: 0: Sr. No., 1: Floor, 2: Flat No., 3: Unit Type, 4: Area (SBUP), 5: Carpet Area, 6: Super Buildup Area
                $floor = $row[1] ?? '';
                $flatNo = $row[2] ?? '';
                $unitType = $row[3] ?? '';
                $areaSbup = (float)($row[4] ?? 0.0);
                $carpetArea = (float)($row[5] ?? 0.0);
                $superBuildupArea = (float)($row[6] ?? 0.0);
                
                Inventory::create([
                    'project_id' => $project->id,
                    'inventory_type' => 'flat',
                    'floor' => $floor,
                    'flat_no' => $flatNo,
                    'unit_type' => $unitType,
                    'area_sbup' => $areaSbup,
                    'carpet_area' => $carpetArea,
                    'super_buildup_area' => $superBuildupArea,
                    'price' => 0.0, // Default price
                    'status' => 'Available',
                ]);
            } else {
                // Plot columns: 0: Sr. No., 1: Plot No., 2: Area (Sq. Yards), 3: Road Size, 4: PLC %, 5: Sold
                $plotNo = $row[1] ?? '';
                $areaSqYards = (float)($row[2] ?? 0.0);
                $roadSize = $row[3] ?? '';
                $plcPercentage = (float)($row[4] ?? 0.0);
                $soldStatus = $row[5] ?? 'Available';
                
                // Map 'Sold' status
                $status = (stripos($soldStatus, 'sold') !== false) ? 'Sold' : 'Available';

                Inventory::create([
                    'project_id' => $project->id,
                    'inventory_type' => 'plot',
                    'plot_no' => $plotNo,
                    'area_sq_yards' => $areaSqYards,
                    'road_size' => $roadSize,
                    'plc_percentage' => $plcPercentage,
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
            if ($this->statusFilter === 'Sold') {
                $query->whereIn('status', ['Sold', 'Alloted']);
            } else {
                $query->where('status', $this->statusFilter);
            }
        }
        if ($this->facingFilter) {
            if ($inventoryType === 'flat') {
                $query->where('unit_type', $this->facingFilter);
            }
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
                fputcsv($file, ['Floor', 'Flat No.', 'Unit Type', 'Area (SBUP)', 'Carpet Area', 'Super Buildup Area', 'Price', 'Status']);
                foreach ($units as $unit) {
                    fputcsv($file, [
                        $unit->floor,
                        $unit->flat_no,
                        $unit->unit_type,
                        $unit->area_sbup,
                        $unit->carpet_area,
                        $unit->super_buildup_area,
                        $unit->price,
                        $unit->status
                    ]);
                }
            } else {
                fputcsv($file, ['Plot No.', 'Area (Sq. Yards)', 'Road Size', 'PLC %', 'Price', 'Status']);
                foreach ($units as $unit) {
                    fputcsv($file, [
                        $unit->plot_no,
                        $unit->area_sq_yards,
                        $unit->road_size,
                        $unit->plc_percentage,
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
            'blocked' => 0,
        ];

        if ($this->selectedProjectId) {
            $counts['total'] = Inventory::where('project_id', $this->selectedProjectId)->count();
            $counts['available'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Available')->count();
            $counts['hold'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Hold')->count();
            $counts['sold'] = Inventory::where('project_id', $this->selectedProjectId)->whereIn('status', ['Sold', 'Alloted'])->count();
            $counts['blocked'] = Inventory::where('project_id', $this->selectedProjectId)->where('status', 'Blocked')->count();
        }

        // Facing/PLC/Unit Type filters distinct
        $facingTypes = [];
        if ($selectedProject) {
            $isFlat = ($selectedProject->inventory_type === 'flat');
            if ($isFlat) {
                $facingTypes = Inventory::query()
                    ->where('project_id', $this->selectedProjectId)
                    ->whereNotNull('unit_type')
                    ->where('unit_type', '!=', '')
                    ->distinct()
                    ->orderBy('unit_type')
                    ->pluck('unit_type');
            }
        }

        // Query units table
        $unitsQuery = Inventory::query()
            ->with('deal')
            ->where('project_id', $this->selectedProjectId);

        if ($this->statusFilter) {
            if ($this->statusFilter === 'Sold') {
                $unitsQuery->whereIn('status', ['Sold', 'Alloted']);
            } else {
                $unitsQuery->where('status', $this->statusFilter);
            }
        }
        if ($this->facingFilter) {
            if ($selectedProject && $selectedProject->inventory_type === 'flat') {
                $unitsQuery->where('unit_type', $this->facingFilter);
            }
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
