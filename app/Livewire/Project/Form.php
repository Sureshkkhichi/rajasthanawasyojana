<?php
namespace App\Livewire\Project;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\ProjectType;
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
    public $country_id = 101;
    public $state_id = '';
    public $city_id = '';
    public string $address = '';
    public string $status = 'upcoming';
    public string $is_active = 'active';
    public $projectTypes = [];
    public $countries = [];
    public $states = [];
    public $cities = [];
    public array $sliderImages = [];
    public $sliders = [];
    public string $activeTab = 'generalTab';
    public int $uploadIteration = 0;
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
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:upcoming,active,completed,hold,cancelled',
            'is_active' => 'required|in:active,inactive',
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
        $this->countries = Country::orderBy('name')->get();
        if ($project && $project->exists) {
            $this->project = $project;
            $this->projectId = $project->id;
            $this->name = $project->name;
            $this->slug = $project->slug;
            $this->project_type_id = $project->project_type_id;
            $this->country_id = $project->country_id;
            $this->state_id = $project->state_id;
            $this->city_id = $project->city_id;
            $this->address = $project->address ?? '';
            $this->status = $project->status;
            $this->is_active = $project->is_active;
        }
        if ($this->projectId) {
            $this->loadSliders();
        }
        $this->loadStates();
        $this->loadCities();
    }
    protected function loadSliders(): void
    {
        $this->sliders = ProjectSlider::query()
            ->where('project_id', $this->projectId)
            ->orderBy('sort_order')
            ->get();
    }
    public function updatedName(): void
    {
        $this->slug = Str::slug($this->name);
    }
    public function updatedCountryId(): void
    {
        $this->state_id = '';
        $this->city_id = '';
        $this->loadStates();
        $this->cities = collect();
    }
    public function updatedStateId(): void
    {
        $this->city_id = '';
        $this->loadCities();
    }
    protected function loadStates(): void
    {
        $this->states = State::query()
            ->when(
                $this->country_id,
                fn($query) => $query->where('country_id', $this->country_id)
            )
            ->orderBy('name')
            ->get();
    }
    protected function loadCities(): void
    {
        $this->cities = City::query()
            ->select('id', 'name')
            ->where('state_id', $this->state_id)
            ->orderBy('name')
            ->get();
    }
    protected function sliderRules(): array
    {
        return [
            'sliderImages.*' => 'image|max:5120',
        ];
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
        $project = Project::updateOrCreate(
            [
                'id' => $this->projectId,
            ],
            $validated
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
        $project = Project::create($validated);
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
        foreach ($this->sliderImages as $image) {
            if (!$image instanceof TemporaryUploadedFile) {
                continue;
            }
            $path = $image->store(
                'projects/sliders',
                'public'
            );
            ProjectSlider::create([
                'project_id' => $project->id,
                'title' => pathinfo(
                    $image->getClientOriginalName(),
                    PATHINFO_FILENAME
                ),
                'image' => $path,
                'display_on' => 'project',
                'sort_order' => ++$lastOrder,
                'is_home_slider' => false,
                'is_active' => 'active',
            ]);
        }
        $this->sliderImages = [];
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
        if ($slider->image) {
            Storage::disk('public')
                ->delete($slider->image);
        }
        $slider->delete();
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
    }
    public function updateSortOrder(string $sliderId, int $order): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        ProjectSlider::where('id', $sliderId)->update(['sort_order' => $order,]);
        $this->loadSliders();
    }
    public function toggleHomeSlider(string $sliderId): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        $slider = ProjectSlider::find($sliderId);
        if (!$slider) {
            return;
        }
        $slider->update(['is_home_slider' => !$slider->is_home_slider,]);
        $this->loadSliders();
    }
    public function updateDisplayOn(string $sliderId, string $displayOn): void
    {
        abort_unless(auth()->user()->can('projects.edit'), 403);

        ProjectSlider::where('id', $sliderId)->update(['display_on' => $displayOn,]);
        $this->loadSliders();
    }
    protected function resetForm(): void
    {
        $this->reset([
            'name',
            'slug',
            'project_type_id',
            'state_id',
            'city_id',
            'address',
        ]);
        $this->country_id = 101;
        $this->status = 'upcoming';
        $this->is_active = 'active';
        $this->loadStates();
        $this->cities = collect();
        $this->sliderImages = [];
        $this->sliders = [];
        $this->activeTab = 'generalTab';
    }
    public function render()
    {
        return view('livewire.project.form');
    }
}