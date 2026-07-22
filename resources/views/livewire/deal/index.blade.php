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
                                         <option value="Sold">Sold</option>
                                         <option value="Cancel">Cancel</option>
                                         <option value="Not Alloted">Not Alloted</option>
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
                                             <th>Payment Status</th>
                                             <th>Deal Status</th>
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
                                                         <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" data-bs-popper-config='{"strategy":"fixed"}' aria-expanded="false">
                                                             Action
                                                         </button>
                                                          <ul class="dropdown-menu shadow">
                                                              <li>
                                                                  <button class="dropdown-item py-2" type="button" wire:click="generateInvoice('{{ $deal->id }}')">
                                                                      <i class="ri-file-text-line align-bottom me-2 text-muted"></i> Generate Invoice
                                                                  </button>
                                                              </li>
                                                               @if(empty($deal->allotted_inventory_id))
                                                                   <li>
                                                                       <button class="dropdown-item py-2 text-success" type="button" wire:click="openAllotModal('{{ $deal->id }}')">
                                                                           <i class="ri-add-box-line align-bottom me-2"></i> Allot Unit
                                                                       </button>
                                                                   </li>
                                                               @else
                                                                   <li>
                                                                       <a class="dropdown-item py-2 text-info" href="{{ route('deals.allotment-letter', $deal->id) }}" target="_blank">
                                                                           <i class="ri-file-download-line align-bottom me-2"></i> Download Allotment Letter
                                                                       </a>
                                                                   </li>
                                                                   <li>
                                                                       <a class="dropdown-item py-2 text-info" href="{{ route('deals.demand-letter', $deal->id) }}" target="_blank">
                                                                           <i class="ri-file-download-line align-bottom me-2"></i> Download Demand Letter
                                                                       </a>
                                                                   </li>
                                                               @endif
                                                              <li><hr class="dropdown-divider"></li>
                                                              <li>
                                                                  <button class="dropdown-item py-2" type="button" wire:click="changeDealStatus('{{ $deal->id }}', 'Sold')">
                                                                      <i class="ri-checkbox-circle-line align-bottom me-2 text-success"></i> Mark Sold
                                                                  </button>
                                                              </li>
                                                              <li>
                                                                  <button class="dropdown-item py-2" type="button" wire:click="changeDealStatus('{{ $deal->id }}', 'Refund')">
                                                                      <i class="ri-refund-line align-bottom me-2 text-danger"></i> Mark Refund
                                                                  </button>
                                                              </li>
                                                              <li>
                                                                  <button class="dropdown-item py-2" type="button" wire:click="changeDealStatus('{{ $deal->id }}', 'Cancel')">
                                                                      <i class="ri-close-circle-line align-bottom me-2 text-secondary"></i> Mark Cancel
                                                                  </button>
                                                              </li>
                                                              <li>
                                                                  <button class="dropdown-item py-2" type="button" wire:click="changeDealStatus('{{ $deal->id }}', 'Not Alloted')">
                                                                      <i class="ri-indeterminate-circle-line align-bottom me-2 text-dark"></i> Mark Not Alloted
                                                                  </button>
                                                              </li>
                                                              <li><hr class="dropdown-divider"></li>
                                                              <li>
                                                                  <a class="dropdown-item py-2" href="{{ route('deals.show', $deal->id) }}">
                                                                      <i class="ri-fullscreen-line align-bottom me-2 text-muted"></i> View Full Form
                                                                  </a>
                                                              </li>
                                                          </ul>
                                                      </div>
                                                  </td>
                                                  <td class="fw-semibold text-start text-nowrap">{{ $deal->first_name }} {{ $deal->last_name }}</td>
                                                  <td class="text-nowrap">
                                                      @if($deal->project)
                                                          <div>
                                                              <a href="{{ route('projects.edit', $deal->project->id) }}" target="_blank" class="text-dark fw-semibold text-decoration-underline" title="Open project details in new tab">
                                                                  {{ $deal->project->name }}
                                                              </a>
                                                          </div>
                                                      @else
                                                          <div>-</div>
                                                      @endif
                                                      @if($deal->allottedInventory)
                                                          <div class="mt-1">
                                                              <a href="{{ route('inventories.edit', $deal->allottedInventory->id) }}" target="_blank" class="text-decoration-none" title="Open unit details in new tab">
                                                                  @if($deal->allottedInventory->inventory_type === 'flat')
                                                                      <span class="badge bg-info fw-semibold fs-11">
                                                                          Flat: {{ $deal->allottedInventory->flat_no }} ({{ $deal->allottedInventory->floor }}) <i class="ri-external-link-line ms-0.5"></i>
                                                                      </span>
                                                                  @else
                                                                      <span class="badge bg-info fw-semibold fs-11">
                                                                          Plot: {{ $deal->allottedInventory->plot_no }} <i class="ri-external-link-line ms-0.5"></i>
                                                                      </span>
                                                                  @endif
                                                              </a>
                                                          </div>
                                                      @endif
                                                  </td>
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
                                                 {{-- Payment Status: always Paid for a deal --}}
                                                 <td>
                                                     <span class="badge bg-success px-2 py-1 fs-12">Paid</span>
                                                 </td>
                                                 {{-- Deal Status --}}
                                                 <td>
                                                     @php $ds = $deal->deal_status ?? $deal->status; @endphp
                                                     @if($ds === 'Paid' || $ds === 'Sold')
                                                          <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12">{{ $ds }}</span>
                                                     @elseif($ds === 'Partial')
                                                          <span class="badge bg-warning text-white px-2 py-1 fs-12">Partial</span>
                                                     @elseif($ds === 'Refund')
                                                          <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">Refund</span>
                                                     @elseif($ds === 'Cancel')
                                                          <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fs-12">Cancel</span>
                                                     @elseif($ds === 'Not Alloted')
                                                          <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-2 py-1 fs-12">Not Alloted</span>
                                                     @elseif($ds)
                                                          <span class="badge bg-danger text-white px-2 py-1 fs-12">{{ $ds }}</span>
                                                     @else
                                                          <span class="badge bg-light text-muted px-2 py-1 fs-12">-</span>
                                                     @endif
                                                 </td>
                                             </tr>
                                         @empty
                                             <tr>
                                                 <td colspan="12" class="text-center py-4 text-muted">No deals found.</td>
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

    {{-- Allot Unit Modal --}}
    <div class="modal fade @if($allotModalOpen) show d-block @endif" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-4">
                <div class="modal-header bg-success text-white py-3 rounded-top-4">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center">
                        <i class="ri-add-box-line me-2"></i> Allot Unit to Customer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="$set('allotModalOpen', false)"></button>
                </div>
                <form wire:submit="submitAllotment">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted">Select Available Unit *</label>
                            <select class="form-select border-2" wire:model.live="selectedUnitId">
                                <option value="">-- Choose Flat or Plot --</option>
                                @foreach($availableUnits as $unit)
                                    @if($unit->inventory_type === 'flat')
                                        <option value="{{ $unit->id }}">
                                            Flat: {{ $unit->flat_no }} (Floor: {{ $unit->floor }}, Type: {{ $unit->unit_type_label }}, ₹{{ number_format($unit->price, 0) }})
                                        </option>
                                    @else
                                        <option value="{{ $unit->id }}">
                                            Plot: {{ $unit->plot_no }} (Area: {{ $unit->area_sq_yards }} Sq. Yards, Price: ₹{{ number_format($unit->price, 0) }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('selectedUnitId') <span class="text-danger fs-13">{{ $message }}</span> @enderror
                        </div>

                        @if($selectedUnitDetails)
                            {{-- Unit Details card --}}
                            <div class="card border border-2 border-dashed border-primary bg-primary-subtle mb-0 mt-3 rounded-3">
                                <div class="card-body p-3">
                                    <h6 class="fw-semibold text-primary mb-2 d-flex align-items-center">
                                        <i class="ri-building-line me-1"></i> Selected Unit Details
                                    </h6>
                                    <div class="row text-dark">
                                        <div class="col-12 mb-2">
                                            <span class="text-muted fs-13">Unit Name/Number:</span><br>
                                            <strong>{{ $selectedUnitDetails['label'] }}</strong>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <span class="text-muted fs-13">{{ $selectedUnitDetails['type'] === 'Flat' ? 'Unit Type' : 'Plot Area' }}:</span><br>
                                            <strong>{{ $selectedUnitDetails['info1'] }}</strong>
                                        </div>
                                        @if($selectedUnitDetails['type'] !== 'Flat')
                                            <div class="col-md-6 mb-2">
                                                <span class="text-muted fs-13">Road Size:</span><br>
                                                <strong>{{ $selectedUnitDetails['info2'] }}</strong>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <span class="text-muted fs-13">Price:</span><br>
                                            <strong class="text-danger fs-15">₹{{ number_format($selectedUnitDetails['price'], 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif(count($availableUnits) === 0)
                            <div class="alert alert-warning mb-0 mt-2 d-flex align-items-center">
                                <i class="ri-error-warning-line fs-20 me-2 text-warning"></i>
                                <div>No available plots/flats found for this project in the inventory. Please make sure some units are marked as 'Available' first.</div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer bg-light py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-light border" wire:click="$set('allotModalOpen', false)">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success px-4" @if(count($availableUnits) === 0) disabled @endif>
                            <span wire:loading.remove wire:target="submitAllotment">
                                <i class="ri-checkbox-circle-line align-middle me-1"></i> Confirm Allotment
                            </span>
                            <span wire:loading wire:target="submitAllotment">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Allotting...
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