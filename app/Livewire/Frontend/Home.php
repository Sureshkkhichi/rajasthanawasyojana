<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use App\Models\HomeSlider;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.front')]
#[Title('Home')]

class Home extends Component
{
    public $home_sliders = [];

    public function mount(): void
    {
        $this->home_sliders = HomeSlider::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();
    }

    public function getSliderUrlAttribute(): string
    {
        if (empty($this->button_link)) {
            return '#';
        }

        if (str_starts_with($this->button_link, 'project:')) {

            $projectId = str_replace('project:', '', $this->button_link);

            return route('project.show', $projectId);
        }

        return $this->button_link;
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}