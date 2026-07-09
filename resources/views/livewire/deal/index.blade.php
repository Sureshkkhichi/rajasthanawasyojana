<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Deals</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Finance</a></li>
                                <li class="breadcrumb-item active">Deals</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top buttons & filters --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between gap-3 mb-3">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-success d-flex align-items-center gap-1">
                                        <i class="ri-add-line fs-16"></i> Add New Deal
                                    </button>
                                    <button type="button" class="btn btn-danger d-flex align-items-center gap-1" wire:click="deleteSelected" @if(empty($selectedDeals)) disabled @endif>
                                        <i class="ri-delete-bin-line fs-16"></i> Delete
                                    </button>
                                    <button type="button" class="btn btn-light border d-flex align-items-center gap-1">
                                        <i class="ri-printer-line fs-16"></i> Print
                                    </button>
                                    <button type="button" class="btn btn-info d-flex align-items-center gap-1">
                                        <i class="ri-file-download-line fs-16"></i> Export
                                    </button>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="search-box">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search..." wire:model.live.debounce.300ms="keyword">
                                            <button class="btn btn-success" type="button">
                                                <i class="ri-search-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span>Show</span>
                                    <select class="form-select form-select-sm" wire:model.live="perPage" style="width: 75px;">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>entries</span>
                                </div>
                                <div>
                                    <span class="text-muted">Showing 1 to {{ count($deals) }} of {{ count($deals) }} entries</span>
                                </div>
                            </div>

                            {{-- Table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" class="form-check-input" wire:model.live="selectAll">
                                            </th>
                                            <th width="50">#</th>
                                            <th>Name</th>
                                            <th>Property</th>
                                            <th>Invoice No</th>
                                            <th>Allotment Date</th>
                                            <th>Booking Date</th>
                                            <th>Booking Amount</th>
                                            <th>Area</th>
                                            <th>Total Amount</th>
                                            <th>Balance Due</th>
                                            <th>Status</th>
                                            <th>Agent</th>
                                            <th>Remarks</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deals as $index => $deal)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" value="{{ $deal['id'] }}" wire:model.live="selectedDeals">
                                                </td>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="fw-semibold">{{ $deal['name'] }}</td>
                                                <td>{{ $deal['property'] }}</td>
                                                <td class="text-center">{{ $deal['invoice_no'] ?: '-' }}</td>
                                                <td class="text-center">{{ $deal['allotment_date'] ?: '-' }}</td>
                                                <td class="text-center">{{ $deal['booking_date'] }}</td>
                                                <td class="text-end">
                                                    @if($deal['booking_amount'])
                                                        ₹ {{ number_format($deal['booking_amount'], 2) }}
                                                    @else
                                                        ₹
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $deal['area'] ?: '-' }}</td>
                                                <td class="text-end">
                                                    @if($deal['total_amount'])
                                                        ₹ {{ number_format($deal['total_amount'], 2) }}
                                                    @else
                                                        ₹
                                                    @endif
                                                </td>
                                                <td class="text-end text-nowrap">
                                                    ₹ {{ number_format($deal['balance_due'], 0) }}
                                                </td>
                                                <td class="text-center">
                                                    @if($deal['status'] === 'Refund')
                                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">Refund</span>
                                                    @elseif($deal['status'] === 'Unpaid')
                                                        <span class="badge bg-danger text-white px-2 py-1 fs-12">Unpaid</span>
                                                    @elseif($deal['status'] === 'Partial')
                                                        <span class="badge bg-warning text-white px-2 py-1 fs-12">Partial</span>
                                                    @else
                                                        <span class="badge bg-success text-white px-2 py-1 fs-12">Paid</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $deal['agent'] ?: '-' }}</td>
                                                <td class="fs-12 text-muted">{{ $deal['remarks'] }}</td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#"><i class="ri-eye-line align-bottom me-1 text-muted"></i> View</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="ri-pencil-line align-bottom me-1 text-muted"></i> Edit</a></li>
                                                            <li><a class="dropdown-item" href="#"><i class="ri-delete-bin-line align-bottom me-1 text-muted"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="15" class="text-center py-4 text-muted">No deals found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Pagination block --}}
                            <div class="d-flex justify-content-end mt-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled"><a class="page-link" href="#">&larr; Prev</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#">510</a></li>
                                        <li class="page-item"><a class="page-link" href="#">511</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next &rarr;</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
