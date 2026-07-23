<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0 d-flex align-items-center">
                            <a href="{{ route('deals.index') }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line align-bottom"></i> Back to Deals
                            </a>
                            Deal Details
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('deals.download-pdf', $deal->id) }}" class="btn btn-soft-primary btn-sm" target="_blank">
                                <i class="ri-file-download-line align-middle me-1"></i> Download Deal
                            </a>
                            @if(empty($deal->allotted_inventory_id))
                                <a href="{{ route('deals.allot', $deal->id) }}" class="btn btn-success btn-sm">
                                    <i class="ri-add-box-line align-middle me-1"></i> Allot Unit
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Personal Information --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Personal Information</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="200">First Name</th>
                                    <td>{{ $deal->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td>{{ $deal->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Father / Husband Name</th>
                                    <td>{{ $deal->father_husband_name ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>PAN Number</th>
                                    <td>{{ $deal->pan_number }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($deal->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Date Of Birth</th>
                                    <td>{{ $deal->date_of_birth ? $deal->date_of_birth->format('d M Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td>{{ $deal->occupation }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Contact & Booking Information</h4>
                        </div>
                        <div class="card-body">
                             <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="200">Project Name</th>
                                    <td class="fw-semibold text-primary">{{ $deal->project?->name ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile Number</th>
                                    <td>{{ $deal->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $deal->email }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $deal->address }}</td>
                                </tr>
                                <tr>
                                    <th>State / City</th>
                                    <td>{{ $deal->state_name }} / {{ $deal->city }}</td>
                                </tr>
                                <tr>
                                    <th>Selected Flat Size / Area</th>
                                    <td><span class="badge bg-info px-2 py-1 fs-12">{{ $deal->flat_size }}</span></td>
                                </tr>
                                <tr>
                                    <th>Co-Applicant</th>
                                    <td>{{ $deal->co_applicant_name ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Waiver Code</th>
                                    <td>
                                        @if($deal->agent)
                                            <span class="badge bg-light text-primary border border-primary fs-12">{{ $deal->waiver_code }}</span>
                                            <span class="ms-1 fw-semibold text-secondary">
                                                (Agent: {{ $deal->agent->name }} - 
                                                @if($deal->agent->commission_type === 'percentage')
                                                    {{ number_format($deal->agent->commission_value, 2) }}% Comm.
                                                @else
                                                     ₹{{ number_format($deal->agent->commission_value, 2) }} Comm.
                                                @endif)
                                            </span>
                                        @else
                                            {{ $deal->waiver_code ?: '-' }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Allotment Management Card --}}
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="card-title mb-0">Allotment Details</h4>
                            @if($deal->allotted_inventory_id)
                                <div class="d-flex gap-2 flex-wrap">
                                    <a class="btn btn-success" 
                                       href="{{ route('deals.allotment-letter', $deal->id) }}" 
                                       target="_blank">
                                        <i class="ri-printer-line align-middle me-1"></i> Allotment Letter
                                    </a>
                                    <a class="btn btn-warning" 
                                       href="{{ route('deals.demand-letter', $deal->id) }}" 
                                       target="_blank">
                                        <i class="ri-printer-line align-middle me-1"></i> Demand Letter
                                    </a>
                                    <button class="btn btn-primary" 
                                            wire:click="openEmailModal" 
                                            wire:loading.attr="disabled"
                                            wire:target="openEmailModal, sendSms, cancelAllotment">
                                        <i class="ri-mail-send-line align-middle me-1"></i> Send Email
                                    </button>
                                    <button class="btn btn-info" 
                                            wire:click="sendSms" 
                                            wire:loading.attr="disabled"
                                            wire:target="openEmailModal, sendSms, cancelAllotment">
                                        <i class="ri-message-2-line align-middle me-1"></i> Send SMS
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($deal->allotted_inventory_id)
                                {{-- Unit is allotted --}}
                                <div class="alert alert-success d-flex align-items-center p-4 border border-success mb-0" role="alert">
                                    <i class="ri-checkbox-circle-line text-success fs-24 me-3"></i>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading text-success mb-1 fw-semibold">Unit Allotment Successful!</h5>
                                        <p class="mb-0">
                                            The customer has been allotted 
                                            @if($deal->allottedInventory?->inventory_type === 'flat')
                                                <strong>Flat Number {{ $deal->allottedInventory->flat_no }}</strong> (Floor: {{ $deal->allottedInventory->floor }}, Type: {{ $deal->allottedInventory->unit_type_label }})
                                            @else
                                                <strong>Plot Number {{ $deal->allottedInventory?->plot_no }}</strong> (Type: {{ $deal->allottedInventory->unit_type_label }})
                                            @endif
                                        </p>
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm ms-3" 
                                            wire:click="cancelAllotment"
                                            wire:confirm="Are you sure you want to cancel this unit allotment?"
                                            wire:loading.attr="disabled">
                                        <i class="ri-close-circle-line me-1"></i> Cancel Allotment
                                    </button>
                                </div>
                            @else
                                {{-- Unit not allotted yet, show warning and button to proceed to allotment page --}}
                                <div class="alert alert-warning d-flex align-items-center p-4 border border-warning mb-0" role="alert">
                                    <i class="ri-alert-line text-warning fs-24 me-3"></i>
                                    <div class="flex-grow-1">
                                        <h5 class="alert-heading text-warning mb-1 fw-semibold">No Unit Allotted</h5>
                                        <p class="mb-0">
                                            No flat or plot has been allotted to this customer yet. Click the button to choose an available unit and complete the allotment.
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <a href="{{ route('deals.allot', $deal->id) }}" class="btn btn-warning">
                                            <i class="ri-add-box-line me-1"></i> Proceed to Allot Unit
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Send Email with PDF Selection Modal --}}
    @if($showEmailModal)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 1055;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title text-white d-flex align-items-center">
                            <i class="ri-mail-send-line me-2 fs-18"></i> Send Allotment & Demand Letters Email
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="closeEmailModal"></button>
                    </div>
                    <form wire:submit.prevent="sendEmail">
                        <div class="modal-body p-4">
                            <div class="alert alert-soft-info d-flex align-items-center mb-4" role="alert">
                                <i class="ri-information-line fs-20 me-2"></i>
                                <div>
                                    Please select the <strong>Allotment Letter PDF</strong> and <strong>Demand Letter PDF</strong> saved from your browser print preview to send to the customer.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Customer Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email_recipient') is-invalid @enderror" wire:model="email_recipient" placeholder="Enter customer email address">
                                @error('email_recipient') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                                            <label class="form-label fw-semibold mb-0">
                                                <i class="ri-file-pdf-2-line text-danger me-1"></i> Allotment Letter PDF <span class="text-danger">*</span>
                                            </label>
                                            <a href="{{ route('deals.allotment-letter', $deal->id) }}" target="_blank" class="btn btn-soft-success btn-sm py-1 px-2">
                                                <i class="ri-printer-line me-1"></i> View / Print
                                            </a>
                                        </div>
                                        <input type="file" class="form-control @error('allotment_pdf_file') is-invalid @enderror" wire:model="allotment_pdf_file" accept=".pdf">
                                        <small class="text-muted d-block mt-1 fs-11">
                                            <i class="ri-arrow-right-s-line me-1"></i>Click <strong>View / Print</strong> & save as PDF, then select file here.
                                        </small>
                                        @error('allotment_pdf_file') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        @if($allotment_pdf_file)
                                            <div class="text-success fs-12 mt-2 fw-semibold"><i class="ri-checkbox-circle-fill me-1"></i> {{ $allotment_pdf_file->getClientOriginalName() }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-1">
                                            <label class="form-label fw-semibold mb-0">
                                                <i class="ri-file-pdf-2-line text-danger me-1"></i> Demand Letter PDF <span class="text-danger">*</span>
                                            </label>
                                            <a href="{{ route('deals.demand-letter', $deal->id) }}" target="_blank" class="btn btn-soft-warning btn-sm py-1 px-2">
                                                <i class="ri-printer-line me-1"></i> View / Print
                                            </a>
                                        </div>
                                        <input type="file" class="form-control @error('demand_pdf_file') is-invalid @enderror" wire:model="demand_pdf_file" accept=".pdf">
                                        <small class="text-muted d-block mt-1 fs-11">
                                            <i class="ri-arrow-right-s-line me-1"></i>Click <strong>View / Print</strong> & save as PDF, then select file here.
                                        </small>
                                        @error('demand_pdf_file') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        @if($demand_pdf_file)
                                            <div class="text-success fs-12 mt-2 fw-semibold"><i class="ri-checkbox-circle-fill me-1"></i> {{ $demand_pdf_file->getClientOriginalName() }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light px-4 py-3">
                            <button type="button" class="btn btn-light me-2" wire:click="closeEmailModal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled" wire:target="sendEmail, allotment_pdf_file, demand_pdf_file">
                                <span wire:loading.remove wire:target="sendEmail">
                                    <i class="ri-send-plane-fill me-1"></i> Send Email
                                </span>
                                <span wire:loading wire:target="sendEmail">
                                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                    Sending Email & Attachments...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('swal:alert', (event) => {
                    const data = event[0];
                    Swal.fire({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#405189'
                    });
                });
            });
        </script>
    @endpush
</div>
