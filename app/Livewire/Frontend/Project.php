<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use Livewire\Attributes\Layout;

#[Layout('layouts.front')]
class Project extends Component
{
    public ProjectModel $project;

    public function mount(string $slug): void
    {
        $this->project = ProjectModel::query()
            ->with([
                'sliders' => fn($query) => $query
                    ->where('is_active', 'active')
                    ->where('show_on_detail_page', 'yes')
                    ->orderBy('sort_order'),
                'informationImages' => fn($query) => $query
                    ->orderBy('sort_order')
            ])
            ->where('slug', $slug)
            ->where('is_active', 'active')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.project');
    }
}