<?php

namespace App\Livewire\Agent;

use App\Models\Agent;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Agents')]
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search_name = '';
    public string $search_code = '';
    public string $status = '';

    public function mount(): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );
    }

    public function updatingSearchName(): void
    {
        $this->resetPage();
    }

    public function updatingSearchCode(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(string $id): void
    {
        $agent = Agent::findOrFail($id);
        $agent->status = $agent->status === 'active' ? 'inactive' : 'active';
        $agent->save();

        session()->flash('success', 'Agent status updated successfully.');
    }

    public function delete(string $id): void
    {
        $agent = Agent::findOrFail($id);
        
        // Restrict deletion if agent has associated leads
        if ($agent->leads()->exists()) {
            session()->flash('error', 'Cannot delete Agent because they have associated leads.');
            return;
        }

        $agent->delete();
        session()->flash('success', 'Agent deleted successfully.');
        $this->resetPage();
    }

    public function render()
    {
        $agents = Agent::query()
            ->when($this->search_name, fn($query) => $query->where('name', 'like', "%{$this->search_name}%"))
            ->when($this->search_code, fn($query) => $query->where('code', 'like', "%{$this->search_code}%"))
            ->when($this->status !== '', fn($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(15);

        return view('livewire.agent.index', [
            'agents' => $agents,
        ]);
    }
}
