<?php

namespace App\Livewire\Flat;

use App\Models\Flat;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Flat')]
class Form extends Component
{
    public ?Flat $flat = null;

    public string $name = '';
    public string $slug = '';
    public string $status = 'active';

    public bool $isEdit = false;

    public function mount(?Flat $flat = null): void
    {
        if ($flat && $flat->exists) {
            abort_unless(auth()->user()->can('flats.edit'), 403);
            $this->flat = $flat;
            $this->isEdit = true;
            $this->name = $flat->name;
            $this->slug = $flat->slug;
            $this->status = $flat->status;
        } else {
            abort_unless(auth()->user()->can('flats.create'), 403);
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:flats,slug,' . ($this->flat?->id ?? 'NULL') . ',id',
            ],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function updatedName(): void
    {
        $this->slug = $this->generateUniqueSlug($this->name);
    }

    protected function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if (!$baseSlug) {
            return '';
        }

        $slug = $baseSlug;
        $counter = 1;

        $query = Flat::query();

        if ($this->flat?->exists) {
            $query->where('id', '!=', $this->flat->id);
        }

        while ((clone $query)->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    protected function store(): Flat
    {
        if ($this->isEdit) {
            abort_unless(auth()->user()->can('flats.edit'), 403);
        } else {
            abort_unless(auth()->user()->can('flats.create'), 403);
        }

        $this->validate();

        return Flat::updateOrCreate(
            ['id' => $this->flat?->id],
            [
                'name' => $this->name,
                'slug' => $this->slug,
                'status' => $this->status,
            ]
        );
    }

    public function save()
    {
        $isUpdate = $this->isEdit;

        $flat = $this->store();
        $this->flat = $flat;
        $this->isEdit = true;

        session()->flash(
            'success',
            $isUpdate ? 'Flat updated successfully.' : 'Flat created successfully.'
        );

        return redirect()->route('flats.index');
    }

    public function saveAndNew()
    {
        $this->store();

        $this->reset(['name', 'slug']);
        $this->flat = null;
        $this->isEdit = false;
        $this->status = 'active';

        session()->flash('success', 'Flat created successfully.');
    }

    public function render()
    {
        return view('livewire.flat.form');
    }
}
