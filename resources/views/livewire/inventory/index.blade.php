<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Inventory</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Inventory</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="card">
                <div class="card-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <label class="form-label text-muted fw-bold">Select Project <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                <select class="form-select" wire:model.live="selectedProjectId">
                                    <option value="">Select Project</option>
                                    @foreach($projects as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                                <span class="badge {{ $inventory_type === 'Flat Project' ? 'bg-info-subtle text-info' : 'bg-success-subtle text-success' }} d-flex align-items-center px-3 py-2 border border-{{ $inventory_type === 'Flat Project' ? 'info' : 'success' }}-subtle text-nowrap rounded">
                                    {{ $inventory_type }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label text-muted fw-bold">Status</label>
                            <select class="form-select" wire:model.live="statusFilter">
                                <option value="">All</option>
                                <option value="Available">Available</option>
                                <option value="Hold">Hold</option>
                                <option value="Booked">Booked</option>
                                <option value="Registered">Registered</option>
                                <option value="Blocked">Blocked</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label text-muted fw-bold">{{ $inventory_type === 'Flat Project' ? 'Unit Type' : 'PLC Status' }}</label>
                            <select class="form-select" wire:model.live="facingFilter">
                                <option value="">All</option>
                                @foreach($facingTypes as $facing)
                                    <option value="{{ $facing }}">{{ $facing }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label text-muted fw-bold">&nbsp;</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="{{ $inventory_type === 'Flat Project' ? 'Search Flat No...' : 'Search Plot No...' }}" wire:model.live.debounce.300ms="searchPlot">
                                <span class="input-group-text"><i class="ri-search-line"></i></span>
                            </div>
                        </div>

                        <div class="col-md-3 d-flex gap-2 align-items-end justify-content-end pt-4">
                            <button type="button" class="btn btn-outline-success d-flex align-items-center gap-1" wire:click="openImportModal">
                                <i class="ri-upload-2-line"></i> Import
                            </button>
                            <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-1" wire:click="exportUnits">
                                <i class="ri-download-2-line"></i> Export
                            </button>
                            <a href="{{ route('inventories.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                                <i class="ri-add-line"></i> Add Unit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="row">
                <div class="col-xl-2 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Total Units</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $counts['total'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded fs-20">
                                        <i class="ri-building-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Available</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $counts['available'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded fs-20">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Hold</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $counts['hold'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded fs-20">
                                        <i class="ri-time-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Booked</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $counts['booked'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded fs-20">
                                        <i class="ri-calendar-todo-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Registered</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $counts['registered'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded fs-20">
                                        <i class="ri-award-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-semibold text-muted text-truncate mb-0">Blocked</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $counts['blocked'] }}</h4>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-dark-subtle text-dark rounded fs-20">
                                        <i class="ri-lock-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Row with List & Details Sidebar --}}
            {{-- Main Row with List --}}
            <div class="row">
                {{-- Listing Table Column --}}
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                {{-- Status Tabs --}}
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'all' ? 'active' : '' }}" href="javascript:void(0);" wire:click="setTab('all')">All Units</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Available' ? 'active' : '' }}" href="javascript:void(0);" wire:click="setTab('Available')">Available</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Hold' ? 'active' : '' }}" href="javascript:void(0);" wire:click="setTab('Hold')">Hold</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Booked' ? 'active' : '' }}" href="javascript:void(0);" wire:click="setTab('Booked')">Booked</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Registered' ? 'active' : '' }}" href="javascript:void(0);" wire:click="setTab('Registered')">Registered</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Blocked' ? 'active' : '' }}" href="javascript:void(0);" wire:click="setTab('Blocked')">Blocked</a>
                                    </li>
                                </ul>

                                <div class="d-flex align-items-center gap-2">
                                    {{-- Bulk Actions --}}
                                    @if(count($selectedInventories) > 0)
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Bulk Actions ({{ count($selectedInventories) }})
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);" wire:click="bulkChangeStatus('Available')">Change Status: Available</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);" wire:click="bulkChangeStatus('Hold')">Change Status: Hold</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);" wire:click="bulkChangeStatus('Blocked')">Change Status: Blocked</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0);" wire:click="bulkDelete">Delete Selected</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- Table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0 text-center text-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" class="form-check-input" wire:model.live="selectAll">
                                            </th>
                                            @if ($inventory_type === 'Flat Project')
                                                <th>Floor</th>
                                                <th>Flat No.</th>
                                                <th>Type</th>
                                                <th>Unit Type</th>
                                                <th>Area (SBUP)</th>
                                                <th>Carpet Area</th>
                                            @else
                                                <th>Plot No.</th>
                                                <th>Area (Sq. Yards)</th>
                                                <th>Road Size</th>
                                                <th>PLC %</th>
                                                <th>PLC Status</th>
                                            @endif
                                            <th>Price (₹)</th>
                                            <th>Current Status</th>
                                            <th width="120">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($units as $unit)
                                            <tr wire:key="unit-row-{{ $unit->id }}">
                                                <td onclick="event.stopPropagation();">
                                                    <input type="checkbox" class="form-check-input" value="{{ $unit->id }}" wire:model.live="selectedInventories">
                                                </td>
                                                @if ($inventory_type === 'Flat Project')
                                                    <td>{{ $unit->floor }}</td>
                                                    <td class="fw-bold">{{ $unit->flat_no }}</td>
                                                    <td>{{ $unit->flat_type }}</td>
                                                    <td>{{ $unit->unit_type }}</td>
                                                    <td>{{ number_format($unit->area_sbup, 2) }}</td>
                                                    <td>{{ number_format($unit->carpet_area, 2) }}</td>
                                                @else
                                                    <td class="fw-bold">{{ $unit->plot_no }}</td>
                                                    <td>{{ number_format($unit->area_sq_yards, 2) }}</td>
                                                    <td>{{ $unit->road_size }}</td>
                                                    <td>{{ $unit->plc_percentage !== null ? $unit->plc_percentage . '%' : '-' }}</td>
                                                    <td>{{ $unit->plc_status ?: '-' }}</td>
                                                @endif
                                                <td class="text-end fw-semibold">₹ {{ number_format($unit->price, 0) }}</td>
                                                <td>
                                                    @if($unit->status === 'Available')
                                                        <span class="badge bg-success-subtle text-success px-2 py-1">Available</span>
                                                    @elseif($unit->status === 'Hold')
                                                        <span class="badge bg-warning-subtle text-warning px-2 py-1">Hold</span>
                                                    @elseif($unit->status === 'Booked')
                                                        <span class="badge bg-danger-subtle text-danger px-2 py-1">Booked</span>
                                                    @elseif($unit->status === 'Registered')
                                                        <span class="badge bg-info-subtle text-info px-2 py-1">Registered</span>
                                                    @else
                                                        <span class="badge bg-dark-subtle text-dark px-2 py-1">{{ $unit->status }}</span>
                                                    @endif
                                                </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu shadow">
                                                            <li>
                                                                <a class="dropdown-item py-2" href="{{ route('inventories.edit', $unit->id) }}">
                                                                    <i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2" href="javascript:void(0);" wire:click="openPriceModal('{{ $unit->id }}')">
                                                                    <i class="ri-money-dollar-circle-line align-bottom me-2 text-muted"></i> Update Price
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2" href="javascript:void(0);" wire:click="openStatusModal('{{ $unit->id }}')">
                                                                    <i class="ri-checkbox-circle-line align-bottom me-2 text-muted"></i> Change Status
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item py-2" href="/leads/create?project_id={{ $unit->project_id }}&plot_no={{ $unit->inventory_type === 'flat' ? $unit->flat_no : $unit->plot_no }}">
                                                                    <i class="ri-book-read-line align-bottom me-2 text-muted"></i> Book
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <button class="dropdown-item py-2 text-danger" type="button" wire:click="deleteUnit('{{ $unit->id }}')" wire:confirm="Are you sure you want to delete this unit?">
                                                                    <i class="ri-delete-bin-line align-bottom me-2"></i> Delete Unit
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4 text-muted">No units found. Select a project or add units to begin.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $units->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}

    {{-- Import Units CSV Modal --}}
    <div class="modal fade @if($importModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Units via CSV</h5>
                    <button type="button" class="btn-close" wire:click="$set('importModalOpen', false)"></button>
                </div>
                <form wire:submit="importUnits">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Upload CSV File</label>
                            <input type="file" class="form-control" wire:model="importFile">
                            @error('importFile') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>
                        <div class="alert alert-info py-2 fs-12 mb-0">
                            <strong>CSV Format Headers:</strong><br>
                            @if ($inventory_type === 'Flat Project')
                                Sr. No., Floor, Flat No., Type, Unit Type, Area (SBUP), Carpet Area
                            @else
                                Sr. No., Plot No., Area (Sq. Yards), Road Size, PLC %, Status, Sold
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="$set('importModalOpen', false)">Close</button>
                        <button type="submit" class="btn btn-success">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Price Modal --}}
    <div class="modal fade @if($priceModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Unit Price</h5>
                    <button type="button" class="btn-close" wire:click="$set('priceModalOpen', false)"></button>
                </div>
                <form wire:submit="updatePrice">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">New Price (₹)</label>
                            <input type="number" step="0.01" class="form-control" wire:model="tempPrice">
                            @error('tempPrice') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="$set('priceModalOpen', false)">Close</button>
                        <button type="submit" class="btn btn-primary">Save Price</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Status / Hold Modal --}}
    <div class="modal fade @if($statusModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Status</h5>
                    <button type="button" class="btn-close" wire:click="$set('statusModalOpen', false)"></button>
                </div>
                <form wire:submit="updateStatus">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Current Status</label>
                            <select class="form-select" wire:model.live="tempStatus">
                                <option value="Available">Available</option>
                                <option value="Hold">Hold</option>
                                <option value="Booked">Booked</option>
                                <option value="Registered">Registered</option>
                                <option value="Blocked">Blocked</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks / Change Description</label>
                            <textarea class="form-control" rows="3" wire:model="tempRemarks" placeholder="Enter remarks..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" wire:click="$set('statusModalOpen', false)">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
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
