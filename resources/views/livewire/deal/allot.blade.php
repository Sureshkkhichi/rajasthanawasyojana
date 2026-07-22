<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">
                            <a href="{{ route('deals.show', $deal->id) }}" class="btn btn-soft-secondary btn-sm me-3">
                                <i class="ri-arrow-left-line align-bottom"></i> Back to Deal Details
                            </a>
                            Allot Unit
                        </h4>
                        <div class="page-title-right d-flex gap-2">
                            <span class="badge bg-light text-primary border border-primary fs-12 px-3 py-2">
                                Customer: {{ $deal->first_name }} {{ $deal->last_name }} (Project: {{ $project?->name }})
                            </span>
                            @if($deal->booking_amount > 0)
                                <span class="badge bg-success-subtle text-success border border-success fs-12 px-3 py-2">
                                    <i class="ri-wallet-3-line align-bottom me-1"></i> Booking Amount: ₹{{ number_format($deal->booking_amount, 2) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary/Counts KPI Cards --}}
            <div class="row">
                {{-- Total Units --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-primary">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-11">Total {{ $inventoryTypeLabel }}s</p>
                                    <h4 class="mb-0 fw-bold">{{ $counts['total'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3">
                                        <i class="ri-building-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Available Units --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-success">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-11">Available {{ $inventoryTypeLabel }}s</p>
                                    <h4 class="mb-0 fw-bold">{{ $counts['available'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hold Units --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-warning">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-11">Hold {{ $inventoryTypeLabel }}s</p>
                                    <h4 class="mb-0 fw-bold">{{ $counts['hold'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-3">
                                        <i class="ri-time-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sold Units --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-danger">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-11">Sold {{ $inventoryTypeLabel }}s</p>
                                    <h4 class="mb-0 fw-bold">{{ $counts['sold'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-3">
                                        <i class="ri-close-circle-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alloted Units --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-info">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-semibold text-muted mb-1 fs-11">Alloted {{ $inventoryTypeLabel }}s</p>
                                    <h4 class="mb-0 fw-bold">{{ $counts['alloted'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-3">
                                        <i class="ri-award-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-end">
                        {{-- Project Label (Readonly badge style) --}}
                        <div class="{{ $isFlat ? 'col-md-4' : 'col-md-5' }}">
                            <label class="form-label text-muted fw-bold mb-1.5"><i class="ri-building-4-line me-1"></i>Project</label>
                            <input type="text" class="form-control border-light-subtle bg-light text-dark fw-semibold" value="{{ $project?->name }}" readonly>
                        </div>

                        {{-- Status Filter --}}
                        <div class="{{ $isFlat ? 'col-md-2' : 'col-md-3' }}">
                            <label class="form-label text-muted fw-bold mb-1.5"><i class="ri-filter-2-line me-1"></i>Status</label>
                            <select class="form-select border-light-subtle shadow-sm" wire:model.live="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="Available">Available</option>
                                <option value="Hold">Hold</option>
                                <option value="Sold">Sold</option>
                                <option value="Alloted">Alloted</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        {{-- Unit Type Filter (Flat projects only) --}}
                        @if ($isFlat)
                            <div class="col-md-3">
                                <label class="form-label text-muted fw-bold mb-1.5"><i class="ri-layout-grid-line me-1"></i>Unit Type</label>
                                <select class="form-select border-light-subtle shadow-sm" wire:model.live="facingFilter">
                                    <option value="">All Unit Types</option>
                                    @foreach($facingTypes as $facing)
                                        <option value="{{ $facing }}">{{ $facing }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        {{-- Search Input --}}
                        <div class="{{ $isFlat ? 'col-md-3' : 'col-md-4' }}">
                            <label class="form-label text-muted fw-bold mb-1.5"><i class="ri-search-line me-1"></i>Search Unit</label>
                            <div class="input-group shadow-sm">
                                <input type="text" class="form-control border-light-subtle" placeholder="{{ $isFlat ? 'Search Flat No...' : 'Search Plot No...' }}" wire:model.live.debounce.300ms="searchPlot">
                                <span class="input-group-text bg-light border-light-subtle text-muted"><i class="ri-search-line"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-center text-nowrap table-borderless">
                            <thead class="text-muted table-light uppercase fs-11">
                                @if($isFlat)
                                    <tr>
                                        <th>Floor</th>
                                        <th>Flat No.</th>
                                        <th>Unit Type</th>
                                        <th>Area (SBUP)</th>
                                        <th>Carpet Area</th>
                                        <th>Super Buildup Area</th>
                                        <th>Price (₹)</th>
                                        <th>Status</th>
                                        <th width="120">Action</th>
                                    </tr>
                                @else
                                    <tr>
                                        <th>Plot No.</th>
                                        <th>Area (Sq. Yards)</th>
                                        <th>Road Size</th>
                                        <th>PLC %</th>
                                        <th>Price (₹)</th>
                                        <th>Status</th>
                                        <th width="120">Action</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody>
                                @forelse($units as $unit)
                                    <tr wire:key="unit-row-{{ $unit->id }}">
                                        @if($isFlat)
                                            <td>{{ $unit->floor }}</td>
                                            <td class="fw-bold text-dark">{{ $unit->flat_no }}</td>
                                            <td><span class="badge bg-light text-secondary border border-light-subtle rounded px-2 py-1 fs-11">{{ $unit->unit_type }}</span></td>
                                            <td>{{ number_format($unit->area_sbup, 2) }}</td>
                                            <td>{{ number_format($unit->carpet_area, 2) }}</td>
                                            <td>{{ number_format($unit->super_buildup_area, 2) }}</td>
                                        @else
                                            <td class="fw-bold text-dark">{{ $unit->plot_no }}</td>
                                            <td>{{ number_format($unit->area_sq_yards, 2) }}</td>
                                            <td>{{ $unit->road_size }}</td>
                                            <td>{{ $unit->plc_percentage !== null ? $unit->plc_percentage . '%' : '-' }}</td>
                                        @endif
                                        <td class="text-end fw-semibold text-dark">₹ {{ number_format($unit->price, 0) }}</td>
                                        <td>
                                            @if($unit->status === 'Available')
                                                <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1 fs-11">Available</span>
                                            @elseif($unit->status === 'Hold')
                                                <span class="badge bg-warning-subtle text-warning rounded-pill px-2.5 py-1 fs-11">Hold</span>
                                            @elseif($unit->status === 'Sold')
                                                <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1 fs-11">Sold</span>
                                            @elseif($unit->status === 'Alloted')
                                                <span class="badge bg-info-subtle text-info rounded-pill px-2.5 py-1 fs-11">Alloted</span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fs-11">{{ $unit->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($unit->status === 'Available')
                                                <button class="btn btn-sm btn-success px-3 fs-11 py-1.5" 
                                                        wire:click="allotInventory('{{ $unit->id }}')" 
                                                        wire:loading.attr="disabled"
                                                        wire:confirm="Are you sure you want to allot this unit ({{ $isFlat ? 'Flat ' . $unit->flat_no : 'Plot ' . $unit->plot_no }}) to {{ $deal->first_name }} {{ $deal->last_name }}?">
                                                    Allot Unit
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-light disabled px-3 fs-11 py-1.5" disabled>Not Available</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4 fs-13">No units found matching the criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Footer --}}
                    @if($units->hasPages())
                        <div class="d-flex justify-content-between align-items-center p-3 border-top border-light">
                            <span class="text-muted fs-12">
                                Showing {{ $units->firstItem() }} to {{ $units->lastItem() }} of {{ $units->total() }} units
                            </span>
                            <div>
                                {{ $units->links() }}
                            </div>
                        </div>
                    @endif
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
