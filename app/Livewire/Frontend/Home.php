<?php

namespace App\Livewire\Frontend;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.front')]
#[Title('Home')]

class Home extends Component
{
    public $home_sliders = [];
    public $projects = [];
    public $information_images = [];

    // Top bar settings
    public bool $top_bar_show = true;
    public string $top_bar_text = '';
    public bool $top_bar_marquee = true;

    // Bottom bar settings
    public bool $bottom_bar_show = true;
    public string $bottom_bar_text = '';
    public bool $bottom_bar_marquee = true;

    public function mount(): void
    {
        $this->home_sliders = \App\Models\HomeSlider::query()
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        $this->projects = \App\Models\Project::query()
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        $this->information_images = \App\Models\InformationImage::query()
            ->orderBy('sort_order')
            ->get();

        $this->top_bar_show = (bool) \App\Models\FrontendSetting::getVal('top_bar_show', true);
        $this->top_bar_text = \App\Models\FrontendSetting::getVal('top_bar_text', '');
        $this->top_bar_marquee = (bool) \App\Models\FrontendSetting::getVal('top_bar_marquee', true);

        $this->bottom_bar_show = (bool) \App\Models\FrontendSetting::getVal('bottom_bar_show', true);
        $this->bottom_bar_text = \App\Models\FrontendSetting::getVal('bottom_bar_text', '');
        $this->bottom_bar_marquee = (bool) \App\Models\FrontendSetting::getVal('bottom_bar_marquee', true);
    }

    public function getSliderUrl(\App\Models\HomeSlider $slider): string
    {
        if (empty($slider->button_link)) {
            return '#';
        }

        if (str_starts_with($slider->button_link, 'project:')) {
            $projectId = str_replace('project:', '', $slider->button_link);
            $project = \App\Models\Project::find($projectId);
            return $project ? route('project.show', $project->slug) : '#';
        }

        return $slider->button_link;
    }

    public function render()
    {
        return view('livewire.frontend.home');
    }
}