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
                                         <input type="text" class="form-control @error('father_husband_name') is-invalid @enderror" wire:model="father_husband_name">
                                         @error('father_husband_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             PAN Number <span class="text-danger">*</span>
                                         </label>
                                         <input type="text" class="form-control text-uppercase @error('pan_number') is-invalid @enderror" wire:model="pan_number" maxlength="10">
                                         @error('pan_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                         <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model="phone" maxlength="10">
                                         @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Gender <span class="text-danger">*</span>
                                         </label>
                                         <select class="form-select @error('gender') is-invalid @enderror" wire:model="gender">
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
                                         @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Date Of Birth <span class="text-danger">*</span>
                                         </label>
                                         <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" wire:model="date_of_birth">
                                         @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Occupation <span class="text-danger">*</span>
                                         </label>
                                         <select class="form-select @error('occupation') is-invalid @enderror" wire:model="occupation">
                                             <option value="">Select Occupation</option>
                                             @foreach(config('constants.occupations') as $key => $lbl)
                                                 <option value="{{ $key }}">{{ $lbl }}</option>
                                             @endforeach
                                         </select>
                                         @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Flat Size <span class="text-danger">*</span>
                                         </label>
                                         <select class="form-select @error('flat_size') is-invalid @enderror" wire:model="flat_size">
                                             <option value="">Select Flat Size</option>
                                             <option value="1 BHK">1 BHK</option>
                                             <option value="2 BHK">2 BHK</option>
                                             <option value="3 BHK">3 BHK</option>
                                         </select>
                                         @error('flat_size') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-12">
                                         <label class="form-label">
                                             Address <span class="text-danger">*</span>
                                         </label>
                                         <textarea class="form-control @error('address') is-invalid @enderror" rows="3" wire:model="address"></textarea>
                                         @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             State <span class="text-danger">*</span>
                                         </label>
                                         <div wire:ignore wire:key="state-container-{{ $state_id }}">
                                             <select id="state-select" class="form-select @error('state_id') is-invalid @enderror" wire:model.blur="state_id">
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
                                         @error('state_id') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             City <span class="text-danger">*</span>
                                         </label>
                                         <div wire:ignore wire:key="city-container-{{ $state_id }}-{{ $city_id }}-{{ count($cities) }}">
                                             <select id="city-select" class="form-select @error('city_id') is-invalid @enderror" wire:model.blur="city_id">
                                                 <option value="">Select City</option>
                                                 @foreach($cities as $c)
                                                     <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                         @error('city_id') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Co Applicant
                                         </label>
                                         <input type="text" class="form-control @error('co_applicant_name') is-invalid @enderror" wire:model="co_applicant_name">
                                         @error('co_applicant_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                     </div>
                                     <div class="col-md-6">
                                         <label class="form-label">
                                             Waiver Code
                                         </label>
                                         <input type="text" class="form-control @error('waiver_code') is-invalid @enderror" wire:model="waiver_code">
                                         @error('waiver_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                <div class="mb-3">
                                    <label class="form-label">
                                        Payment Status
                                    </label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror" wire:model="payment_status">
                                        @foreach(config('constants.payment_statuses') as $key => $lbl)
                                            <option value="{{ $key }}">
                                                {{ $lbl }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Fix Select2 height & styling to match bootstrap 5 in Velzon theme */
            .select2-container--default .select2-selection--single {
                height: 38px !important;
                border: 1px solid #ced4da !important;
                border-radius: 0.25rem !important;
                padding: 6px 12px !important;
                display: flex;
                align-items: center;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                padding-left: 0 !important;
                color: #212529 !important;
            }
            .select2-container {
                width: 100% !important;
            }
        </style>
    @endpush

    @push('scripts')
        <!--jquery cdn-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--select2 cdn-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            function initSelect2() {
                // State Select2
                const stateSelect = $('#state-select');
                if (stateSelect.length) {
                    if (stateSelect.hasClass("select2-hidden-accessible")) {
                        stateSelect.select2('destroy');
                    }
                    stateSelect.select2({
                        placeholder: "Select State",
                        allowClear: false
                    }).on('change', function (e) {
                        let val = $(this).val();
                        if (String(val || '') !== String(@this.state_id || '')) {
                            @this.set('state_id', val);
                        }
                    });
                }

                // City Select2
                const citySelect = $('#city-select');
                if (citySelect.length) {
                    if (citySelect.hasClass("select2-hidden-accessible")) {
                        citySelect.select2('destroy');
                    }
                    citySelect.select2({
                        placeholder: "Select City",
                        allowClear: false
                    }).on('change', function (e) {
                        let val = $(this).val();
                        if (String(val || '') !== String(@this.city_id || '')) {
                            @this.set('city_id', val);
                        }
                    });
                }
            }

            $(document).ready(function () {
                initSelect2();

                // Auto-focus search text box on open
                $(document).on('select2:open', () => {
                    setTimeout(() => {
                        const searchField = document.querySelector('.select2-search__field');
                        if (searchField) {
                            searchField.focus();
                        }
                    }, 50);
                });
            });

            document.addEventListener('livewire:init', () => {
                Livewire.hook('request', ({ fail, respond, succeed }) => {
                    succeed(({ status, response }) => {
                        setTimeout(() => {
                            initSelect2();
                        }, 50);
                    });
                });
            });
        </script>
    @endpush
</div>