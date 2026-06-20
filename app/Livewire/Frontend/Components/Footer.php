<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Project;
use Livewire\Component;

class Footer extends Component
{
    public function mount(): void
    {

    }

    public function render()
    {
        $projects = Project::select('slug', 'name')->where('is_active', 'active')->where('status', 'active')->get();
        $upcoming_projects = Project::select('slug', 'name')->where('is_active', 'active')->where('status', 'upcoming')->get();
        return view('livewire.frontend.components.footer', compact('projects', 'upcoming_projects'));
    }
}