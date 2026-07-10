<?php

namespace App\Livewire\FrontendConfiguration;

use App\Models\FrontendSetting;
use App\Models\Project;
use App\Models\HomeSlider;
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

    // Banner (Slider) properties
    public bool $showBannerForm = false;
    public ?string $bannerId = null;
    public ?string $banner_project_id = null;
    public int $banner_sort_order = 0;
    public string $banner_status = 'active';
    public $banner_desktop_file;
    public ?string $banner_desktop_image = null;
    public int $bannerUploadIteration = 0;

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
    // BANNER (SLIDER) ACTIONS
    // ============================================

    public function createBanner(): void
    {
        abort_unless(auth()->user()->can('home.slider.create'), 403);
        $this->resetBannerForm();
        $this->showBannerForm = true;
    }

    public function editBanner(string $id): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);
        $banner = HomeSlider::findOrFail($id);
        $this->bannerId = $banner->id;
        $this->banner_project_id = $banner->project_id;
        $this->banner_sort_order = $banner->sort_order;
        $this->banner_status = $banner->status;
        $this->banner_desktop_image = $banner->desktop_image;

        $this->showBannerForm = true;
    }

    public function saveBanner()
    {
        $isEdit = !empty($this->bannerId);
        if ($isEdit) {
            abort_unless(auth()->user()->can('home.slider.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('home.slider.create'), 403);
        }

        $rules = [
            'banner_project_id' => [
                'required',
                'exists:projects,id',
            ],
            'banner_sort_order' => ['required', 'integer', 'min:0'],
            'banner_status' => ['required', 'in:active,inactive'],
            'banner_desktop_file' => [$isEdit ? 'nullable' : 'required', 'image', 'max:2048'],
        ];

        $this->validate($rules);

        $desktopImage = $this->banner_desktop_image;
        $uploadPath = public_path('uploads/home-sliders');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        if ($this->banner_desktop_file) {
            if ($this->banner_desktop_image && File::exists(public_path($this->banner_desktop_image))) {
                File::delete(public_path($this->banner_desktop_image));
            }
            $desktopFileName = Str::uuid() . '.' . $this->banner_desktop_file->getClientOriginalExtension();
            File::copy($this->banner_desktop_file->getRealPath(), $uploadPath . '/' . $desktopFileName);
            $desktopImage = 'uploads/home-sliders/' . $desktopFileName;
        }

        HomeSlider::updateOrCreate(
            ['id' => $this->bannerId],
            [
                'project_id' => $this->banner_project_id,
                'desktop_image' => $desktopImage,
                'sort_order' => $this->banner_sort_order,
                'status' => $this->banner_status,
            ]
        );

        session()->flash('success_banner', $isEdit ? 'Slider updated successfully.' : 'Slider created successfully.');
        $this->resetBannerForm();
        $this->showBannerForm = false;
    }

    public function toggleBannerStatus(string $id): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);
        $banner = HomeSlider::findOrFail($id);
        $banner->update([
            'status' => $banner->status === 'active' ? 'inactive' : 'active'
        ]);
        session()->flash('success_banner', 'Banner status updated successfully.');
    }

    public function deleteBanner(string $id): void
    {
        abort_unless(auth()->user()->can('home.slider.delete'), 403);
        $banner = HomeSlider::findOrFail($id);
        $banner->delete();
        session()->flash('success_banner', 'Banner deleted successfully.');
    }

    public function updateBannerSortOrder(string $id, int $order): void
    {
        abort_unless(auth()->user()->can('home.slider.edit'), 403);
        HomeSlider::where('id', $id)->update(['sort_order' => $order]);
        session()->flash('success_banner', 'Sort order updated successfully.');
    }

    public function cancelBannerForm(): void
    {
        $this->resetBannerForm();
        $this->showBannerForm = false;
    }

    protected function resetBannerForm(): void
    {
        $this->reset([
            'bannerId',
            'banner_project_id',
            'banner_sort_order',
            'banner_status',
            'banner_desktop_file',
            'banner_desktop_image',
        ]);
        $this->banner_status = 'active';
        $this->bannerUploadIteration++;
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
            'banners' => HomeSlider::query()->orderBy('sort_order')->get(),
            'infoImages' => InformationImage::query()->orderBy('sort_order')->get(),
            'projects' => Project::active()->orderBy('name')->get(),
        ]);
    }
}
