<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">
                            <a href="{{ route('deals.index') }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line align-bottom"></i> Back to Deals
                            </a>
                            Deal Details
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('deals.index') }}">Deals</a>
                                </li>
                                <li class="breadcrumb-item active">View</li>
                            </ol>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Allotment Details</h4>
                            @if($deal->allotted_inventory_id)
                                <div>
                                    <a href="{{ route('deals.allotment-letter', $deal->id) }}" class="btn btn-success me-2" target="_blank">
                                        <i class="ri-file-download-line align-middle me-1"></i> Allotment Letter
                                    </a>
                                    <a href="{{ route('deals.demand-letter', $deal->id) }}" class="btn btn-warning" target="_blank">
                                        <i class="ri-file-download-line align-middle me-1"></i> Demand Letter
                                    </a>
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
                                                <strong>Flat Number {{ $deal->allottedInventory->flat_no }}</strong> (Floor: {{ $deal->allottedInventory->floor }}, Type: {{ $deal->allottedInventory->flat_type }})
                                            @else
                                                <strong>Plot Number {{ $deal->allottedInventory?->plot_no }}</strong> (Area: {{ $deal->allottedInventory?->area_sq_yards }} Sq. Yards)
                                            @endif
                                            in project <strong>{{ $deal->project?->name }}</strong>.
                                        </p>
                                        <p class="mb-0 text-muted fs-13 mt-1">
                                            Booking Date: {{ $deal->booking_date ? $deal->booking_date->format('d M Y h:i A') : '-' }} | Booking Amount: ₹{{ number_format($deal->booking_amount, 2) }} | Total Value: ₹{{ number_format($deal->total_amount, 2) }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <button class="btn btn-danger" 
                                                wire:click="cancelAllotment" 
                                                wire:loading.attr="disabled"
                                                wire:target="cancelAllotment"
                                                wire:confirm="Are you sure you want to cancel this unit allotment? This will return the unit to Available status.">
                                            <span wire:loading.remove wire:target="cancelAllotment">
                                                <i class="ri-close-circle-line me-1"></i> Cancel Allotment
                                            </span>
                                            <span wire:loading wire:target="cancelAllotment">
                                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                Cancelling Allotment...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @else
                                {{-- Unit not allotted yet, show available inventories --}}
                                <div class="alert alert-warning mb-3">
                                    <i class="ri-alert-line align-middle me-2"></i> No unit has been allotted to this customer yet. Choose an available unit below to proceed with allotment.
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-center align-middle mb-0">
                                        <thead class="table-light">
                                            @if($deal->project?->inventory_type === 'flat')
                                                <tr>
                                                    <th>Floor</th>
                                                    <th>Flat No.</th>
                                                    <th>Flat Type</th>
                                                    <th>Unit Type</th>
                                                    <th>Area (SBUP)</th>
                                                    <th>Carpet Area</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            @else
                                                <tr>
                                                    <th>Plot No.</th>
                                                    <th>Area (Sq. Yards)</th>
                                                    <th>Road Size</th>
                                                    <th>PLC %</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @forelse($inventories as $unit)
                                                @if($deal->project?->inventory_type === 'flat')
                                                    <tr>
                                                        <td>{{ $unit->floor }}</td>
                                                        <td class="fw-semibold">{{ $unit->flat_no }}</td>
                                                        <td>{{ $unit->flat_type }}</td>
                                                        <td>{{ $unit->unit_type }}</td>
                                                        <td>{{ $unit->area_sbup }}</td>
                                                        <td>{{ $unit->carpet_area }}</td>
                                                        <td class="text-end fw-semibold">₹ {{ number_format($unit->price, 2) }}</td>
                                                        <td>
                                                            @if($unit->status === 'Available')
                                                                <span class="badge bg-success">Available</span>
                                                            @else
                                                                <span class="badge bg-danger">{{ $unit->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($unit->status === 'Available')
                                                                <button class="btn btn-sm btn-success px-3" 
                                                                        wire:click="allotInventory('{{ $unit->id }}')" 
                                                                        wire:loading.attr="disabled"
                                                                        wire:target="allotInventory"
                                                                        wire:confirm="Are you sure you want to allot Flat {{ $unit->flat_no }} to this customer? An allotment letter will be sent automatically.">
                                                                    <span wire:loading.remove wire:target="allotInventory('{{ $unit->id }}')">
                                                                        Allot Unit
                                                                    </span>
                                                                    <span wire:loading wire:target="allotInventory('{{ $unit->id }}')">
                                                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                                        Sending Letter...
                                                                    </span>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-light disabled px-3" disabled>Not Available</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td class="fw-semibold">{{ $unit->plot_no }}</td>
                                                        <td>{{ $unit->area_sq_yards }} Sq. Yards</td>
                                                        <td>{{ $unit->road_size }}</td>
                                                        <td>{{ $unit->plc_percentage ? $unit->plc_percentage . '%' : '-' }}</td>
                                                        <td class="text-end fw-semibold">₹ {{ number_format($unit->price, 2) }}</td>
                                                        <td>
                                                            @if($unit->status === 'Available')
                                                                <span class="badge bg-success">Available</span>
                                                            @else
                                                                <span class="badge bg-danger">{{ $unit->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($unit->status === 'Available')
                                                                <button class="btn btn-sm btn-success px-3" 
                                                                        wire:click="allotInventory('{{ $unit->id }}')" 
                                                                        wire:loading.attr="disabled"
                                                                        wire:target="allotInventory"
                                                                        wire:confirm="Are you sure you want to allot Plot {{ $unit->plot_no }} to this customer? An allotment letter will be sent automatically.">
                                                                    <span wire:loading.remove wire:target="allotInventory('{{ $unit->id }}')">
                                                                        Allot Unit
                                                                    </span>
                                                                    <span wire:loading wire:target="allotInventory('{{ $unit->id }}')">
                                                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                                        Sending Letter...
                                                                    </span>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-light disabled px-3" disabled>Not Available</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted py-4">No inventory units defined for this project.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
