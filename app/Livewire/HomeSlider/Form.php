<?php
namespace App\Livewire\HomeSlider;
use App\Models\HomeSlider;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
#[Layout('layouts.app')]
#[Title('Home Slider')]
class Form extends Component
{
    use WithFileUploads;
    public ?HomeSlider $homeSlider = null;
    public string $title = '';
    public string $subtitle = '';
    public ?string $button_text = null;
    public ?string $button_link = null;
    public int $sort_order = 0;
    public string $status = 'active';
    /*
    |--------------------------------------------------------------------------
    | Link Settings
    |--------------------------------------------------------------------------
    */
    public string $link_type = 'custom';
    public ?string $project_id = null;
    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    */
    public $desktop_image_file;
    public $mobile_image_file;
    public ?string $desktop_image = null;
    public ?string $mobile_image = null;
    public bool $isEdit = false;
    public function mount(HomeSlider $homeSlider = null): void
    {
        if ($homeSlider?->exists) {
            abort_unless(auth()->user()->can('home.slider.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('home.slider.create'), 403);
        }
        if (!$homeSlider?->exists) {
            return;
        }
        $this->homeSlider = $homeSlider;
        $this->isEdit = true;
        $this->title = $homeSlider->title;
        $this->subtitle = $homeSlider->subtitle ?? '';
        $this->button_text = $homeSlider->button_text;
        $this->button_link = $homeSlider->button_link;
        $this->sort_order = $homeSlider->sort_order;
        $this->status = $homeSlider->status;
        $this->desktop_image = $homeSlider->desktop_image;
        $this->mobile_image = $homeSlider->mobile_image;
        /*
        |--------------------------------------------------------------------------
        | Detect Link Type
        |--------------------------------------------------------------------------
        */
        if ($homeSlider->button_link && str_starts_with($homeSlider->button_link, 'project:')) {
            $this->link_type = 'project';
            $this->project_id = str_replace('project:', '', $homeSlider->button_link);
            $this->button_link = null;
        }
    }
    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => [
                'nullable',
                'required_if:link_type,custom',
                'url',
                'max:500',
            ],
            'project_id' => [
                'nullable',
                'required_if:link_type,project',
                'exists:projects,id',
            ],
            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],
            'desktop_image_file' => [
                $this->isEdit ? 'nullable' : 'required',
                'image',
                'max:2048',
            ],
            'mobile_image_file' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ];
    }
    protected function store(): HomeSlider
    {
        if ($this->isEdit) {
            abort_unless(auth()->user()->can('home.slider.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('home.slider.create'), 403);
        }
        $this->validate();
        /*
        |--------------------------------------------------------------------------
        | Resolve Button Link
        |--------------------------------------------------------------------------
        */
        $buttonLink = null;
        if ($this->link_type === 'project') {
            $buttonLink = 'project:' . $this->project_id;
        } else {
            $buttonLink = $this->button_link;
        }
        /*
        |--------------------------------------------------------------------------
        | Upload Images
        |--------------------------------------------------------------------------
        */
        $desktopImage = $this->desktop_image;
        $mobileImage = $this->mobile_image;
        $uploadPath = public_path('uploads/home-sliders');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }
        if ($this->desktop_image_file) {
            if (
                $this->desktop_image &&
                File::exists(public_path($this->desktop_image))
            ) {
                File::delete(public_path($this->desktop_image));
            }
            $desktopFileName =
                Str::uuid() . '.' .
                $this->desktop_image_file->getClientOriginalExtension();
            $this->desktop_image_file->move(
                $uploadPath,
                $desktopFileName
            );
            $desktopImage = 'uploads/home-sliders/' . $desktopFileName;
        }
        if ($this->mobile_image_file) {
            if (
                $this->mobile_image &&
                File::exists(public_path($this->mobile_image))
            ) {
                File::delete(public_path($this->mobile_image));
            }
            $mobileFileName =
                Str::uuid() . '.' .
                $this->mobile_image_file->getClientOriginalExtension();
            $this->mobile_image_file->move(
                $uploadPath,
                $mobileFileName
            );
            $mobileImage = 'uploads/home-sliders/' . $mobileFileName;
        }
        return HomeSlider::updateOrCreate(
            [
                'id' => $this->homeSlider?->id,
            ],
            [
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'desktop_image' => $desktopImage,
                'mobile_image' => $mobileImage,
                'button_text' => $this->button_text,
                'button_link' => $buttonLink,
                'sort_order' => $this->sort_order,
                'status' => $this->status,
            ]
        );
    }
    public function save()
    {
        $isUpdate = $this->isEdit;
        $slider = $this->store();
        $this->homeSlider = $slider;
        $this->isEdit = true;
        session()->flash(
            'success',
            $isUpdate
            ? 'Home Slider updated successfully.'
            : 'Home Slider created successfully.'
        );
        return redirect()->route('home-sliders.index');
    }
    public function saveAndNew()
    {
        $this->store();
        $this->reset([
            'title',
            'subtitle',
            'button_text',
            'button_link',
            'desktop_image_file',
            'mobile_image_file',
            'desktop_image',
            'mobile_image',
            'project_id',
        ]);
        $this->homeSlider = null;
        $this->isEdit = false;
        $this->status = 'active';
        $this->sort_order = 0;
        $this->link_type = 'custom';
        session()->flash(
            'success',
            'Home Slider created successfully.'
        );
    }
    public function getProjectsProperty()
    {
        return Project::query()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }
    public function updatedLinkType(): void
    {
        if ($this->link_type === 'custom') {
            $this->project_id = null;
        } else {
            $this->button_link = null;
        }
    }
    public function render()
    {
        return view('livewire.home-slider.form', [
            'projects' => $this->projects,
        ]);
    }
}