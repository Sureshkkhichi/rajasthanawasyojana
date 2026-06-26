<?php

namespace App\Livewire\Frontend;

use App\Models\StaticPage as StaticPageModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.front')]
class StaticPage extends Component
{
    public StaticPageModel $page;

    public function mount(string $slug): void
    {
        $this->page = StaticPageModel::active()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.static-page')
            ->layoutData(['Title' => $this->page->title]);
    }
}
