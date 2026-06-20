<?php

namespace App\Livewire\Frontend\Components;

use App\Models\Project;
use Livewire\Component;

class Menu extends Component
{
    public array $menus = [];

    public function mount(): void
    {
        $this->menus = [
            [
                'title' => 'Home',
                'route' => 'front',
            ],
            [
                'title' => 'Projects',
                'route' => 'projects',
            ],
            [
                'title' => 'About Us',
                'route' => 'about',
            ],
            [
                'title' => 'Contact Us',
                'route' => 'contact',
            ],
        ];
    }

    public function render()
    {
        $project_list = Project::select('slug', 'name')->where('is_active', 'active')->get();
        return view('livewire.frontend.components.menu', compact('project_list'));
    }
}