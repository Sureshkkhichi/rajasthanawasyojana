<?php
namespace App\Livewire\Project;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Flat;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ProjectSlider;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Validation\Rule;
#[Layout('layouts.app')]
#[Title('Project')]
class Form extends Component
{
    use WithFileUploads;
    public ?Project $project = null;
    public ?string $projectId = null;
    public string $name = '';
    public string $slug = '';
    public string $project_type_id = '';
    public string $flat_id = '';
    public string $inventory_type = 'plot';
    public $city = '';
    public string $address = '';
    public string $status = 'upcoming';
    public string $is_active = 'active';
    public $projectTypes = [];
    public $flats = [];
    public $sliderImages = [];
    public $sliders = [];
    public string $activeTab = 'generalTab';
    public int $uploadIteration = 0;
    public $featured_image_file;
    public ?string $featured_image = null;
    public ?string $price = null;
    public string $registration_status = 'open';
    
    // Information Section properties
    public $infoImageFiles = [];
    public $infoImages = [];
    public int $infoUploadIteration = 0;
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'slug')->ignore($this->projectId),
            ],
            'project_type_id' => 'required|exists:project_types,id',
            'inventory_type' => 'required|in:plot,flat',
            'city' => 'nullable',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:upcoming,active,completed,hold,cancelled',
            'is_active' => 'required|in:active,inactive',
            'featured_image_file' => 'nullable|image|max:2048',
            'price' => 'required|numeric',
            'registration_status' => 'required|in:open,closed',
        ];
    }
    public function mount(?Project $project = null): void
    {
        if ($project && $project->exists) {
            abort_unless(auth()->user()->can('projects.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('projects.create'), 403);
        }

        $this->projectTypes = ProjectType::active()->orderBy('name')->get();
        $this->flats = Flat::active()->orderBy('name')->get();
        if ($project && $project->exists) {
            $this->project = $project;
            $this->projectId = $project->id;
            $this->name = $project->name;
            $this->slug = $project->slug;
            $this->project_type_id = $project->project_type_id;
            $this->inventory_type = $project->inventory_type ?? 'plot';
            $this->city = $project->city;
            $this->address = $project->address ?? '';
            $this->status = $project->status;
            $this->is_active = $project->is_active;
            $this->featured_image = $project->featured_image;
            $this->price = $project->price;
            $this->registration_status = $project->registration_status ?? 'open';
        }
        if ($this->projectId) {
            $this->loadSliders();
            $this->loadInfoImages();
        }
    }
    protected function loadSliders(): void
    {
        $this->sliders = ProjectSlider::query()
            ->where('project_id', $this->projectId)
            ->orderBy('sort_order')
            ->get();
    }
    public function loadInfoImages(): void
    {
        if ($this->projectId) {
            $this->infoImages = \App\Models\ProjectInformationImage::query()
                ->where('project_id', $this->projectId)
                ->orderBy('sort_order')
                ->get();
        } else {
            $this->infoImages = [];
        }
    }
    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }
    protected function sliderRules(): array
    {
        return [
            'sliderImages.*' => 'image|max:5120',
        ];
    }
    protected function uploadFeaturedImage(): void
    {
        if ($this->featured_image_file) {
            if ($this->featured_image && File::exists(public_path($this->featured_image))) {
                File::delete(public_path($this->featured_image));
            }
            $uploadPath = public_path('uploads/projects');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }
            $fileName = Str::uuid() . '.' . $this->featured_image_file->getClientOriginalExtension();
            File::copy(
                $this->featured_image_file->getRealPath(),
                $uploadPath . '/' . $fileName
            );
            $this->featured_image = 'uploads/projects/' . $fileName;
        }
    }
    public function save()
    {
        if ($this->projectId) {
            abort_unless(auth()->user()->can('projects.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('projects.create'), 403);
        }

        $isUpdate = !empty($this->projectId);
        $validated = $this->validate();
        $this->uploadFeaturedImage();

        $data = $validated;
        unset($data['featured_image_file']);
        $data['featured_image'] = $this->featured_image;

        $project = Project::updateOrCreate(
            [
                'id' => $this->projectId,
            ],
            $data
        );
        $this->projectId = $project->id;
        session()->flash(
            'success',
            $isUpdate
            ? 'Project updated successfully.'
            : 'Project created successfully.'
        );
        return redirect()->route('projects.index');
    }
    public function saveAndNew()
    {
        abort_unless(auth()->user()->can('projects.create'), 403);

        $validated = $this->validate();
        $this->uploadFeaturedImage();

        $data = $validated;
        unset($data['featured_image_file']);
        $data['featured_image'] = $this->featured_image;

        $project = Project::create($data);
        $this->resetForm();
        session()->flash(
            'success',
            'Project created successfully.'
        );
    }
    protected function uploadSliders(Project $project): void
    {
        if (empty($this->sliderImages)) {
            return;
        }

        $lastOrder = ProjectSlider::where('project_id', $project->id)
            ->max('sort_order') ?? 0;
        $uploadPath = public_path('uploads/projects/sliders');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        foreach ($this->sliderImages as $image) {
            if (!$image instanceof TemporaryUploadedFile) {
                continue;
            }
            $fileName = Str::uuid() . '.' .
                $image->getClientOriginalExtension();
            File::copy(
                $image->getRealPath(),
                $uploadPath . '/' . $fileName
            );
            ProjectSlider::create([
                'project_id' => $project->id,
                'title' => pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                ),
                'image' => 'uploads/projects/sliders/' . $fileName,
                'sort_order' => ++$lastOrder,
                'is_active' => 'active',
            ]);
        }
        $this->reset('sliderImages');
        $this->uploadIteration++;
        $this->loadSliders();

    }

    public function deleteSlider(string $sliderId): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        $slider = ProjectSlider::find($sliderId);

        if (!$slider) {
            return;
        }

        if ($slider->image && File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }

        $slider->forceDelete();


        $this->loadSliders();

        session()->flash(
            'success',
            'Slider deleted successfully.'
        );
    }

    public function updatedSliderImages(): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        if (!$this->projectId) {
            $this->addError('sliderImages', 'Please save project first.');
            return;
        }

        $this->validate($this->sliderRules());

        $project = Project::findOrFail($this->projectId);

        $this->uploadSliders($project);

        $this->reset('sliderImages');
    }

    public function deleteFeaturedImage(): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        if ($this->featured_image) {
            $filePath = public_path(ltrim($this->featured_image, '/'));
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $this->featured_image = null;

            if ($this->project) {
                $this->project->update(['featured_image' => null]);
            }

            session()->flash('success', 'Featured image deleted successfully.');
        }
    }
    public function updateSortOrder(string $sliderId, int $order): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        ProjectSlider::where('id', $sliderId)->update(['sort_order' => $order,]);
        $this->loadSliders();
    }

    public function updatedInfoImageFiles(): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        if (!$this->projectId) {
            $this->addError('infoImageFiles', 'Please save project first.');
            return;
        }

        $this->validate([
            'infoImageFiles.*' => 'image|max:2048'
        ]);

        $uploadPath = public_path('uploads/projects/information');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $lastOrder = \App\Models\ProjectInformationImage::where('project_id', $this->projectId)
            ->max('sort_order') ?? 0;

        foreach ($this->infoImageFiles as $file) {
            if (!$file instanceof TemporaryUploadedFile) {
                continue;
            }

            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            File::copy($file->getRealPath(), $uploadPath . '/' . $fileName);

            \App\Models\ProjectInformationImage::create([
                'project_id' => $this->projectId,
                'image_path' => 'uploads/projects/information/' . $fileName,
                'sort_order' => ++$lastOrder,
            ]);
        }

        $this->reset('infoImageFiles');
        $this->infoUploadIteration++;
        $this->loadInfoImages();
        session()->flash('success', 'Information images uploaded successfully.');
    }

    public function deleteInfoImage(string $id): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        $image = \App\Models\ProjectInformationImage::findOrFail($id);
        if ($image->image_path && File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }
        $image->delete();
        $this->loadInfoImages();
        session()->flash('success', 'Image deleted successfully.');
    }

    public function updateInfoImageSortOrder(string $id, int $order): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        \App\Models\ProjectInformationImage::where('id', $id)->update(['sort_order' => $order]);
        $this->loadInfoImages();
        session()->flash('success', 'Sort order updated successfully.');
    }

    protected function resetForm(): void
    {
        $this->reset([
            'name',
            'slug',
            'project_type_id',
            'flat_id',
            'inventory_type',
            'city',
            'address',
            'sliderImages',
            'featured_image_file',
            'featured_image',
            'price',
            'infoImageFiles',
            'infoImages',
        ]);
        $this->status = 'upcoming';
        $this->is_active = 'active';
        $this->sliders = [];
        $this->infoUploadIteration = 0;
        $this->activeTab = 'generalTab';
    }
    public function render()
    {
        return view('livewire.project.form');
    }
}
