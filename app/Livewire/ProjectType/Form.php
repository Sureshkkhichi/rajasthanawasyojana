<?php

namespace App\Livewire\ProjectType;

use App\Models\ProjectType;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Project Type')]
class Form extends Component
{
    public ?ProjectType $projectType = null;

    public string $name = '';
    public string $slug = '';
    public string $status = 'active';

    public bool $isEdit = false;

    public function mount(ProjectType $projectType = null): void
    {
        if ($projectType) {
            abort_unless(auth()->user()->can('project.type.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('project.type.create'), 403);
        }

        if (!$projectType) {
            return;
        }

        $this->projectType = $projectType;
        $this->isEdit = true;

        $this->name = $projectType->name;
        $this->slug = $projectType->slug;
        $this->status = $projectType->status;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:project_types,slug,' . ($this->projectType?->id ?? 'NULL') . ',id',
            ],

            'status' => ['required', 'in:active,inactive'],
        ];
    }

    /**
     * Auto generate slug when user leaves project type field.
     */
    public function updatedName(): void
    {
        $this->slug = $this->generateUniqueSlug($this->name);
    }

    /**
     * Generate unique slug.
     */
    protected function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if (!$baseSlug) {
            return '';
        }

        $slug = $baseSlug;
        $counter = 1;

        $query = ProjectType::query();

        if ($this->projectType?->exists) {
            $query->where('id', '!=', $this->projectType->id);
        }

        while (
            (clone $query)
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Create / Update Record
     */
    protected function store(): ProjectType
    {
        if ($this->isEdit) {
            abort_unless(auth()->user()->can('project.type.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('project.type.create'), 403);
        }
        $this->validate();
        return ProjectType::updateOrCreate(
            [
                'id' => $this->projectType?->id,
            ],
            [
                'name' => $this->name,
                'slug' => $this->slug,
                'status' => $this->status,
            ]
        );
    }

    /**
     * Save & Continue
     */
    public function save()
    {
        $isUpdate = $this->isEdit;

        $projectType = $this->store();

        $this->projectType = $projectType;
        $this->isEdit = true;

        session()->flash(
            'success',
            $isUpdate
            ? 'Project Type updated successfully.'
            : 'Project Type created successfully.'
        );

        return redirect()->route('project-types.index');
    }

    /**
     * Save & Add New
     */
    public function saveAndNew()
    {
        $this->store();

        $this->reset([
            'name',
            'slug',
        ]);

        $this->projectType = null;
        $this->isEdit = false;
        $this->status = 'active';

        session()->flash(
            'success',
            'Project Type created successfully.'
        );
    }

    public function render()
    {
        return view('livewire.project-type.form');
    }
}