<?php
namespace App\Livewire\Lead;
use App\Models\Lead;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('layouts.app')]
#[Title('Leads')]
class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public string $keyword = '';
    public string $project_id = '';
    public string $status = '';
    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );
    }
    public function updatingKeyword(): void
    {
        $this->resetPage();
    }
    public function updatingProjectId(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    public function delete(string $id): void
    {
        abort_unless(
            auth()->user()->can('leads.delete'),
            403
        );
        $lead = Lead::findOrFail($id);
        $lead->delete();
        session()->flash(
            'success',
            'Lead deleted successfully.'
        );
        $this->resetPage();
    }
    public function render()
    {
        $projects = Project::query()
            ->where('status', 'active')
            ->where('is_active', 'active')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);
        $leads = Lead::query()
            ->with([
                'project:id,name',
                'state:id,name',
            ])
            ->when(
                $this->keyword,
                function ($query) {
                    $query->where(function ($q) {
                        $q->where('first_name', 'like', "%{$this->keyword}%")
                            ->orWhere('last_name', 'like', "%{$this->keyword}%")
                            ->orWhere('phone', 'like', "%{$this->keyword}%")
                            ->orWhere('email', 'like', "%{$this->keyword}%")
                            ->orWhere('pan_number', 'like', "%{$this->keyword}%");
                    });
                }
            )
            ->when(
                $this->project_id,
                fn($query) =>
                $query->where('project_id', $this->project_id)
            )
            ->when(
                $this->status !== '',
                fn($query) =>
                $query->where(
                    'status',
                    $this->status
                )
            )
            ->latest()
            ->paginate(20);
        return view('livewire.lead.index', [
            'leads' => $leads,
            'projects' => $projects,
        ]);
    }
}