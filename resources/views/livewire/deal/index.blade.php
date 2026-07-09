<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Deals</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Deals</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Search Filter --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Search Filter
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label">
                                        Keyword
                                    </label>
                                    <input type="text" class="form-control" placeholder="Project Name / Slug"
                                        wire:model.live.debounce.500ms="keyword">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Status
                                    </label>
                                    <select class="form-select" wire:model.live="status">
                                        <option value=""> All Status </option>
                                        @foreach (config('constants.payment_statuses') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
            {{-- Deals List --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0"></h4>
                            <a href="#" class="btn btn-success">
                                <i class="ri-add-line me-1"></i>
                                Add New Deal
                            </a>
                        </div>
                        <div class="card-body">
                            <div wire:loading>
                                <div class="alert alert-info mb-3">
                                    Loading...
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle nowrap mb-0 text-nowrap">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40">
                                                <input type="checkbox" class="form-check-input"
                                                    wire:model.live="selectAll">
                                            </th>
                                            <th width="50">#</th>
                                            <th width="100">Action</th>
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

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($deals as $index => $deal)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check-input"
                                                    value="{{ $deal['id'] }}" wire:model.live="selectedDeals">
                                            </td>

                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="ri-eye-line align-bottom me-1 text-muted"></i>
                                                                View</a></li>
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="ri-pencil-line align-bottom me-1 text-muted"></i>
                                                                Edit</a></li>
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="ri-delete-bin-line align-bottom me-1 text-muted"></i>
                                                                Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
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
                                                <span
                                                    class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">Refund</span>
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

                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="15" class="text-center py-4 text-muted">No deals found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>