<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $inventory ? 'Edit Unit' : 'Add Unit' }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventory</a></li>
                                <li class="breadcrumb-item active">{{ $inventory ? 'Edit' : 'Create' }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Back Button --}}
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('inventories.index') }}" class="btn btn-soft-secondary btn-sm">
                        <i class="ri-arrow-left-line align-middle me-1"></i> Back to Inventory
                    </a>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Unit Details</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit="save">
                                <div class="row g-3">
                                    {{-- Project selection --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Project <span class="text-danger">*</span></label>
                                        <select class="form-select @error('project_id') is-invalid @enderror" wire:model.live="project_id" @disabled($inventory && $inventory->exists)>
                                            <option value="">Select Project</option>
                                            @foreach($projects as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Inventory Type badge --}}
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="mb-2">
                                            <span class="badge {{ $inventory_type === 'flat' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success' }} text-uppercase fs-12 px-3 py-2 border border-{{ $inventory_type === 'flat' ? 'info' : 'success' }}-subtle">
                                                {{ $inventory_type === 'flat' ? 'Flat Project' : 'Plot Project' }}
                                            </span>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    @if ($inventory_type === 'plot')
                                        {{-- =================================== --}}
                                        {{-- PLOT FIELDS --}}
                                        {{-- =================================== --}}
                                        <h6 class="fw-semibold text-muted text-uppercase mb-3">Plot Details</h6>

                                        <div class="col-md-4">
                                            <label class="form-label">Plot No. <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('plot_no') is-invalid @enderror" wire:model="plot_no" placeholder="e.g., F-01">
                                            @error('plot_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Area (Sq. Yards) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('area_sq_yards') is-invalid @enderror" wire:model="area_sq_yards" placeholder="e.g., 357.77">
                                            @error('area_sq_yards') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Road Size <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('road_size') is-invalid @enderror" wire:model="road_size" placeholder="e.g., 100' or 40'">
                                            @error('road_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">PLC %</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" class="form-control @error('plc_percentage') is-invalid @enderror" wire:model="plc_percentage" placeholder="e.g., 10">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            @error('plc_percentage') <div class="text-danger fs-12 mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">PLC Status</label>
                                            <select class="form-select @error('plc_status') is-invalid @enderror" wire:model="plc_status">
                                                <option value="">Select PLC</option>
                                                <option value="Corner">Corner</option>
                                            </select>
                                            @error('plc_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                    @else
                                        {{-- =================================== --}}
                                        {{-- FLAT FIELDS --}}
                                        {{-- =================================== --}}
                                        <h6 class="fw-semibold text-muted text-uppercase mb-3">Flat Details</h6>

                                        <div class="col-md-4">
                                            <label class="form-label">Floor <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('floor') is-invalid @enderror" wire:model="floor" placeholder="e.g., 1st Floor">
                                            @error('floor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Flat No. <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('flat_no') is-invalid @enderror" wire:model="flat_no" placeholder="e.g., 101">
                                            @error('flat_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Type <span class="text-danger">*</span></label>
                                            <select class="form-select @error('flat_type') is-invalid @enderror" wire:model="flat_type">
                                                <option value="">Select Flat Type</option>
                                                <option value="1BHK">1BHK</option>
                                                <option value="2BHK">2BHK</option>
                                                <option value="3BHK">3BHK</option>
                                                <option value="4BHK">4BHK</option>
                                                <option value="EWS">EWS</option>
                                                <option value="LIG">LIG</option>
                                                <option value="MIG">MIG</option>
                                                <option value="HIG">HIG</option>
                                            </select>
                                            @error('flat_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Unit Type <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('unit_type') is-invalid @enderror" wire:model="unit_type" placeholder="e.g., EWS, LIG, General">
                                            @error('unit_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Area (SBUP) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('area_sbup') is-invalid @enderror" wire:model="area_sbup" placeholder="e.g., 350">
                                            @error('area_sbup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Carpet Area <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('carpet_area') is-invalid @enderror" wire:model="carpet_area" placeholder="e.g., 260">
                                            @error('carpet_area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @endif

                                    <hr class="my-4">
                                    <h6 class="fw-semibold text-muted text-uppercase mb-3">Pricing & Status</h6>

                                    {{-- Price --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" wire:model="price" placeholder="e.g., 3500000">
                                        </div>
                                        @error('price') <div class="text-danger fs-12 mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6">
                                        <label class="form-label">{{ $inventory_type === 'flat' ? 'Flat Status' : 'Plot Status' }} <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                            <option value="Available">Available</option>
                                            <option value="Hold">Hold</option>
                                            <option value="Booked">Booked</option>
                                            <option value="Registered">Registered</option>
                                            <option value="Blocked">Blocked</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Remarks --}}
                                    <div class="col-12">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control" rows="3" wire:model="remarks" placeholder="Enter remarks (optional)"></textarea>
                                    </div>

                                    {{-- Submit Buttons --}}
                                    <div class="col-12 text-end mt-4">
                                        <button type="submit" class="btn btn-success">
                                            <i class="ri-save-line align-middle me-1"></i> Save Unit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
