<div>
    <div class="page-content">
        <div class="container-fluid">

            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">
                            {{ $isEdit ? 'Edit Home Slider' : 'Add Home Slider' }}
                        </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home-sliders.index') }}">
                                        Home Sliders
                                    </a>
                                </li>

                                <li class="breadcrumb-item active">
                                    {{ $isEdit ? 'Edit Home Slider' : 'Add New Home Slider' }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alerts --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form wire:submit="save" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">
                                    {{ $isEdit ? 'Edit Home Slider' : 'Add New Home Slider' }}
                                </h4>
                            </div>

                            <div class="card-body">

                                <div class="row gy-4">

                                    {{-- Title --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <label class="form-label">
                                            Title
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control rounded-pill @error('title') is-invalid @enderror"
                                            placeholder="Enter title"
                                            wire:model="title">

                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Subtitle --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <label class="form-label">
                                            Subtitle
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control rounded-pill @error('subtitle') is-invalid @enderror"
                                            placeholder="Enter subtitle"
                                            wire:model="subtitle">

                                        @error('subtitle')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Sort Order --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <label class="form-label">
                                            Sort Order
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control rounded-pill @error('sort_order') is-invalid @enderror"
                                            wire:model="sort_order">

                                        @error('sort_order')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <label class="form-label">
                                            Status
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            class="form-select rounded-pill @error('status') is-invalid @enderror"
                                            wire:model="status">

                                            <option value="active">
                                                Active
                                            </option>

                                            <option value="inactive">
                                                Inactive
                                            </option>

                                        </select>

                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Desktop Image --}}
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Desktop Image
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="file"
                                            class="form-control @error('desktop_image_file') is-invalid @enderror"
                                            wire:model="desktop_image_file"
                                            accept="image/*">

                                        @error('desktop_image_file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        @if ($desktop_image_file)
                                            <div class="mt-2">
                                                <img
                                                    src="{{ $desktop_image_file->temporaryUrl() }}"
                                                    class="img-thumbnail"
                                                    style="max-height:120px;">
                                            </div>
                                        @elseif($desktop_image)
                                            <div class="mt-2">
                                                <img
                                                    src="{{ asset('storage/' . $desktop_image) }}"
                                                    class="img-thumbnail"
                                                    style="max-height:120px;">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Mobile Image --}}
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Mobile Image
                                        </label>

                                        <input
                                            type="file"
                                            class="form-control @error('mobile_image_file') is-invalid @enderror"
                                            wire:model="mobile_image_file"
                                            accept="image/*">

                                        @error('mobile_image_file')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        @if ($mobile_image_file)
                                            <div class="mt-2">
                                                <img
                                                    src="{{ $mobile_image_file->temporaryUrl() }}"
                                                    class="img-thumbnail"
                                                    style="max-height:120px;">
                                            </div>
                                        @elseif($mobile_image)
                                            <div class="mt-2">
                                                <img
                                                    src="{{ asset('storage/' . $mobile_image) }}"
                                                    class="img-thumbnail"
                                                    style="max-height:120px;">
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Button Text --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <label class="form-label">
                                            Button Text
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control rounded-pill @error('button_text') is-invalid @enderror"
                                            placeholder="Explore Now"
                                            wire:model="button_text">

                                        @error('button_text')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- Link Type --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <label class="form-label">
                                            Link Type
                                        </label>

                                        <select
                                            class="form-select rounded-pill"
                                            wire:model.live="link_type">

                                            <option value="custom">
                                                Custom URL
                                            </option>

                                            <option value="project">
                                                Project
                                            </option>

                                        </select>
                                    </div>

                                    {{-- Custom URL --}}
                                    @if ($link_type === 'custom')
                                        <div class="col-xxl-6 col-md-12">
                                            <label class="form-label">
                                                Button URL
                                            </label>

                                            <input
                                                type="text"
                                                class="form-control rounded-pill @error('button_link') is-invalid @enderror"
                                                placeholder="https://example.com"
                                                wire:model="button_link">

                                            @error('button_link')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif

                                    {{-- Project --}}
                                    @if ($link_type === 'project')
                                        <div class="col-xxl-6 col-md-12">
                                            <label class="form-label">
                                                Select Project
                                            </label>

                                            <select
                                                class="form-select rounded-pill @error('project_id') is-invalid @enderror"
                                                wire:model="project_id">

                                                <option value="">
                                                    Select Project
                                                </option>

                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}">
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            @error('project_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif

                                </div>

                            </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2 flex-wrap">

                                    <a href="{{ route('home-sliders.index') }}"
                                        class="btn btn-light">
                                        Cancel
                                    </a>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        wire:loading.attr="disabled">

                                        <i class="ri-save-line align-bottom me-1"></i>

                                        {{ $isEdit ? 'Update' : 'Save & Continue' }}
                                    </button>

                                    @if (!$isEdit)
                                        <button
                                            type="button"
                                            class="btn btn-success"
                                            wire:click="saveAndNew"
                                            wire:loading.attr="disabled">

                                            <i class="ri-add-line align-bottom me-1"></i>

                                            Save & Add New
                                        </button>
                                    @endif

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>
</div>