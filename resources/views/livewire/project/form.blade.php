<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Projects</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0);">Projects</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ $projectId ? 'Edit Project' : 'Add New Project' }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Form --}}
            <div class="row">
                <div class="col-lg-12">
                    <form wire:submit.prevent="save">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    {{ $projectId ? 'Edit Project' : 'Add New Project' }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link {{ $activeTab === 'generalTab' ? 'active' : '' }}" wire:click="$set('activeTab', 'generalTab')">
                                            <i class="ri-building-line me-1"></i>
                                            General & Property Details
                                        </a>
                                    </li>
                                    @if($projectId)
                                    <li class="nav-item" role="presentation">
                                        <a href="javascript:void(0);" class="nav-link {{ $activeTab === 'sliderTab' ? 'active' : '' }}" wire:click="$set('activeTab', 'sliderTab')">
                                            <i class="ri-image-line me-1"></i>
                                            Project Sliders
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                <div class="tab-content text-muted">
                                    {{-- ========================= --}}
                                    {{-- General Details Tab --}}
                                    {{-- ========================= --}}
                                    <div class="tab-pane fade {{ $activeTab === 'generalTab' ? 'show active' : '' }}">
                                        <div class="row gy-4">
                                            {{-- Project Name --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">
                                                    Project Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" wire:model.live="name" placeholder="Enter project name">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Slug --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">
                                                    Project Slug
                                                </label>
                                                <input type="text" class="form-control rounded-pill" wire:model="slug" readonly>
                                                @error('slug')
                                                <div class="text-danger mt-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Project Type --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">
                                                    Project Type <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select rounded-pill @error('project_type_id') is-invalid @enderror" wire:model="project_type_id">
                                                    <option value="">
                                                        Select Project Type
                                                    </option>
                                                    @foreach($projectTypes as $projectType)
                                                    <option value="{{ $projectType->id }}">
                                                        {{ $projectType->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('project_type_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Country --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">Country</label>
                                                <select class="form-select rounded-pill" wire:model.live="country_id">
                                                    <option value="">
                                                        Select Country
                                                    </option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{ $country->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- State --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">State</label>
                                                <select class="form-select rounded-pill" wire:model.live="state_id">
                                                    <option value="">
                                                        Select State
                                                    </option>
                                                    @foreach($states as $state)
                                                    <option value="{{ $state->id }}">
                                                        {{ $state->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- City --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">City</label>
                                                <select class="form-select rounded-pill" wire:model="city_id">
                                                    <option value="">
                                                        Select City
                                                    </option>
                                                    @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">
                                                        {{ $city->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- Status --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">Project Status</label>
                                                <select class="form-select rounded-pill @error('status') is-invalid @enderror" wire:model="status">
                                                    @foreach (config('constants.project_status') as $key => $project_status)
                                                    <option value="{{ $key }}">{{ $project_status }}</option>
                                                    @endforeach
                                                </select>
                                                @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Active Status --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">Status</label>
                                                <select class="form-select rounded-pill @error('is_active') is-invalid @enderror" wire:model="is_active">
                                                    <option value="active">
                                                        Active
                                                    </option>
                                                    <option value="inactive">
                                                        Inactive
                                                    </option>
                                                </select>
                                                @error('is_active')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Address --}}
                                            <div class="col-12">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" rows="3" wire:model="address" placeholder="Enter project address"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ========================= --}}
                                    {{-- Slider Tab --}}
                                    {{-- ========================= --}}
                                    @if($projectId)
                                    <div class="tab-pane fade {{ $activeTab === 'sliderTab' ? 'show active' : '' }}">
                                        <div class="alert alert-info">
                                            Upload project slider images. You can manage sort order, status and homepage visibility.
                                        </div>
                                        {{-- Upload Section --}}
                                        <div class="card border shadow-none">
                                            <div class="card-body">
                                                <div class="row align-items-end">
                                                    <div class="col-lg-8">
                                                        <label class="form-label">
                                                            Upload Slider Images
                                                        </label>
                                                        <input type="file" class="form-control" wire:model="sliderImages" wire:key="slider-upload-{{ $uploadIteration }}" multiple accept="image/*">
                                                        <small class="text-muted">
                                                            Supported formats: JPG, PNG, WEBP
                                                        </small>
                                                        @error('sliderImages.*')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div wire:loading wire:target="sliderImages">
                                                            <div class="text-primary">
                                                                <span class="spinner-border spinner-border-sm me-1"></span>
                                                                Uploading images...
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Slider Listing --}}
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">
                                                    Project Slider List
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="80">
                                                                    Image
                                                                </th>
                                                                <th>
                                                                    Title
                                                                </th>
                                                                <th width="120">
                                                                    Sort Order
                                                                </th>
                                                                <th width="180">
                                                                    Display On
                                                                </th>
                                                                <th width="120">
                                                                    Status
                                                                </th>
                                                                <th width="120">
                                                                    Home Slider
                                                                </th>
                                                                <th width="120">
                                                                    Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($sliders as $slider)
                                                            <tr wire:key="slider-{{ $slider->id }}">
                                                                {{-- Image --}}
                                                                <td>
                                                                    <img src="{{ asset('storage/'.$slider->image) }}" class="rounded border" style="width:70px;height:50px;object-fit:cover;">
                                                                </td>
                                                                {{-- Title --}}
                                                                <td>
                                                                    <strong>
                                                                        {{ $slider->title }}
                                                                    </strong>
                                                                </td>
                                                                {{-- Sort Order --}}
                                                                <td>
                                                                    <input type="number" class="form-control form-control-sm" value="{{ $slider->sort_order }}" wire:change="updateSortOrder('{{ $slider->id }}',$event.target.value)">
                                                                </td>
                                                                {{-- Display On --}}
                                                                <td>
                                                                    @switch($slider->display_on)
                                                                    @case('both')
                                                                    <span class="badge bg-success">
                                                                        Homepage + Project
                                                                    </span>
                                                                    @break
                                                                    @case('homepage')
                                                                    <span class="badge bg-primary">
                                                                        Homepage
                                                                    </span>
                                                                    @break
                                                                    @default
                                                                    <span class="badge bg-info">
                                                                        Project
                                                                    </span>
                                                                    @endswitch
                                                                </td>
                                                                {{-- Status --}}
                                                                <td>
                                                                    @if($slider->is_active == 'active')
                                                                    <span class="badge bg-success">Active</span>
                                                                    @else
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                    @endif
                                                                </td>
                                                                {{-- Home Slider --}}
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" {{ $slider->is_home_slider ? 'checked' : '' }} wire:change="toggleHomeSlider('{{ $slider->id }}')">
                                                                    </div>
                                                                </td>
                                                                {{-- Actions --}}
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-danger" wire:click="deleteSlider('{{ $slider->id }}')" wire:confirm="Are you sure you want to delete this slider?">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center py-5">
                                                                    <div class="text-muted">
                                                                        <i class="ri-image-line fs-1 d-block mb-2"></i>
                                                                        No slider images uploaded yet.
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('projects.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ri-save-line align-bottom me-1"></i>
                                        {{ $projectId ? 'Update Project' : 'Save & Continue' }}
                                    </button>
                                    @if(!$projectId)
                                    <button type="button" wire:click="saveAndNew" class="btn btn-success">
                                        <i class="ri-add-line align-bottom me-1"></i>
                                        Save & Add New
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
