<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">{{ $inventory ? 'Edit Unit' : 'Add Unit' }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventory</a>
                                </li>
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
                                        <select class="form-select @error('project_id') is-invalid @enderror"
                                            wire:model.live="project_id" @disabled($inventory && $inventory->exists)>
                                            <option value="">Select Project</option>
                                            @foreach($projects as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}
                                                    ({{ $p->inventory_type === 'flat' ? 'Flat' : 'Plot' }}) -
                                                    {{ $p->registration_status === 'open' ? 'Registration Open' : 'Registration Closed' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('project_id') <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Inventory Type badge --}}
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="mb-2">
                                            <span
                                                class="badge {{ $inventory_type === 'flat' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success' }} text-uppercase fs-12 px-3 py-2 border border-{{ $inventory_type === 'flat' ? 'info' : 'success' }}-subtle">
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
                                            <input type="text" class="form-control @error('plot_no') is-invalid @enderror"
                                                wire:model="plot_no" placeholder="e.g., F-01">
                                            @error('plot_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Area (Sq. Yards) <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('area_sq_yards') is-invalid @enderror"
                                                wire:model.live="area_sq_yards" placeholder="e.g., 357.77">
                                            @error('area_sq_yards') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Road Size <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('road_size') is-invalid @enderror"
                                                wire:model="road_size" placeholder="e.g., 100' or 40'">
                                            @error('road_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">PLC %</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01"
                                                    class="form-control @error('plc_percentage') is-invalid @enderror"
                                                    wire:model.live="plc_percentage" placeholder="e.g., 10">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            @error('plc_percentage') <div class="text-danger fs-12 mt-1">{{ $message }}
                                            </div> @enderror
                                        </div>

                                    @else
                                        {{-- =================================== --}}
                                        {{-- FLAT FIELDS --}}
                                        {{-- =================================== --}}
                                        <h6 class="fw-semibold text-muted text-uppercase mb-3">Flat Details</h6>

                                        <div class="col-md-4">
                                            <label class="form-label">Floor <span class="text-danger">*</span></label>
                                            <select class="form-select @error('floor') is-invalid @enderror"
                                                wire:model="floor">
                                                <option value="">Select Floor</option>
                                                <option value="Ground Floor">Ground Floor</option>
                                                <option value="1st Floor">1st Floor</option>
                                                <option value="2nd Floor">2nd Floor</option>
                                                <option value="3rd Floor">3rd Floor</option>
                                                <option value="4th Floor">4th Floor</option>
                                                <option value="5th Floor">5th Floor</option>
                                                <option value="6th Floor">6th Floor</option>
                                                <option value="7th Floor">7th Floor</option>
                                                <option value="8th Floor">8th Floor</option>
                                                <option value="9th Floor">9th Floor</option>
                                                <option value="10th Floor">10th Floor</option>
                                                <option value="11th Floor">11th Floor</option>
                                                <option value="12th Floor">12th Floor</option>
                                                <option value="13th Floor">13th Floor</option>
                                                <option value="14th Floor">14th Floor</option>
                                                <option value="15th Floor">15th Floor</option>
                                            </select>
                                            @error('floor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Flat No. <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('flat_no') is-invalid @enderror"
                                                wire:model="flat_no" placeholder="e.g., 101">
                                            @error('flat_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Unit Type <span class="text-danger">*</span></label>
                                            <select class="form-select @error('unit_type') is-invalid @enderror"
                                                wire:model="unit_type">
                                                <option value="">Select Unit Type</option>
                                                <option value="EWS">EWS (1BHK)</option>
                                                <option value="LIG">LIG (2BHK)</option>
                                                <option value="3BHK">3BHK</option>
                                                <option value="4BHK">4BHK</option>
                                                <option value="5BHK">5BHK</option>
                                            </select>
                                            @error('unit_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Area (SBUP) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('area_sbup') is-invalid @enderror"
                                                wire:model="area_sbup" placeholder="e.g., 350">
                                            @error('area_sbup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Carpet Area <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('carpet_area') is-invalid @enderror"
                                                wire:model="carpet_area" placeholder="e.g., 260">
                                            @error('carpet_area') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Super Buildup Area <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" step="0.01"
                                                class="form-control @error('super_buildup_area') is-invalid @enderror"
                                                wire:model="super_buildup_area" placeholder="e.g., 380">
                                            @error('super_buildup_area') <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <hr class="my-4">
                                    <h6 class="fw-semibold text-muted text-uppercase mb-3">Pricing & Status</h6>

                                    {{-- Price --}}
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Price (₹) <span class="text-danger">*</span>
                                            @if($inventory_type === 'plot')
                                                <span class="badge bg-secondary-subtle text-secondary ms-1 fs-11">Auto-Calculated (Read-Only)</span>
                                            @endif
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" step="0.01"
                                                class="form-control @error('price') is-invalid @enderror"
                                                wire:model="price" placeholder="{{ $inventory_type === 'plot' ? 'Auto-calculated from area & rate' : 'e.g., 3500000' }}"
                                                @if($inventory_type === 'plot') readonly @endif>
                                        </div>
                                        @if($inventory_type === 'plot')
                                            <small class="text-muted fs-11 mt-1 d-block">
                                                <i class="ri-calculator-line text-primary me-1"></i>Project Rate: <strong>₹{{ number_format((float)($project_rate ?? 0), 2) }} / sq.yd</strong> × Area (<strong>{{ $area_sq_yards ?: '0' }} sq.yd</strong>)
                                                @if(!empty($plc_percentage) && (float)$plc_percentage > 0)
                                                    + <strong>{{ $plc_percentage }}% PLC</strong>
                                                @endif
                                            </small>
                                        @endif
                                        @error('price') <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-6">
                                        <label
                                            class="form-label">{{ $inventory_type === 'flat' ? 'Flat Status' : 'Plot Status' }}
                                            <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror"
                                            wire:model="status">
                                            <option value="Available">Available</option>
                                            <option value="Hold">Hold</option>
                                            <option value="Sold">Sold</option>
                                            <option value="Alloted">Alloted</option>
                                            <option value="Blocked">Blocked</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Remarks --}}
                                    <div class="col-12">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control" rows="3" wire:model="remarks"
                                            placeholder="Enter remarks (optional)"></textarea>
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