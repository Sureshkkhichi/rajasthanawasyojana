<?php

namespace App\Livewire\StaticPage;

use App\Models\StaticPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Pages')]
class Index extends Component
{
    public string $selectedPageId = '';
    public string $title = '';
    public string $content = '';
    public string $status = 'active';

    public function mount(): void
    {
        abort_unless(auth()->user()->can('pages.view'), 403);

        $page = StaticPage::query()->orderBy('title')->first();

        if ($page) {
            $this->loadPage($page->id);
        }
    }

    public function updatedSelectedPageId(string $pageId): void
    {
        $this->loadPage($pageId);
    }

    public function loadPage(string $pageId): void
    {
        abort_unless(auth()->user()->can('pages.view'), 403);

        $page = StaticPage::findOrFail($pageId);

        $this->selectedPageId = $page->id;
        $this->title = $page->title;
        $this->content = $page->content ?? '';
        $this->status = $page->status;
    }

    public function save(): void
    {
        abort_unless(auth()->user()->can('pages.edit'), 403);

        $validated = $this->validate([
            'selectedPageId' => ['required', 'exists:static_pages,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        StaticPage::where('id', $validated['selectedPageId'])->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
        ]);

        session()->flash('success', 'Page content saved successfully.');
    }

    public function render()
    {
        return view('livewire.static-page.index', [
            'pages' => StaticPage::query()->orderBy('title')->get(),
        ]);
    }
}
