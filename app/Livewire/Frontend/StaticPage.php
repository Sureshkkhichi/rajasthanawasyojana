<?php

namespace App\Livewire\Frontend;

use App\Models\StaticPage as StaticPageModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
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

    #[Title]
    public function title(): string
    {
        return $this->page->title;
    }

    public function render()
    {
        return view('livewire.frontend.static-page');
    }
}
