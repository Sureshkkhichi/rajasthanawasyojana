<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">DEALS</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Deals</a></li>
                                <li class="breadcrumb-item active">List</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search Filter Card --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Search Filter</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Search by Name"
                                        wire:model.live.debounce.500ms="search_name">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" placeholder="Search by Mobile"
                                        wire:model.live.debounce.500ms="search_mobile">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" placeholder="Search by Email"
                                        wire:model.live.debounce.500ms="search_email">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Project</label>
                                    <select class="form-select" wire:model.live="project_id">
                                        <option value="">All Projects</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" wire:model.live="status">
                                        <option value="">All Status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                        <option value="Partial">Partial</option>
                                        <option value="Refund">Refund</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mt-1">
                                <div class="col-md-3">
                                    <label class="form-label">City</label>
                                    <select class="form-select" wire:model.live="search_city">
                                        <option value="">All Cities</option>
                                        @foreach($cities as $cityItem)
                                            @if(!empty(trim($cityItem)))
                                                <option value="{{ $cityItem }}">{{ $cityItem }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                 <div class="col-md-3">
                                     <label class="form-label">Flat Size / Area</label>
                                     <select class="form-select" wire:model.live="search_flat_size">
                                         <option value="">All Sizes / Areas</option>
                                         @foreach($flatSizes as $size)
                                             <option value="{{ $size }}">{{ $size }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                                <div class="col-md-3">
                                    <label class="form-label">Enquiry Date</label>
                                    <input type="date" class="form-control" wire:model.live="search_date">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-soft-danger w-100" wire:click="resetFilters">
                                        <i class="ri-refresh-line align-bottom me-1"></i> Reset Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deal List Card --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                                    <i class="ri-add-line fs-16"></i> Add New Deal
                                </button>
                            </div>

                            {{-- Table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0 text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" class="form-check-input" wire:model.live="selectAll">
                                            </th>
                                            <th width="50">#</th>
                                            <th width="100">Action</th>
                                            <th>Name</th>
                                            <th>Property</th>
                                            <th>Waiver Code</th>
                                            <th>Booking Date</th>
                                            <th>Booking Amount</th>
                                            <th>Area</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                     <tbody>
                                         @forelse($deals as $index => $deal)
                                             <tr wire:key="deal-row-{{ $deal->id }}">
                                                 <td>
                                                     <input type="checkbox" class="form-check-input" value="{{ $deal->id }}" wire:model.live="selectedDeals">
                                                 </td>
                                                 <td>{{ $index + 1 }}</td>
                                                 <td>
                                                     <div class="dropdown" onclick="event.stopPropagation();">
                                                         <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                             Action
                                                         </button>
                                                         <ul class="dropdown-menu shadow">
                                                             <li>
                                                                 <button class="dropdown-item py-2" type="button" wire:click="generateInvoice('{{ $deal->id }}')">
                                                                     <i class="ri-file-text-line align-bottom me-2 text-muted"></i> Generate Invoice
                                                                 </button>
                                                             </li>
                                                             <li>
                                                                 <button class="dropdown-item py-2" type="button" wire:click="sendSMS('{{ $deal->id }}')">
                                                                     <i class="ri-message-3-line align-bottom me-2 text-muted"></i> Send SMS
                                                                 </button>
                                                             </li>
                                                             <li>
                                                                 <button class="dropdown-item py-2" type="button" wire:click="sendEmail('{{ $deal->id }}')">
                                                                     <i class="ri-mail-send-line align-bottom me-2 text-muted"></i> Send Email
                                                                 </button>
                                                             </li>
                                                             <li>
                                                                 <button class="dropdown-item py-2" type="button" wire:click="viewFullForm('{{ $deal->id }}')">
                                                                     <i class="ri-fullscreen-line align-bottom me-2 text-muted"></i> View Full Form
                                                                 </button>
                                                             </li>
                                                         </ul>
                                                     </div>
                                                 </td>
                                                 <td class="fw-semibold text-start text-nowrap">{{ $deal->first_name }} {{ $deal->last_name }}</td>
                                                 <td class="text-nowrap">{{ $deal->project?->name ?: '-' }}</td>
                                                 <td>
                                                     @if(!empty($deal->waiver_code))
                                                         <div class="d-flex align-items-center justify-content-center gap-1">
                                                             <span class="badge bg-light text-primary border border-primary fs-13">
                                                                 {{ $deal->waiver_code }}
                                                             </span>
                                                             <button class="btn btn-link p-0 text-muted fs-15 lh-1" type="button" 
                                                                 onclick="copyToClipboard('{{ $deal->waiver_code }}', this)" 
                                                                 title="Copy Waiver Code">
                                                                 <i class="ri-file-copy-line"></i>
                                                             </button>
                                                         </div>
                                                     @else
                                                         -
                                                     @endif
                                                 </td>
                                                 <td class="text-nowrap">{{ $deal->booking_date ? $deal->booking_date->format('Y-m-d H:i:s') : '-' }}</td>
                                                 <td class="text-end text-nowrap">
                                                     @if($deal->booking_amount)
                                                         ₹ {{ number_format($deal->booking_amount, 2) }}
                                                     @else
                                                         ₹
                                                     @endif
                                                 </td>
                                                 <td>{{ $deal->flat_size ?: '-' }}</td>
                                                 <td class="text-end text-nowrap">
                                                     @if($deal->total_amount)
                                                         ₹ {{ number_format($deal->total_amount, 2) }}
                                                     @else
                                                         ₹
                                                     @endif
                                                 </td>
                                                 <td>
                                                     @if($deal->status === 'Paid')
                                                         <span class="badge bg-success px-2 py-1 fs-12">Paid</span>
                                                     @elseif($deal->status === 'Partial')
                                                         <span class="badge bg-warning text-white px-2 py-1 fs-12">Partial</span>
                                                     @elseif($deal->status === 'Refund')
                                                         <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">Refund</span>
                                                     @else
                                                         <span class="badge bg-danger text-white px-2 py-1 fs-12">Unpaid</span>
                                                     @endif
                                                 </td>
                                             </tr>
                                         @empty
                                             <tr>
                                                 <td colspan="11" class="text-center py-4 text-muted">No deals found.</td>
                                             </tr>
                                         @endforelse
                                     </tbody>
                                 </table>
                             </div>
                             <div class="mt-3">
                                 {{ $deals->links() }}
                             </div>
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

            function copyToClipboard(text, buttonElement) {
                navigator.clipboard.writeText(text).then(() => {
                    const icon = buttonElement.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'ri-check-line text-success';
                    buttonElement.setAttribute('title', 'Copied!');
                    
                    setTimeout(() => {
                        icon.className = originalClass;
                        buttonElement.setAttribute('title', 'Copy Waiver Code');
                    }, 1500);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }
        </script>
    @endpush
</div>