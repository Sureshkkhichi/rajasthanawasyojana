<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0 d-flex align-items-center">
                            <a href="{{ route('leads.index') }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line align-bottom"></i> Back
                            </a>
                            {{ $lead && $lead->exists ? 'Edit Lead' : 'Add New Lead' }}
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('leads.index') }}">
                                        Leads
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">
                                    {{ $lead && $lead->exists ? 'Edit' : 'Create' }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif
            <form wire:submit="save">
                <div class="row">
                    {{-- Lead Details --}}
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    Lead Information
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             First Name <span class="text-danger">*</span>
                                         </label>
                                         <input type="text" class="form-control @error('first_name') is-invalid @enderror" wire:model="first_name">
                                         @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Last Name <span class="text-danger">*</span>
                                         </label>
                                         <input type="text" class="form-control @error('last_name') is-invalid @enderror" wire:model="last_name">
                                         @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Father / Husband Name
                                         </label>
                                         <input type="text" class="form-control" wire:model="father_husband_name">
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             PAN Number
                                         </label>
                                         <input type="text" class="form-control" wire:model="pan_number">
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Email <span class="text-danger">*</span>
                                         </label>
                                         <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
                                         @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Mobile <span class="text-danger">*</span>
                                         </label>
                                         <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model="phone">
                                         @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Gender
                                        </label>
                                        <select class="form-select" wire:model="gender">
                                            <option value="">
                                                Select Gender
                                            </option>
                                            <option value="male">
                                                Male
                                            </option>
                                            <option value="female">
                                                Female
                                            </option>
                                            <option value="other">
                                                Other
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Date Of Birth
                                        </label>
                                        <input type="date" class="form-control" wire:model="date_of_birth">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Occupation
                                        </label>
                                        <input type="text" class="form-control" wire:model="occupation">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Flat Size
                                        </label>
                                        <input type="text" class="form-control" wire:model="flat_size">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">
                                            Address
                                        </label>
                                        <textarea class="form-control" rows="3" wire:model="address"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            State
                                        </label>
                                        <select class="form-select" wire:model="state_id">
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
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            City
                                        </label>
                                        <input type="text" class="form-control" wire:model="city">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Co Applicant
                                        </label>
                                        <input type="text" class="form-control" wire:model="co_applicant_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Waiver Code
                                        </label>
                                        <input type="text" class="form-control" wire:model="waiver_code">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Status Card --}}
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    Lead Status
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Current Status
                                    </label>
                                    <select class="form-select" wire:model="status">
                                        @foreach(config('constants.lead_statuses') as $key => $status)
                                            <option value="{{ $key }}">
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                 <div class="mb-3">
                                     <label class="form-label">Project <span class="text-danger">*</span></label>
                                     <select class="form-select @error('project_id') is-invalid @enderror" wire:model="project_id">
                                         <option value="">Select Project</option>
                                         @foreach($projects as $p)
                                             <option value="{{ $p->id }}">{{ $p->name }}</option>
                                         @endforeach
                                     </select>
                                     @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                 </div>
                                 @if($lead && $lead->exists)
                                 <div class="mb-3">
                                     <strong>Created:</strong>
                                     <br>
                                     {{ $lead->created_at?->format('d M Y h:i A') }}
                                 </div>
                                 @endif
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">
                                        <i class="ri-save-line me-1"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>