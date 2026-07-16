<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('agents.index') }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line"></i>
                            </a>
                            <h4 class="mb-sm-0">
                                {{ $agent && $agent->exists ? 'Edit Agent' : 'Add New Agent' }}
                            </h4>
                        </div>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
                                <li class="breadcrumb-item active">
                                    {{ $agent && $agent->exists ? 'Edit' : 'Create' }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <form wire:submit="save">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Agent Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    {{-- Name --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="Enter agent name" wire:model="name">
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="Enter email address" wire:model="email">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Phone / Mobile Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                            placeholder="Enter phone number" wire:model="phone">
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Waiver Code --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Waiver Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                                placeholder="Enter 8-digit Waiver Code" wire:model="code" maxlength="8" style="text-transform: uppercase;">
                                            <button class="btn btn-outline-secondary" type="button" wire:click="generateCode">
                                                <i class="ri-refresh-line me-1"></i> Auto-generate
                                            </button>
                                        </div>
                                        <small class="text-muted">An 8-digit unique alphanumeric code to identify the agent on Booking / Lead forms.</small>
                                        @error('code') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Commission & Status Sidebar --}}
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Commission & Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    {{-- Commission Type --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Commission Type <span class="text-danger">*</span></label>
                                        <select class="form-select @error('commission_type') is-invalid @enderror" wire:model="commission_type">
                                            <option value="percentage">Percentage (%)</option>
                                            <option value="fixed">Fixed Amount (₹)</option>
                                        </select>
                                        @error('commission_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Commission Value --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Commission Value <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            @if($commission_type === 'percentage')
                                                <span class="input-group-text">%</span>
                                            @else
                                                <span class="input-group-text">₹</span>
                                            @endif
                                            <input type="number" step="0.01" class="form-control @error('commission_value') is-invalid @enderror" 
                                                placeholder="0.00" wire:model="commission_value">
                                        </div>
                                        @error('commission_value') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-12">
                                        <label class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <hr>

                                    <div class="col-md-12 d-grid">
                                        <button type="submit" class="btn btn-success">
                                            <i class="ri-save-line me-1"></i> Save Agent
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
