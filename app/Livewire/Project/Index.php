<?php
namespace App\Livewire\Project;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('layouts.app')]
#[Title('Projects')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public string $keyword = '';
    public string $status = '';
    public string $is_active = '';
    public function mount()
    {
        abort_unless(auth()->user()->can('projects.view'), 403);
    }
    public function updatingKeyword(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    public function updatingIsActive(): void
    {
        $this->resetPage();
    }
    public function delete(string $id): void
    {
        abort_unless(
            auth()->user()->can('projects.delete'),
            403
        );
        $project = Project::findOrFail($id);

        if ($project->leads()->exists()) {
            session()->flash(
                'error',
                'Cannot delete project because it has associated leads.'
            );
            return;
        }

        $project->forceDelete();
        session()->flash(
            'success',
            'Project force deleted successfully.'
        );
        $this->resetPage();
    }
    public function toggleStatus(string $id): void
    {
        abort_unless(
            auth()->user()->can('projects.edit'),
            403
        );
        $project = Project::findOrFail($id);
        $project->is_active =
            $project->is_active === 'active'
            ? 'inactive'
            : 'active';
        $project->save();
    }
    public function toggleRegistrationStatus(string $id): void
    {
        abort_unless(
            auth()->user()->can('projects.edit'),
            403
        );
        $project = Project::findOrFail($id);
        $project->registration_status =
            $project->registration_status === 'open'
            ? 'closed'
            : 'open';
        $project->save();
    }
    public function toggleInventoryType(string $id): void
    {
        abort_unless(
            auth()->user()->can('projects.edit'),
            403
        );
        $project = Project::findOrFail($id);

        $hasLeads = $project->leads()->exists();
        $hasDeals = \App\Models\Deal::where('project_id', $project->id)->exists();
        $hasInventory = $project->inventories()->exists();

        if ($hasLeads || $hasDeals || $hasInventory) {
            $reasons = [];
            if ($hasLeads) $reasons[] = 'Leads';
            if ($hasDeals) $reasons[] = 'Deals';
            if ($hasInventory) $reasons[] = 'Inventories';

            $this->dispatch('swal:alert', [
                'title' => 'Cannot Switch Inventory Type!',
                'text' => 'This project has existing ' . implode(', ', $reasons) . '. You cannot switch the inventory type.',
                'icon' => 'error'
            ]);
            return;
        }

        $project->inventory_type = $project->inventory_type === 'flat' ? 'plot' : 'flat';
        $project->save();

        $this->dispatch('swal:alert', [
            'title' => 'Inventory Type Updated!',
            'text' => 'Inventory type changed to ' . ($project->inventory_type === 'flat' ? 'Flat' : 'Plot') . ' successfully.',
            'icon' => 'success'
        ]);
    }
    public function render()
    {
        $projects = Project::query()
            ->with([
                'projectType:id,name',
                'flat:id,name',
            ])
            ->when(
                $this->keyword,
                function ($query) {
                    $query->where(function ($q) {
                        $q->where('name', 'like', '%' . $this->keyword . '%')
                            ->orWhere('slug', 'like', '%' . $this->keyword . '%');
                    });
                }
            )
            ->when(
                $this->status,
                fn($query) => $query->where('status', $this->status)
            )
            ->when(
                $this->is_active,
                fn($query) => $query->where('is_active', $this->is_active)
            )
            ->latest()
            ->paginate(20);
        return view('livewire.project.index', [
            'projects' => $projects,
        ]);
    }
}
