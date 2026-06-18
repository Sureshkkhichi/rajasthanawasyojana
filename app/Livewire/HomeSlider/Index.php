<?php
namespace App\Livewire\HomeSlider;
use App\Models\HomeSlider;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
#[Layout('layouts.app')]
#[Title('Home Sliders')]
class Index extends Component
{
    use WithPagination;
    public string $search = '';
    public string $status = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];
    public function mount()
    {
        abort_unless(auth()->user()->can('home.slider.view'), 403);
    }
    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    public function updateStatus(string $id): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);
        $slider = HomeSlider::findOrFail($id);
        $slider->update([
            'status' => $slider->status === 'active'
                ? 'inactive'
                : 'active',
        ]);
        session()->flash('success', 'Slider status updated successfully.');
    }
    public function delete(string $id): void
    {
        abort_unless(auth()->user()->can('home.slider.delete'), 403);
        $slider = HomeSlider::findOrFail($id);
        $slider->delete();
        session()->flash('success', 'Slider deleted successfully.');
    }
    public function render()
    {
        $sliders = HomeSlider::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('subtitle', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('livewire.home-slider.index', [
            'sliders' => $sliders,
        ]);
    }
}