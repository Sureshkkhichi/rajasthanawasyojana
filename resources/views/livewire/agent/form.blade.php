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
                                                placeholder="Enter 5-digit Waiver Code" wire:model="code" maxlength="5" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            <button class="btn btn-outline-secondary" type="button" wire:click="generateCode">
                                                <i class="ri-refresh-line me-1"></i> Auto-generate
                                            </button>
                                        </div>
                                        <small class="text-muted">A 5-digit unique numeric code to identify the agent on Booking / Lead forms.</small>
                                        @error('code') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Settings Sidebar --}}
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
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
                    </div>div>
                </div>
            </form>
        </div>
    </div>
</div>
