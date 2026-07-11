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
    public function toggleShowOnHomepage(string $id): void
    {
        abort_unless(
            auth()->user()->can('projects.edit'),
            403
        );
        $project = Project::findOrFail($id);
        $project->show_on_homepage =
            $project->show_on_homepage === 'active'
            ? 'inactive'
            : 'active';
        $project->save();
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
