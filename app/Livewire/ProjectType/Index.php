<?php

namespace App\Livewire\ProjectType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProjectType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Project Type')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        ProjectType::findOrFail($id)->delete();

        session()->flash(
            'success',
            'Project Type deleted successfully.'
        );
    }

    public function render()
    {
        $projectTypes = ProjectType::query()
            ->when(
                $this->search,
                fn($query) => $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(10);

        return view('livewire.project-type.index', [
            'projectTypes' => $projectTypes,
        ]);
    }
}