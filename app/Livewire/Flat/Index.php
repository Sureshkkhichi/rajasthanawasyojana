<?php

namespace App\Livewire\Flat;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Flat;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Flats')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public function mount()
    {
        abort_unless(auth()->user()->can('flats.view'), 403);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(string $id): void
    {
        abort_unless(auth()->user()->can('flats.delete'), 403);

        Flat::findOrFail($id)->delete();

        session()->flash('success', 'Flat deleted successfully.');
    }

    public function render()
    {
        $flats = Flat::query()
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('slug', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(10);

        return view('livewire.flat.index', [
            'flats' => $flats,
        ]);
    }
}
