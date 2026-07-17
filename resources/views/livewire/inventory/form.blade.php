<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('inventories.index') }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line"></i>
                            </a>
                            <h4 class="mb-sm-0">
                                {{ $inventory && $inventory->exists ? 'Edit Unit' : 'Add Unit' }}
                            </h4>
                        </div>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventory</a></li>
                                <li class="breadcrumb-item active">
                                    {{ $inventory && $inventory->exists ? 'Edit' : 'Create' }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Layout --}}
            <form wire:submit="save">
                <div class="row">
                    {{-- Form Fields Panel --}}
                    <div class="col-lg-8">
                        {{-- Project Selection --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Project Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-8">
                                        <label class="form-label">Project <span class="text-danger">*</span></label>
                                        <select class="form-select @error('project_id') is-invalid @enderror" wire:model.live="project_id">
                                            <option value="">Select Project</option>
                                            @foreach($projects as $p)
                                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label text-muted d-block fs-12">Inventory Type</label>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded fs-13">
                                                {{ $this->inventory_type }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Plot Details Tab Layout --}}
                        <div class="card mb-3">
                            <div class="card-header border-bottom-0 pb-0">
                                <h5 class="card-title mb-0">Plot Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    {{-- Plot No --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Plot No. <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('plot_no') is-invalid @enderror" 
                                            placeholder="e.g., F-24" wire:model="plot_no">
                                        @error('plot_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Area --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Area (Sq. Yards) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" 
                                            placeholder="e.g., 200" wire:model="area">
                                        @error('area') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Road Size --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Road Size <span class="text-danger">*</span></label>
                                        <select class="form-select @error('road_size') is-invalid @enderror" wire:model="road_size">
                                            <option value="">Select Road Size</option>
                                            <option value="30'">30'</option>
                                            <option value="40'">40'</option>
                                            <option value="40'X60'">40'X60'</option>
                                            <option value="50'">50'</option>
                                            <option value="60'">60'</option>
                                            <option value="60'X80'">60'X80'</option>
                                            <option value="80'">80'</option>
                                            <option value="100'">100'</option>
                                            <option value="100'X40'">100'X40'</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('road_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- PLC % --}}
                                    <div class="col-md-4">
                                        <label class="form-label">PLC %</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" class="form-control @error('plc_percentage') is-invalid @enderror" 
                                                placeholder="e.g., 10" wire:model="plc_percentage">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        @error('plc_percentage') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Facing --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Facing / Property Type</label>
                                        <select class="form-select @error('facing_type') is-invalid @enderror" wire:model="facing_type">
                                            <option value="">Select Facing</option>
                                            <option value="Corner">Corner</option>
                                            <option value="Park Facing">Park Facing</option>
                                            <option value="North Facing">North Facing</option>
                                            <option value="South Facing">South Facing</option>
                                            <option value="East Facing">East Facing</option>
                                            <option value="West Facing">West Facing</option>
                                            <option value="Main Road">Main Road</option>
                                            <option value="Garden Facing">Garden Facing</option>
                                            <option value="Open Plot">Open Plot</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        @error('facing_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Length --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Length (FT)</label>
                                        <input type="number" step="0.01" class="form-control @error('length') is-invalid @enderror" 
                                            placeholder="e.g., 25" wire:model="length">
                                        @error('length') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Breadth --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Breadth (FT)</label>
                                        <input type="number" step="0.01" class="form-control @error('breadth') is-invalid @enderror" 
                                            placeholder="e.g., 40" wire:model="breadth">
                                        @error('breadth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Shape --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Shape</label>
                                        <select class="form-select @error('shape') is-invalid @enderror" wire:model="shape">
                                            <option value="">Select Shape</option>
                                            <option value="Rectangle">Rectangle</option>
                                            <option value="Square">Square</option>
                                            <option value="Irregular">Irregular</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('shape') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Remarks --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control @error('remarks') is-invalid @enderror" rows="3" 
                                            placeholder="Enter any remarks (optional)" wire:model="remarks"></textarea>
                                        @error('remarks') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pricing & Status --}}
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Pricing & Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    {{-- Price --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Price (₹) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                            placeholder="e.g., 1250000" wire:model="price">
                                        @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Price in Words --}}
                                    <div class="col-md-8">
                                        <label class="form-label">Price (In Words)</label>
                                        <input type="text" class="form-control @error('price_in_words') is-invalid @enderror" 
                                            placeholder="e.g., Twelve Lakh Fifty Thousand Only" wire:model="price_in_words">
                                        @error('price_in_words') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Cost Price --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Cost Price (₹)</label>
                                        <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror" 
                                            placeholder="e.g., 1000000" wire:model="cost_price">
                                        @error('cost_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Current Status --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Current Status <span class="text-danger">*</span></label>
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

                                    {{-- Status Effective From --}}
                                    <div class="col-md-4">
                                        <label class="form-label">Status Effective From <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('status_effective_from') is-invalid @enderror" 
                                            wire:model="status_effective_from">
                                        @error('status_effective_from') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Notes --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Notes</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" rows="3" 
                                            placeholder="Enter note (optional)" wire:model="notes"></textarea>
                                        @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Existing Layout Map Preview --}}
                                    @if($existing_map_layout)
                                        <div class="col-md-12">
                                            <div class="border rounded p-2 d-flex align-items-center justify-content-between bg-light">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset($existing_map_layout) }}" style="max-height: 60px;" class="rounded border">
                                                    <span class="fs-13">Layout Map</span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-soft-danger" wire:click="deleteMapLayout">
                                                    <i class="ri-delete-bin-line"></i> Remove Image
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Upload Layout Map --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Unit Map / Layout (Optional)</label>
                                        <input type="file" class="form-control @error('uploaded_map_layout') is-invalid @enderror" 
                                            wire:model="uploaded_map_layout">
                                        <small class="text-muted">Supports: JPG, JPEG, PNG (Max 5MB)</small>
                                        @error('uploaded_map_layout') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Existing Documents --}}
                                    @if(!empty($existing_documents))
                                        <div class="col-md-12">
                                            <label class="form-label">Uploaded Documents</label>
                                            <div class="d-flex flex-column gap-2">
                                                @foreach($existing_documents as $idx => $doc)
                                                    <div class="border rounded p-2 d-flex align-items-center justify-content-between bg-light">
                                                        <span><i class="ri-file-line text-primary"></i> {{ $doc['name'] }}</span>
                                                        <button type="button" class="btn btn-sm btn-soft-danger" wire:click="deleteDocument({{ $idx }})">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Upload Documents --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Upload Documents (Optional)</label>
                                        <input type="file" multiple class="form-control @error('uploaded_documents.*') is-invalid @enderror" 
                                            wire:model="uploaded_documents">
                                        <small class="text-muted">Supports: PDF, DOC, JPG, PNG (Max 5MB each)</small>
                                        @error('uploaded_documents.*') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="card card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('inventories.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-success">
                                    <i class="ri-save-line me-1"></i> Save Unit
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Right Sidebar Help Panel --}}
                    <div class="col-lg-4">
                        <div class="card mb-3 bg-light-subtle">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h5 class="card-title mb-0 fs-13 text-muted text-uppercase">Field Description</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 fs-13">
                                    <li class="mb-3">
                                        <strong>Plot No.:</strong> Unique plot designation (e.g. F-01, F-02).
                                    </li>
                                    <li class="mb-3">
                                        <strong>Area (Sq. Yards):</strong> Total physical size of the unit.
                                    </li>
                                    <li class="mb-3">
                                        <strong>Road Size:</strong> Width of the approach road.
                                    </li>
                                    <li class="mb-3">
                                        <strong>PLC %:</strong> Preferential Location Charges percentage (corners/park facing units).
                                    </li>
                                    <li class="mb-3">
                                        <strong>Facing:</strong> Direction facing (Corner, Park Facing, etc.).
                                    </li>
                                    <li class="mb-3">
                                        <strong>Price:</strong> Total booking list price in Indian Rupees.
                                    </li>
                                    <li>
                                        <strong>Status:</strong> Active sales registration state.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card mb-3 bg-light-subtle">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h5 class="card-title mb-0 fs-13 text-muted text-uppercase">Road Size Options</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-primary border fs-12">30'</span>
                                    <span class="badge bg-light text-primary border fs-12">40'</span>
                                    <span class="badge bg-light text-primary border fs-12">40'X60'</span>
                                    <span class="badge bg-light text-primary border fs-12">50'</span>
                                    <span class="badge bg-light text-primary border fs-12">60'</span>
                                    <span class="badge bg-light text-primary border fs-12">60'X80'</span>
                                    <span class="badge bg-light text-primary border fs-12">80'</span>
                                    <span class="badge bg-light text-primary border fs-12">100'</span>
                                    <span class="badge bg-light text-primary border fs-12">100'X40'</span>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 bg-light-subtle">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h5 class="card-title mb-0 fs-13 text-muted text-uppercase">Facing Options</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-light text-success border fs-12">Corner</span>
                                    <span class="badge bg-light text-success border fs-12">Park Facing</span>
                                    <span class="badge bg-light text-success border fs-12">North Facing</span>
                                    <span class="badge bg-light text-success border fs-12">South Facing</span>
                                    <span class="badge bg-light text-success border fs-12">East Facing</span>
                                    <span class="badge bg-light text-success border fs-12">West Facing</span>
                                    <span class="badge bg-light text-success border fs-12">Main Road</span>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light-subtle">
                            <div class="card-header bg-transparent border-0 pb-0">
                                <h5 class="card-title mb-0 fs-13 text-muted text-uppercase">Status Options</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0 fs-13">
                                    <li class="mb-2"><span class="badge bg-success-subtle text-success">Available</span> Unit is free.</li>
                                    <li class="mb-2"><span class="badge bg-warning-subtle text-warning">Hold</span> Reserved for a period.</li>
                                    <li class="mb-2"><span class="badge bg-danger-subtle text-danger">Booked</span> Booked by client.</li>
                                    <li><span class="badge bg-info-subtle text-info">Registered</span> Property registry done.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
