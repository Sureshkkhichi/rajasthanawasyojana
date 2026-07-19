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
    public string $status = 'Available'; // Available, Hold, Sold, Alloted, Blocked, Cancelled
    public string $remarks = '';

    // Plot Specific Fields
    public string $plot_no = '';
    public string $area_sq_yards = '';
    public string $road_size = '';
    public string $plc_percentage = '';
    public string $plc_status = ''; // e.g. Corner

    // Flat Specific Fields
    public string $floor = '';
    public string $flat_no = '';
    public string $unit_type = ''; // EWS, LIG, MIG, HIG, etc.
    public string $area_sbup = '';
    public string $carpet_area = '';
    public string $super_buildup_area = '';

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
            $this->plc_status = $inventory->plc_status ?? '';

            // Flats
            $this->floor = $inventory->floor ?? '';
            $this->flat_no = $inventory->flat_no ?? '';
            $this->unit_type = $inventory->unit_type ?? '';
            $this->area_sbup = $inventory->area_sbup ? (string)$inventory->area_sbup : '';
            $this->carpet_area = $inventory->carpet_area ? (string)$inventory->carpet_area : '';
            $this->super_buildup_area = $inventory->super_buildup_area ? (string)$inventory->super_buildup_area : '';
        } else {
            // Set default project to first active project
            $firstProj = Project::query()
                ->where('status', 'active')
                ->where('is_active', 'active')
                ->first();
            if ($firstProj) {
                $this->project_id = $firstProj->id;
                $this->inventory_type = $firstProj->inventory_type;
            }
        }
    }

    public function updatedProjectId($value): void
    {
        // Keep the selected project ID, but reset all other form properties to ensure a clean switch
        $this->resetExcept(['project_id', 'inventory']);

        $project = Project::find($value);
        if ($project) {
            $this->inventory_type = $project->inventory_type;
        } else {
            $this->inventory_type = 'plot';
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
            $rules['plc_status'] = 'nullable|string|max:255';
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
            $data['plc_status'] = $this->plc_status ?: null;

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
            $data['plc_status'] = null;
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

        return redirect()->route('inventories.index');
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
