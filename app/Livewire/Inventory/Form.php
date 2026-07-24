<?php

namespace App\Livewire\Inventory;

use App\Models\Project;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Add Unit')]
class Form extends Component
{
    public ?Inventory $inventory = null;

    // Common Fields
    public string $project_id = '';
    public string $inventory_type = 'plot'; // plot, flat
    public string $price = '';
    public float $project_rate = 0.0;
    public string $status = 'Available'; // Available, Hold, Sold, Alloted, Blocked, Cancelled
    public string $remarks = '';

    // Plot Specific Fields
    public string $plot_no = '';
    public string $area_sq_yards = '';
    public string $road_size = '';
    public string $plc_percentage = '';

    // Flat Specific Fields
    public string $floor = '';
    public string $flat_no = '';
    public string $unit_type = ''; // EWS, LIG, MIG, HIG, etc.
    public string $area_sbup = '';
    public string $carpet_area = '';
    public string $super_buildup_area = '';

    // Redirect / Filter preservation properties
    public string $selectedProjectId = '';
    public string $statusFilter = '';
    public string $facingFilter = '';
    public string $searchPlot = '';
    public string $activeTab = '';

    protected $queryString = [
        'selectedProjectId' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'facingFilter' => ['except' => ''],
        'searchPlot' => ['except' => ''],
        'activeTab' => ['except' => ''],
    ];

    public function mount(?Inventory $inventory = null): void
    {
        abort_unless(
            auth()->user()->can('projects.view'),
            403
        );

        if ($inventory && $inventory->exists) {
            $this->inventory = $inventory;
            $this->project_id = $inventory->project_id;
            $this->inventory_type = $inventory->inventory_type;
            $this->price = (string)$inventory->price;
            $this->status = $inventory->status;
            $this->remarks = $inventory->remarks ?? '';

            // Plots
            $this->plot_no = $inventory->plot_no ?? '';
            $this->area_sq_yards = $inventory->area_sq_yards ? (string)$inventory->area_sq_yards : '';
            $this->road_size = $inventory->road_size ?? '';
            $this->plc_percentage = $inventory->plc_percentage !== null ? (string)$inventory->plc_percentage : '';

            // Flats
            $this->floor = $inventory->floor ?? '';
            $this->flat_no = $inventory->flat_no ?? '';
            $this->unit_type = $inventory->unit_type ?? '';
            $this->area_sbup = $inventory->area_sbup ? (string)$inventory->area_sbup : '';
            $this->carpet_area = $inventory->carpet_area ? (string)$inventory->carpet_area : '';
            $this->super_buildup_area = $inventory->super_buildup_area ? (string)$inventory->super_buildup_area : '';

            if ($this->project_id) {
                $project = Project::find($this->project_id);
                if ($project) {
                    $this->project_rate = (float)($project->price ?: 0);
                }
            }
        } else {
            // Set default project to first active project
            $firstProj = Project::query()
                ->where('status', 'active')
                ->where('is_active', 'active')
                ->first();
            if ($firstProj) {
                $this->project_id = $firstProj->id;
                $this->inventory_type = $firstProj->inventory_type;
                $this->project_rate = (float)($firstProj->price ?: 0);
            }
        }

        $this->calculatePrice();
    }

    public function updatedProjectId($value): void
    {
        // Keep the selected project ID, but reset all other form properties to ensure a clean switch
        $this->resetExcept(['project_id', 'inventory']);

        $project = Project::find($value);
        if ($project) {
            $this->inventory_type = $project->inventory_type;
            $this->project_rate = (float)($project->price ?: 0);
        } else {
            $this->inventory_type = 'plot';
            $this->project_rate = 0.0;
        }

        $this->calculatePrice();
    }

    public function updatedAreaSqYards(): void
    {
        $this->calculatePrice();
    }

    public function updatedPlcPercentage(): void
    {
        $this->calculatePrice();
    }

