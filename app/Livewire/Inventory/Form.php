<?php

namespace App\Livewire\Inventory;

use App\Models\Project;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
#[Title('Add Unit')]
class Form extends Component
{
    use WithFileUploads;

    public ?Inventory $inventory = null;

    // Fields
    public string $project_id = '';
    public string $plot_no = '';
    public string $area = '';
    public string $road_size = '';
    public string $plc_percentage = '0';
    public string $facing_type = '';
    public string $length = '';
    public string $breadth = '';
    public string $shape = '';
    public string $remarks = '';
    public string $price = '';
    public string $price_in_words = '';
    public string $cost_price = '';
    public string $status = 'Available';
    public string $status_effective_from = '';
    public string $notes = '';

    // File Uploads
    public $uploaded_documents = [];
    public $uploaded_map_layout = null;

    // Existing file paths
    public array $existing_documents = [];
    public ?string $existing_map_layout = null;

    public function mount(?Inventory $inventory = null): void
    {
        abort_unless(
            auth()->user()->can('projects.view'),
            403
        );

        $this->status_effective_from = date('Y-m-d');

        if ($inventory && $inventory->exists) {
            $this->inventory = $inventory;
            $this->project_id = $inventory->project_id;
            $this->plot_no = $inventory->plot_no;
            $this->area = (string)$inventory->area;
            $this->road_size = $inventory->road_size;
            $this->plc_percentage = (string)$inventory->plc_percentage;
            $this->facing_type = $inventory->facing_type ?? '';
            $this->length = $inventory->length ? (string)$inventory->length : '';
            $this->breadth = $inventory->breadth ? (string)$inventory->breadth : '';
            $this->shape = $inventory->shape ?? '';
            $this->remarks = $inventory->remarks ?? '';
            $this->price = (string)$inventory->price;
            $this->price_in_words = $inventory->price_in_words ?? '';
            $this->cost_price = $inventory->cost_price ? (string)$inventory->cost_price : '';
            $this->status = $inventory->status;
            $this->status_effective_from = $inventory->status_effective_from ? $inventory->status_effective_from->format('Y-m-d') : date('Y-m-d');
            $this->notes = $inventory->notes ?? '';
            $this->existing_documents = $inventory->documents ?? [];
            $this->existing_map_layout = $inventory->map_layout;
        } else {
            // Set default project to first active
            $firstProj = Project::query()
                ->where('status', 'active')
                ->where('is_active', 'active')
                ->first();
            if ($firstProj) {
                $this->project_id = $firstProj->id;
            }
        }
    }

    public function getInventoryTypeProperty(): string
    {
        $project = Project::find($this->project_id);
        if (!$project) return 'Plot Project';
        $typeName = $project->projectType ? $project->projectType->name : '';
        if (stripos($typeName, 'plot') !== false) {
            return 'Plot Project';
        }
        return 'Flat Project';
    }

    public function save()
    {
        $this->validate([
            'project_id' => 'required|uuid|exists:projects,id',
            'plot_no' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'road_size' => 'required|string|max:255',
            'plc_percentage' => 'nullable|numeric|min:0|max:100',
            'facing_type' => 'nullable|string|max:255',
            'length' => 'nullable|numeric|min:0',
            'breadth' => 'nullable|numeric|min:0',
            'shape' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_in_words' => 'nullable|string|max:255',
            'cost_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:Available,Hold,Booked,Registered,Blocked,Cancelled',
            'status_effective_from' => 'nullable|date',
            'notes' => 'nullable|string',
            'uploaded_documents.*' => 'nullable|file|max:5120',
            'uploaded_map_layout' => 'nullable|image|max:5120',
        ]);

        $data = [
            'project_id' => $this->project_id,
            'plot_no' => $this->plot_no,
            'area' => $this->area,
            'road_size' => $this->road_size,
            'plc_percentage' => $this->plc_percentage ?: 0.0,
            'facing_type' => $this->facing_type ?: null,
            'length' => $this->length ?: null,
            'breadth' => $this->breadth ?: null,
            'shape' => $this->shape ?: null,
            'remarks' => $this->remarks ?: null,
            'price' => $this->price,
            'price_in_words' => $this->price_in_words ?: null,
            'cost_price' => $this->cost_price ?: null,
            'status' => $this->status,
            'status_effective_from' => $this->status_effective_from ?: null,
            'notes' => $this->notes ?: null,
        ];

        // Process Map Layout
        if ($this->uploaded_map_layout) {
            $path = $this->uploaded_map_layout->store('inventories/maps', 'public');
            @chmod(storage_path('app/public/' . $path), 0644);
            $data['map_layout'] = 'storage/' . $path;
        }

        // Process Documents
        $docPaths = $this->existing_documents;
        if (!empty($this->uploaded_documents)) {
            foreach ($this->uploaded_documents as $doc) {
                $path = $doc->store('inventories/docs', 'public');
                @chmod(storage_path('app/public/' . $path), 0644);
                $docPaths[] = [
                    'name' => $doc->getClientOriginalName(),
                    'path' => 'storage/' . $path
                ];
            }
        }
        $data['documents'] = $docPaths;

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

    public function deleteDocument(int $index): void
    {
        if (isset($this->existing_documents[$index])) {
            unset($this->existing_documents[$index]);
            $this->existing_documents = array_values($this->existing_documents);
        }
    }

    public function deleteMapLayout(): void
    {
        $this->existing_map_layout = null;
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
