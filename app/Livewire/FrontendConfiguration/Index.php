<?php

namespace App\Livewire\FrontendConfiguration;

use App\Models\FrontendSetting;
use App\Models\Project;
use App\Models\InformationImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

#[Layout('layouts.app')]
#[Title('Frontend Configuration')]
class Index extends Component
{
    use WithFileUploads;

    public string $activeTab = 'general';

    // General Settings properties
    public $logo_file;
    public ?string $site_logo = null;
    public int $logoUploadIteration = 0;

    // Top Bar properties
    public string $top_bar_text = '';
    public bool $top_bar_marquee = true;
    public bool $top_bar_show = true;

    // Bottom Bar properties
    public string $bottom_bar_text = '';
    public bool $bottom_bar_marquee = true;
    public bool $bottom_bar_show = true;

    // Information Section properties
    public $info_image_files = [];
    public int $infoUploadIteration = 0;

    public function selectTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function mount(): void
    {
        abort_unless(auth()->user()->can('home.slider.view'), 403);

        // Load General Settings
        $this->site_logo = FrontendSetting::getVal('site_logo', null);

        // Load Top Bar Settings
        $this->top_bar_text = FrontendSetting::getVal('top_bar_text', '');
        $this->top_bar_marquee = (bool) FrontendSetting::getVal('top_bar_marquee', true);
        $this->top_bar_show = (bool) FrontendSetting::getVal('top_bar_show', true);

        // Load Bottom Bar Settings
        $this->bottom_bar_text = FrontendSetting::getVal('bottom_bar_text', '');
        $this->bottom_bar_marquee = (bool) FrontendSetting::getVal('bottom_bar_marquee', true);
        $this->bottom_bar_show = (bool) FrontendSetting::getVal('bottom_bar_show', true);
    }

    // Save General Settings (Logo)
    public function saveGeneral(): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);

        $rules = [
            'logo_file' => ['nullable', 'image', 'max:2048'],
        ];
        $this->validate($rules);

        if ($this->logo_file) {
            $uploadPath = public_path('uploads/logo');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Delete old logo file if it exists
            if ($this->site_logo && File::exists(public_path($this->site_logo))) {
                File::delete(public_path($this->site_logo));
            }

            $fileName = 'logo_' . time() . '.' . $this->logo_file->getClientOriginalExtension();
            File::copy($this->logo_file->getRealPath(), $uploadPath . '/' . $fileName);
            
            $this->site_logo = 'uploads/logo/' . $fileName;
            FrontendSetting::setVal('site_logo', $this->site_logo);

            $this->logo_file = null;
            $this->logoUploadIteration++;
        }

        session()->flash('success_general', 'General settings saved successfully.');
    }

    // Save Top Bar Settings
    public function saveTopBar(): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);

        FrontendSetting::setVal('top_bar_text', $this->top_bar_text);
        FrontendSetting::setVal('top_bar_marquee', $this->top_bar_marquee);
        FrontendSetting::setVal('top_bar_show', $this->top_bar_show);

        session()->flash('success_top_bar', 'Top Bar settings saved successfully.');
    }

    // Save Bottom Bar Settings
    public function saveBottomBar(): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);

        FrontendSetting::setVal('bottom_bar_text', $this->bottom_bar_text);
        FrontendSetting::setVal('bottom_bar_marquee', $this->bottom_bar_marquee);
        FrontendSetting::setVal('bottom_bar_show', $this->bottom_bar_show);

        session()->flash('success_bottom_bar', 'Bottom Bar settings saved successfully.');
    }

    // ============================================
    // INFORMATION SECTION ACTIONS
    // ============================================

    public function updatedInfoImageFiles(): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);

        $this->validate([
            'info_image_files.*' => 'image|max:2048'
        ]);

        $uploadPath = public_path('uploads/information');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $lastOrder = InformationImage::max('sort_order') ?? 0;

        foreach ($this->info_image_files as $file) {
            if (!$file instanceof TemporaryUploadedFile) {
                continue;
            }

            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            File::copy($file->getRealPath(), $uploadPath . '/' . $fileName);

            InformationImage::create([
                'image_path' => 'uploads/information/' . $fileName,
                'sort_order' => ++$lastOrder,
            ]);
        }

        $this->reset('info_image_files');
        $this->infoUploadIteration++;
        session()->flash('success_info', 'Images uploaded successfully.');
    }

    public function deleteInfoImage(string $id): void
    {
        abort_unless(auth()->user()->can('home.slider.delete'), 403);
        $image = InformationImage::findOrFail($id);
        if ($image->image_path && File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }
        $image->delete();
        session()->flash('success_info', 'Image deleted successfully.');
    }

    public function updateInfoImageSortOrder(string $id, int $order): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);
        InformationImage::where('id', $id)->update(['sort_order' => $order]);
        session()->flash('success_info', 'Sort order updated successfully.');
    }

    public function render()
    {
        return view('livewire.frontend-configuration.index', [
            'infoImages' => InformationImage::query()->orderBy('sort_order')->get(),
            'projects' => Project::active()->orderBy('name')->get(),
        ]);
    }
}
