<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent pb-3">
                        <h4 class="mb-sm-0 fw-bold text-primary">Inventory Management</h4>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-soft-success btn-sm d-flex align-items-center gap-1 px-3" wire:click="openImportModal">
                                <i class="ri-upload-2-line align-middle"></i> Import Units
                            </button>
                            <button type="button" class="btn btn-soft-secondary btn-sm d-flex align-items-center gap-1 px-3" wire:click="exportUnits">
                                <i class="ri-download-2-line align-middle"></i> Export Units
                            </button>
                            <a href="{{ route('inventories.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 px-3">
                                <i class="ri-add-line align-middle"></i> Add Unit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                    <div class="row g-3 align-items-end">
                        <div class="{{ $inventory_type === 'Flat Project' ? 'col-md-4' : 'col-md-5' }}">
                            <label class="form-label text-muted fw-bold mb-1.5"><i class="ri-building-4-line me-1"></i>Select Project <span class="text-danger">*</span></label>
                            <div class="d-flex gap-2">
                                <select class="form-select border-light-subtle shadow-sm" wire:model.live="selectedProjectId">
                                    <option value="">Select Project</option>
                                    @foreach($projects as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->inventory_type === 'flat' ? 'Flat' : 'Plot' }}) - {{ $p->registration_status === 'open' ? 'Reg. Open' : 'Reg. Closed' }}</option>
                                    @endforeach
                                </select>
                                <span class="badge {{ $inventory_type === 'Flat Project' ? 'bg-info-subtle text-info border border-info-subtle' : 'bg-success-subtle text-success border border-success-subtle' }} d-flex align-items-center px-3 py-2 text-nowrap rounded-3">
                                    {{ $inventory_type }}
                                </span>
                            </div>
                        </div>

                        <div class="{{ $inventory_type === 'Flat Project' ? 'col-md-2' : 'col-md-3' }}">
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

                        @if ($inventory_type === 'Flat Project')
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

                        <div class="{{ $inventory_type === 'Flat Project' ? 'col-md-3' : 'col-md-4' }}">
                            <label class="form-label text-muted fw-bold mb-1.5"><i class="ri-search-line me-1"></i>Search Unit</label>
                            <div class="input-group shadow-sm">
                                <input type="text" class="form-control border-light-subtle" placeholder="{{ $inventory_type === 'Flat Project' ? 'Search Flat No...' : 'Search Plot No...' }}" wire:model.live.debounce.300ms="searchPlot">
                                <span class="input-group-text bg-light border-light-subtle text-muted"><i class="ri-search-line"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="row">
                {{-- Card 1: Total Units --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3 shadow-none">
                                        <i class="ri-building-line align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ $inventory_type === 'Flat Project' ? 'Total Flats' : 'Total Plots' }}
                                    </p>
                                    <h4 class="mb-0 fw-bold"><span class="counter-value" data-target="{{ $counts['total'] }}">{{ $counts['total'] }}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Available --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3 shadow-none">
                                        <i class="ri-checkbox-circle-line align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ $inventory_type === 'Flat Project' ? 'Available Flats' : 'Available Plots' }}
                                    </p>
                                    <h4 class="mb-0 fw-bold"><span class="counter-value" data-target="{{ $counts['available'] }}">{{ $counts['available'] }}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Hold --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-3 shadow-none">
                                        <i class="ri-time-line align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ $inventory_type === 'Flat Project' ? 'Hold Flats' : 'Hold Plots' }}
                                    </p>
                                    <h4 class="mb-0 fw-bold"><span class="counter-value" data-target="{{ $counts['hold'] }}">{{ $counts['hold'] }}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 4: Sold --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-3 shadow-none">
                                        <i class="ri-calendar-todo-line align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ $inventory_type === 'Flat Project' ? 'Sold Flats' : 'Sold Plots' }}
                                    </p>
                                    <h4 class="mb-0 fw-bold"><span class="counter-value" data-target="{{ $counts['sold'] }}">{{ $counts['sold'] }}</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 5: Alloted --}}
                <div class="col-lg col-md-4 col-sm-6 mb-3">
                    <div class="card card-animate h-100 shadow-sm border-0 border-start border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-3 shadow-none">
                                        <i class="ri-award-line align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        {{ $inventory_type === 'Flat Project' ? 'Alloted Flats' : 'Alloted Plots' }}
                                    </p>
                                    <h4 class="mb-0 fw-bold"><span class="counter-value" data-target="{{ $counts['alloted'] }}">{{ $counts['alloted'] }}</span></h4>
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
                        <div class="card-header border-bottom-0 pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                {{-- Status Tabs --}}
                                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'all' ? 'active text-primary' : 'text-muted' }} fw-bold" href="javascript:void(0);" wire:click="setTab('all')">
                                            All Units
                                            <span class="badge bg-primary-subtle text-primary ms-1.5 px-2 py-0.5 rounded-pill fs-11 align-middle">{{ $counts['total'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Available' ? 'active text-success' : 'text-muted' }} fw-bold" href="javascript:void(0);" wire:click="setTab('Available')">
                                            Available
                                            <span class="badge bg-success-subtle text-success ms-1.5 px-2 py-0.5 rounded-pill fs-11 align-middle">{{ $counts['available'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Hold' ? 'active text-warning' : 'text-muted' }} fw-bold" href="javascript:void(0);" wire:click="setTab('Hold')">
                                            Hold
                                            <span class="badge bg-warning-subtle text-warning ms-1.5 px-2 py-0.5 rounded-pill fs-11 align-middle">{{ $counts['hold'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Sold' ? 'active text-danger' : 'text-muted' }} fw-bold" href="javascript:void(0);" wire:click="setTab('Sold')">
                                            Sold
                                            <span class="badge bg-danger-subtle text-danger ms-1.5 px-2 py-0.5 rounded-pill fs-11 align-middle">{{ $counts['sold'] }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'Alloted' ? 'active text-info' : 'text-muted' }} fw-bold" href="javascript:void(0);" wire:click="setTab('Alloted')">
                                            Alloted
                                            <span class="badge bg-info-subtle text-info ms-1.5 px-2 py-0.5 rounded-pill fs-11 align-middle">{{ $counts['alloted'] }}</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="d-flex align-items-center gap-2">
                                    {{-- Bulk Actions --}}
                                    @if(count($selectedInventories) > 0)
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Bulk Actions ({{ count($selectedInventories) }})
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li><a class="dropdown-item" href="javascript:void(0);" wire:click="bulkChangeStatus('Available')"><i class="ri-checkbox-circle-line text-success me-2 align-middle"></i>Change Status: Available</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);" wire:click="bulkChangeStatus('Hold')"><i class="ri-time-line text-warning me-2 align-middle"></i>Change Status: Hold</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="javascript:void(0);" wire:click="bulkDelete"><i class="ri-delete-bin-line me-2 align-middle"></i>Delete Selected</a></li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- Table --}}
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 text-center text-nowrap table-borderless">
                                    <thead class="text-muted table-light uppercase fs-11">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" class="form-check-input" wire:model.live="selectAll">
                                            </th>
                                            @if ($inventory_type === 'Flat Project')
                                                <th>Floor</th>
                                                <th>Flat No.</th>
                                                <th>Unit Type</th>
                                                <th>Area (SBUP)</th>
                                                <th>Carpet Area</th>
                                                <th>Super Buildup Area</th>
                                            @else
                                                <th>Plot No.</th>
                                                <th>Area (Sq. Yards)</th>
                                                <th>Road Size</th>
                                                <th>PLC %</th>
                                            @endif
                                            <th>Price (₹)</th>
                                            <th>Current Status</th>
                                            <th width="80">Actions</th>
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
                                                        <span class="badge bg-dark-subtle text-dark rounded-pill px-2.5 py-1 fs-11">{{ $unit->status }}</span>
                                                    @endif

                                                    @if($unit->deal)
                                                        <div class="mt-2 p-2 bg-light rounded border border-light-subtle d-inline-block text-start shadow-none" style="min-width: 140px; margin: 0 auto; display: block !important;">
                                                            <div class="d-flex align-items-center gap-1 mb-1">
                                                                <i class="ri-user-line text-muted fs-11"></i>
                                                                <a href="{{ route('deals.show', $unit->deal->id) }}" class="text-primary fw-semibold fs-11 text-truncate d-inline-block" style="max-width: 110px;" title="{{ $unit->deal->first_name }} {{ $unit->deal->last_name }}">
                                                                    {{ $unit->deal->first_name }} {{ $unit->deal->last_name }}
                                                                </a>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <i class="ri-phone-line text-muted fs-11"></i>
                                                                <span class="text-muted fs-11">{{ $unit->deal->phone }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="dropdown">
                                                        <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow border-light-subtle">
                                                            <li>
                                                                <a class="dropdown-item py-2" href="{{ route('inventories.edit', $unit->id) }}">
                                                                    <i class="ri-edit-line align-bottom me-2 text-primary"></i> Edit Unit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item py-2" type="button" wire:click="openSoldModal('{{ $unit->id }}')">
                                                                    <i class="ri-checkbox-circle-line align-bottom me-2 text-danger"></i> Mark Sold
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item py-2" type="button" wire:click="changeSingleStatusDirectly('{{ $unit->id }}', 'Available')">
                                                                    <i class="ri-checkbox-circle-line align-bottom me-2 text-success"></i> Mark Available
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item py-2" type="button" wire:click="changeSingleStatusDirectly('{{ $unit->id }}', 'Hold')">
                                                                    <i class="ri-checkbox-circle-line align-bottom me-2 text-warning"></i> Mark Hold
                                                                </button>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <button class="dropdown-item py-2 text-danger" type="button" wire:click="vacateUnit('{{ $unit->id }}')" wire:confirm="Are you sure you want to vacate this unit? This will cancel any active allotments for this unit.">
                                                                    <i class="ri-close-circle-line align-bottom me-2"></i> Vacate
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-success text-white py-3 rounded-top-4">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                        <i class="ri-upload-2-line me-2"></i> Import Units via CSV
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('importModalOpen', false)"></button>
                </div>
                <form wire:submit="importUnits">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Upload CSV File</label>
                            <input type="file" class="form-control border-2" wire:model="importFile">
                            @error('importFile') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>
                        <div class="alert alert-success-subtle border border-success-subtle py-2 fs-12 mb-0 rounded-3">
                            <strong class="text-success">CSV Format Headers:</strong><br>
                            @if ($inventory_type === 'Flat Project')
                                Sr. No., Floor, Flat No., Type, Unit Type, Area (SBUP), Carpet Area
                            @else
                                Sr. No., Plot No., Area (Sq. Yards), Road Size, PLC %, Status, Sold
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-light border" wire:click="$set('importModalOpen', false)">Close</button>
                        <button type="submit" class="btn btn-success px-4">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Price Modal --}}
    <div class="modal fade @if($priceModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-primary text-white py-3 rounded-top-4">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                        <i class="ri-money-dollar-circle-line me-2"></i> Update Unit Price
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('priceModalOpen', false)"></button>
                </div>
                <form wire:submit="updatePrice">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">New Price (₹)</label>
                            <input type="number" step="0.01" class="form-control border-2" wire:model="tempPrice" placeholder="Enter new price">
                            @error('tempPrice') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-light border" wire:click="$set('priceModalOpen', false)">Close</button>
                        <button type="submit" class="btn btn-primary px-4">Save Price</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Status / Hold Modal --}}
    <div class="modal fade @if($statusModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-warning text-dark py-3 rounded-top-4">
                    <h5 class="modal-title text-dark fw-bold d-flex align-items-center">
                        <i class="ri-edit-2-line me-2"></i> Update Status
                    </h5>
                    <button type="button" class="btn-close" wire:click="$set('statusModalOpen', false)"></button>
                </div>
                <form wire:submit="updateStatus">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Current Status</label>
                            <select class="form-select border-2" wire:model.live="tempStatus">
                                <option value="Available">Available</option>
                                <option value="Hold">Hold</option>
                                <option value="Sold">Sold</option>
                                <option value="Alloted">Alloted</option>
                                <option value="Blocked">Blocked</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Remarks / Change Description</label>
                            <textarea class="form-control border-2" rows="3" wire:model="tempRemarks" placeholder="Enter remarks..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-light border" wire:click="$set('statusModalOpen', false)">Close</button>
                        <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Mark Sold & Allot Deal Modal --}}
    <div class="modal fade @if($soldModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered @if($createNewDealMode) modal-lg @endif">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-danger text-white py-3 rounded-top-4">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                        <i class="ri-checkbox-circle-line me-2"></i> Allot Unit & Mark Sold
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('soldModalOpen', false)"></button>
                </div>
                <form wire:submit="submitSoldAllotment">
                    <div class="modal-body p-4">
                        {{-- Mode Selector Toggle --}}
                        <div class="d-flex justify-content-center mb-4">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-danger @if(!$createNewDealMode) active @endif" wire:click="$set('createNewDealMode', false)">
                                    <i class="ri-user-search-line align-middle me-1"></i> Select Existing Deal
                                </button>
                                <button type="button" class="btn btn-outline-danger @if($createNewDealMode) active @endif" wire:click="$set('createNewDealMode', true)">
                                    <i class="ri-user-add-line align-middle me-1"></i> Create New Deal
                                </button>
                            </div>
                        </div>

                        @if(!$createNewDealMode)
                            {{-- Select Existing Deal View --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Select Customer Deal *</label>
                                <select class="form-select border-2" wire:model.live="selectedDealId">
                                    <option value="">-- Choose Existing Deal --</option>
                                    @foreach($unallottedDeals as $deal)
                                        <option value="{{ $deal->id }}">
                                            {{ $deal->first_name }} {{ $deal->last_name }} ({{ $deal->phone }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedDealId') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                            </div>

                            @if($selectedDealDetails)
                                {{-- Deal Details card --}}
                                <div class="card border border-2 border-dashed border-success bg-success-subtle mb-0 mt-3 rounded-3">
                                    <div class="card-body p-3">
                                        <h6 class="fw-semibold text-success mb-2 d-flex align-items-center">
                                            <i class="ri-user-line me-1"></i> Selected Customer Details
                                        </h6>
                                        <div class="row text-dark">
                                            <div class="col-md-6 mb-2">
                                                <span class="text-muted fs-13">Customer Name:</span><br>
                                                <strong>{{ $selectedDealDetails['name'] }}</strong>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="text-muted fs-13">Mobile Number:</span><br>
                                                <strong>{{ $selectedDealDetails['phone'] }}</strong>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="text-muted fs-13">Email Address:</span><br>
                                                <strong>{{ $selectedDealDetails['email'] ?: '-' }}</strong>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <span class="text-muted fs-13">Booking Amount:</span><br>
                                                <strong>₹{{ number_format($selectedDealDetails['booking_amount'], 2) }}</strong>
                                            </div>
                                            <div class="col-12">
                                                <span class="text-muted fs-13">Total Amount:</span><br>
                                                <strong>₹{{ number_format($selectedDealDetails['total_amount'], 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif(count($unallottedDeals) === 0)
                                <div class="alert alert-warning mb-0 mt-2 d-flex align-items-center">
                                    <i class="ri-error-warning-line fs-20 me-2 text-warning"></i>
                                    <div>No unallotted deals found for this project. Choose "Create New Deal" to register one!</div>
                                </div>
                            @endif

                        @else
                            {{-- Create New Deal View Form --}}
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">First Name *</label>
                                    <input type="text" class="form-control border-2" placeholder="Enter first name" wire:model="newDealForm.first_name">
                                    @error('newDealForm.first_name') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Last Name</label>
                                    <input type="text" class="form-control border-2" placeholder="Enter last name" wire:model="newDealForm.last_name">
                                    @error('newDealForm.last_name') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Mobile Number *</label>
                                    <input type="text" class="form-control border-2" placeholder="Enter mobile number" wire:model="newDealForm.phone">
                                    @error('newDealForm.phone') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Email Address</label>
                                    <input type="email" class="form-control border-2" placeholder="Enter email" wire:model="newDealForm.email">
                                    @error('newDealForm.email') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Booking Amount Paid (₹) *</label>
                                    <input type="number" step="0.01" class="form-control border-2" placeholder="Enter booking amount" wire:model="newDealForm.booking_amount">
                                    @error('newDealForm.booking_amount') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Total Price (₹) *</label>
                                    <input type="number" step="0.01" class="form-control border-2" placeholder="Enter total price" wire:model="newDealForm.total_amount">
                                    @error('newDealForm.total_amount') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer bg-light py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-light border" wire:click="$set('soldModalOpen', false)">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger px-4">
                            <span wire:loading.remove wire:target="submitSoldAllotment">
                                <i class="ri-checkbox-circle-line align-middle me-1"></i> Allot & Mark Sold
                            </span>
                            <span wire:loading wire:target="submitSoldAllotment">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Processing...
                            </span>
                        </button>
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
