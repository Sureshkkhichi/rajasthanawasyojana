<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">
                            {{ $isEdit ? 'Edit Flat' : 'Add Flat' }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('flats.index') }}">Flats</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ $isEdit ? 'Edit Flat' : 'Add New Flat' }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form wire:submit="save">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">
                                    {{ $isEdit ? 'Edit Flat' : 'Add New Flat' }}
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row gy-4">
                                    {{-- Flat Name --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label class="form-label">
                                                Flat Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" placeholder="e.g. 1BHK, 2BHK" wire:model.blur="name" autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Slug --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label class="form-label">
                                                Slug
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control rounded-pill @error('slug') is-invalid @enderror" placeholder="Enter slug" wire:model.live="slug">
                                            @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Status --}}
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label class="form-label">
                                                Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select rounded-pill @error('status') is-invalid @enderror" wire:model="status">
                                                <option value="">Select Status</option>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end gap-2 flex-wrap">
                                    <a href="{{ route('flats.index') }}" class="btn btn-light">Cancel</a>
                                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                        <i class="ri-save-line align-bottom me-1"></i>
                                        {{ $isEdit ? 'Update' : 'Save & Continue' }}
                                    </button>
                                    @if (!$isEdit)
                                        <button type="button" class="btn btn-success" wire:click="saveAndNew" wire:loading.attr="disabled">
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