    public function calculatePrice(): void
    {
        if ($this->inventory_type === 'plot' && !empty($this->project_id)) {
            $project = Project::find($this->project_id);
            if ($project) {
                $this->project_rate = (float)($project->price ?: 0);
                if (is_numeric($this->area_sq_yards) && (float)$this->area_sq_yards > 0) {
                    $basePrice = $this->project_rate * (float)$this->area_sq_yards;
                    if ($this->plc_percentage !== '' && is_numeric($this->plc_percentage) && (float)$this->plc_percentage > 0) {
                        $plcAmount = $basePrice * ((float)$this->plc_percentage / 100);
                        $this->price = (string)round($basePrice + $plcAmount, 2);
                    } else {
                        $this->price = (string)round($basePrice, 2);
                    }
                }
            }
        }
    }

    public function save()
    {
        $rules = [
            'project_id' => 'required|uuid|exists:projects,id',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:Available,Hold,Sold,Alloted,Blocked,Cancelled',
            'remarks' => 'nullable|string',
        ];

        if ($this->inventory_type === 'plot') {
            $rules['plot_no'] = 'required|string|max:255';
            $rules['area_sq_yards'] = 'required|numeric|min:0';
            $rules['road_size'] = 'required|string|max:255';
            $rules['plc_percentage'] = 'nullable|numeric|min:0|max:100';
        } else {
            $rules['floor'] = 'required|string|max:255';
            $rules['flat_no'] = 'required|string|max:255';
            $rules['unit_type'] = 'required|string|max:255';
            $rules['area_sbup'] = 'required|numeric|min:0';
            $rules['carpet_area'] = 'required|numeric|min:0';
            $rules['super_buildup_area'] = 'required|numeric|min:0';
        }

        $validated = $this->validate($rules);

        $data = [
            'project_id' => $this->project_id,
            'inventory_type' => $this->inventory_type,
            'price' => $this->price,
            'status' => $this->status,
            'remarks' => $this->remarks ?: null,
        ];

        if ($this->inventory_type === 'plot') {
            $data['plot_no'] = $this->plot_no;
            $data['area_sq_yards'] = $this->area_sq_yards;
            $data['road_size'] = $this->road_size;
            $data['plc_percentage'] = $this->plc_percentage !== '' ? $this->plc_percentage : null;

            // Clear flat fields
            $data['floor'] = null;
            $data['flat_no'] = null;
            $data['unit_type'] = null;
            $data['area_sbup'] = null;
            $data['carpet_area'] = null;
            $data['super_buildup_area'] = null;
        } else {
            $data['floor'] = $this->floor;
            $data['flat_no'] = $this->flat_no;
            $data['unit_type'] = $this->unit_type;
            $data['area_sbup'] = $this->area_sbup;
            $data['carpet_area'] = $this->carpet_area;
            $data['super_buildup_area'] = $this->super_buildup_area;

            // Clear plot fields
            $data['plot_no'] = null;
            $data['area_sq_yards'] = null;
            $data['road_size'] = null;
            $data['plc_percentage'] = null;
        }

        if ($this->inventory && $this->inventory->exists) {
            $oldStatus = $this->inventory->status;
            $this->inventory->update($data);
            
            if ($oldStatus !== $this->status) {
                InventoryHistory::create([
                    'inventory_id' => $this->inventory->id,
                    'from_status' => $oldStatus,
                    'to_status' => $this->status,
                    'changed_by' => auth()->user()->name,
                    'notes' => 'Status changed during unit edit.',
                ]);
            }
            
            session()->flash('success', 'Unit updated successfully.');
        } else {
            $newUnit = Inventory::create($data);
            
            InventoryHistory::create([
                'inventory_id' => $newUnit->id,
                'from_status' => 'Available',
                'to_status' => $this->status,
                'changed_by' => auth()->user()->name,
                'notes' => 'Initial status on creation.',
            ]);

            session()->flash('success', 'Unit created successfully.');
        }

        $redirectParams = array_filter([
            'selectedProjectId' => $this->selectedProjectId ?: ($this->project_id ?: null),
            'statusFilter' => $this->statusFilter ?: null,
            'facingFilter' => $this->facingFilter ?: null,
            'searchPlot' => $this->searchPlot ?: null,
            'activeTab' => $this->activeTab ?: null,
        ]);

        return redirect()->route('inventories.index', $redirectParams);
    }

    public function render()
    {
        $projects = Project::query()
            ->where('status', 'active')
            ->where('is_active', 'active')
            ->orderBy('name')
            ->get();

        return view('livewire.inventory.form', [
            'projects' => $projects,
        ]);
    }
}
