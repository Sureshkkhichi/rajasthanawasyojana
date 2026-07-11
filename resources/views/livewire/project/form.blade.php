<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0 d-flex align-items-center">
                            <a href="{{ route('projects.index') }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line align-bottom"></i> Back
                            </a>
                            {{ $projectId ? 'Edit Project' : 'Add New Project' }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('projects.index') }}">Projects</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ $projectId ? 'Edit' : 'Create' }}
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
                                    {{ $projectId ? 'Edit '. $name .' Project' : 'Add New Project' }}
                                    <br>
                                    <small class="fs-12 text-muted">Edit the project available on website amongs the one
                                        you have selected.</small>
                                </h4>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="javascript:void(0);"
                                            class="nav-link {{ $activeTab === 'generalTab' ? 'active' : '' }}"
                                            wire:click="$set('activeTab', 'generalTab')">
                                            <i class="ri-building-line me-1"></i>
                                            General Settings
                                        </a>
                                    </li>
                                    @if($projectId)
                                    <li class="nav-item" role="presentation">
                                        <a href="javascript:void(0);"
                                            class="nav-link {{ $activeTab === 'sliderTab' ? 'active' : '' }}"
                                            wire:click="$set('activeTab', 'sliderTab')">
                                            <i class="ri-image-line me-1"></i>
                                            Detail Page Slider
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="javascript:void(0);"
                                            class="nav-link {{ $activeTab === 'infoTab' ? 'active' : '' }}"
                                            wire:click="$set('activeTab', 'infoTab')">
                                            <i class="ri-information-line me-1"></i>
                                            Detail Page Setting
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
                                                <input type="text"
                                                    class="form-control rounded-pill @error('name') is-invalid @enderror"
                                                    wire:model.live="name" placeholder="Enter project name">
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
                                                <input type="text" class="form-control rounded-pill" wire:model="slug"
                                                    readonly>
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
                                                <select
                                                    class="form-select rounded-pill @error('project_type_id') is-invalid @enderror"
                                                    wire:model="project_type_id">
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
                                            {{-- City --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">City</label>
                                                <input type="text" class="form-control rounded-pill" wire:model="city"
                                                    placeholder="Enter city">
                                            </div>
                                            {{-- Price --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">Price <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control rounded-pill @error('price') is-invalid @enderror"
                                                    wire:model="price" placeholder="e.g. ₹ 15 Lakh - ₹ 35 Lakh">
                                                @error('price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Status --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">Project Status</label>
                                                <select
                                                    class="form-select rounded-pill @error('status') is-invalid @enderror"
                                                    wire:model="status">
                                                    @foreach (config('constants.project_status') as $key =>
                                                    $project_status)
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
                                                <select
                                                    class="form-select rounded-pill @error('is_active') is-invalid @enderror"
                                                    wire:model="is_active">
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
                                            {{-- Show on Homepage --}}
                                            <div class="col-xl-3 col-md-6">
                                                <label class="form-label">Show on Homepage</label>
                                                <select
                                                    class="form-select rounded-pill @error('show_on_homepage') is-invalid @enderror"
                                                    wire:model="show_on_homepage">
                                                    <option value="active">
                                                        Active
                                                    </option>
                                                    <option value="inactive">
                                                        Inactive
                                                    </option>
                                                </select>
                                                @error('show_on_homepage')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- Address --}}
                                            <div class="col-12">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" rows="3" wire:model="address"
                                                    placeholder="Enter project address"></textarea>
                                            </div>
                                            {{-- Featured Image --}}
                                            <div class="col-12 mt-3">
                                                <label class="form-label">Featured Image</label>
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <input type="file"
                                                            class="form-control @error('featured_image_file') is-invalid @enderror"
                                                            wire:model="featured_image_file" accept="image/*">
                                                        <small class="text-muted">Recommended size: 800x600. Max size:
                                                            2MB.</small>
                                                        @error('featured_image_file')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if ($featured_image_file)
                                                        <div class="mt-2">
                                                            <span class="text-success d-block mb-1">Temporary
                                                                Preview:</span>
                                                            <img src="{{ $featured_image_file->temporaryUrl() }}"
                                                                class="img-thumbnail"
                                                                style="max-height: 150px; object-fit: cover;">
                                                        </div>
                                                        @elseif ($featured_image)
                                                        <div class="mt-2 position-relative d-inline-block">
                                                            <span class="text-muted d-block mb-1">Current Image:</span>
                                                            <img src="{{ asset($featured_image) }}"
                                                                class="img-thumbnail"
                                                                style="max-height: 150px; object-fit: cover;">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger position-absolute top-0 end-0 mt-4 me-1"
                                                                wire:click="deleteFeaturedImage"
                                                                onclick="if (!confirm('Are you sure you want to delete the featured image?')) { event.stopImmediatePropagation(); return false; }"
                                                                title="Delete Featured Image">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- ========================= --}}
                                    {{-- Slider Tab --}}
                                    {{-- ========================= --}}
                                    @if($projectId)
                                    <div class="tab-pane fade {{ $activeTab === 'sliderTab' ? 'show active' : '' }}">
                                        <div class="alert alert-info">
                                            Upload the desired slider image to to shown on the detail page.
                                        </div>
                                        {{-- Upload Section --}}
                                        <div class="card border shadow-none">
                                            <div class="card-body">
                                                <div class="row align-items-end">
                                                    <div class="col-lg-8">
                                                        <label class="form-label">
                                                            Upload Slider Images
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            wire:model="sliderImages"
                                                            wire:key="slider-upload-{{ $uploadIteration }}" multiple
                                                            accept="image/*">
                                                        <small class="text-muted">
                                                            Supported formats: JPG, PNG, and WEBP. Recommended image
                                                            width: 1600px. Height can vary depending on your
                                                            requirements. Maximum file size: 2 MB per image.
                                                        </small>
                                                        @error('sliderImages.*')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div wire:loading.flex wire:target="updatedSliderImages"
                                                            class="text-primary" style="display:none;">
                                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                                            Uploading images...
                                                        </div>
                                                        <div wire:loading.remove wire:target="sliderImages">
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
                                                                <th width="10">
                                                                    Sort Order
                                                                </th>
                                                                <th width="150">
                                                                    Show on Homepage
                                                                </th>
                                                                <th width="150">
                                                                    Show on Detail Page
                                                                </th>
                                                                <th width="10">
                                                                    Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($sliders as $slider)
                                                            <tr wire:key="slider-{{ $slider->id }}">
                                                                {{-- Image --}}
                                                                <td>
                                                                    <img src="{{ asset($slider->image) }}"
                                                                        class="rounded border"
                                                                        style="width:70px;height:50px;object-fit:cover;">
                                                                </td>
                                                                {{-- Sort Order --}}
                                                                <td>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $slider->sort_order }}"
                                                                        wire:change="updateSortOrder('{{ $slider->id }}',$event.target.value)">
                                                                </td>
                                                                {{-- Show on Homepage --}}
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch"
                                                                            id="slider-home-{{ $slider->id }}"
                                                                            {{ $slider->show_on_homepage === 'yes' ? 'checked' : '' }}
                                                                            wire:click="toggleHomeSlider('{{ $slider->id }}')">
                                                                        <label class="form-check-label text-capitalize"
                                                                            for="slider-home-{{ $slider->id }}">
                                                                            {{ $slider->show_on_homepage === 'yes' ? 'Yes' : 'No' }}
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                {{-- Show on Detail Page --}}
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            role="switch"
                                                                            id="slider-detail-{{ $slider->id }}"
                                                                            {{ $slider->show_on_detail_page === 'yes' ? 'checked' : '' }}
                                                                            wire:click="toggleDetailSlider('{{ $slider->id }}')">
                                                                        <label class="form-check-label text-capitalize"
                                                                            for="slider-detail-{{ $slider->id }}">
                                                                            {{ $slider->show_on_detail_page === 'yes' ? 'Yes' : 'No' }}
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                {{-- Actions --}}
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-danger"
                                                                        wire:click="deleteSlider('{{ $slider->id }}')"
                                                                        wire:loading.attr="disabled"
                                                                        wire:target="deleteSlider">

                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td colspan="5" class="text-center py-5">
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

                                    @if($projectId)
                                    <div class="tab-pane fade {{ $activeTab === 'infoTab' ? 'show active' : '' }}">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-16 fw-semibold text-dark">Information Section Images</h5>
                                                <p class="text-muted mb-0">Manage images displayed in the informational
                                                    grid at the bottom of the project details page.</p>
                                            </div>
                                        </div>
                                        <hr>

                                        {{-- Image Upload block --}}
                                        <div class="card border shadow-none mt-3">
                                            <div class="card-body">
                                                <div class="row align-items-end">
                                                    <div class="col-lg-8">
                                                        <label class="form-label fw-semibold">Upload Information
                                                            Images</label>
                                                        <input type="file" class="form-control"
                                                            wire:model="infoImageFiles"
                                                            wire:key="info-upload-{{ $infoUploadIteration }}" multiple
                                                            accept="image/*">
                                                        <small class="text-muted">You can select multiple images.
                                                            Supported formats: JPG, PNG, and WEBP. Recommended image
                                                            width: 1600px. Height can vary depending on your
                                                            requirements. Maximum file size: 2 MB per image.</small>
                                                        @error('infoImageFiles.*')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 text-start">
                                                        <div wire:loading wire:target="infoImageFiles"
                                                            class="text-primary mt-2">
                                                            <span class="spinner-border spinner-border-sm me-1"
                                                                role="status"></span>
                                                            Uploading and saving images...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Image List --}}
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="120">Image Preview</th>
                                                        <th>File Path</th>
                                                        <th width="120">Sort Order</th>
                                                        <th width="80">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($infoImages as $img)
                                                    <tr wire:key="info-img-row-{{ $img->id }}">
                                                        <td>
                                                            <img src="{{ asset($img->image_path) }}"
                                                                class="rounded img-thumbnail"
                                                                style="width: 100px; height: 60px; object-fit: cover;">
                                                        </td>
                                                        <td class="text-muted fs-13">{{ $img->image_path }}</td>
                                                        <td>
                                                            <input type="number"
                                                                class="form-control form-control-sm text-center"
                                                                value="{{ $img->sort_order }}"
                                                                wire:change="updateInfoImageSortOrder('{{ $img->id }}', $event.target.value)"
                                                                style="width: 70px;">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                wire:click="deleteInfoImage('{{ $img->id }}')"
                                                                onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">No
                                                            information images uploaded. Use the upload field above to
                                                            add images.</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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