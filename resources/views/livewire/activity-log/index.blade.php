<div>
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center">
                <i class="ri-history-line text-primary me-2 fs-24"></i> Activity Logs
            </h4>
            <p class="text-muted mb-0 fs-13">Audit trail and activity log history across Leads, Deals, and Inventories.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button type="button" wire:click="resetFilters" class="btn btn-light border shadow-sm btn-sm px-3">
                <i class="ri-refresh-line me-1"></i> Reset Filters
            </button>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted fs-12 mb-1">Search</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0"><i class="ri-search-line text-muted"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-start-0 shadow-none" placeholder="Search by title, description...">
                    </div>
                </div>

                <!-- Log Type -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted fs-12 mb-1">Log Type</label>
                    <select wire:model.live="logType" class="form-select form-select-sm shadow-none">
                        <option value="">All Types</option>
                        <option value="lead">Lead</option>
                        <option value="deal">Deal</option>
                        <option value="inventory">Inventory</option>
                        <option value="system">System</option>
                    </select>
                </div>

                <!-- Event -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted fs-12 mb-1">Event Action</label>
                    <select wire:model.live="event" class="form-select form-select-sm shadow-none">
                        <option value="">All Events</option>
                        <option value="created">Created</option>
                        <option value="status_changed">Status Changed</option>
                        <option value="sms_sent">SMS Sent</option>
                        <option value="email_sent">Email Sent</option>
                        <option value="pdf_downloaded">PDF Downloaded</option>
                        <option value="unit_allotted">Unit Allotted</option>
                        <option value="marked_sold">Marked Sold</option>
                        <option value="marked_refund">Marked Refund</option>
                        <option value="marked_cancel">Marked Cancel</option>
                        <option value="marked_not_alloted">Marked Not Alloted</option>
                        <option value="allotment_mail_sent">Allotment Mail Sent</option>
                        <option value="demand_mail_sent">Demand Mail Sent</option>
                    </select>
                </div>

                <!-- User -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-muted fs-12 mb-1">Performed By</label>
                    <select wire:model.live="userId" class="form-select form-select-sm shadow-none">
                        <option value="">All Users</option>
                        @foreach($users as $usr)
                            <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted fs-12 mb-1">Date Range</label>
                    <div class="d-flex gap-1">
                        <input type="date" wire:model.live="dateFrom" class="form-control form-control-sm shadow-none" placeholder="From">
                        <input type="date" wire:model.live="dateTo" class="form-control form-control-sm shadow-none" placeholder="To">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-3 py-3 text-muted fs-12 text-uppercase fw-semibold" style="width: 60px;">#</th>
                            <th class="py-3 text-muted fs-12 text-uppercase fw-semibold">Event / Title</th>
                            <th class="py-3 text-muted fs-12 text-uppercase fw-semibold">Type</th>
                            <th class="py-3 text-muted fs-12 text-uppercase fw-semibold">Description</th>
                            <th class="py-3 text-muted fs-12 text-uppercase fw-semibold">Performed By</th>
                            <th class="pe-3 py-3 text-muted fs-12 text-uppercase fw-semibold text-end">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td class="ps-3 text-muted fs-13">
                                    {{ $logs->firstItem() + $index }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs rounded-circle bg-{{ $log->badge_color }}-subtle text-{{ $log->badge_color }} d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 32px; height: 32px;">
                                            <i class="{{ $log->icon }} fs-16 mx-auto"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark fs-13 d-block">{{ $log->title }}</span>
                                            @if($log->event)
                                                <span class="badge bg-light text-secondary border font-monospace fs-10 px-1.5">{{ $log->event }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $log->badge_color }}-subtle text-{{ $log->badge_color }} fw-semibold fs-11 px-2.5 py-1 rounded-pill text-uppercase">
                                        {{ $log->log_type }}
                                    </span>
                                </td>
                                <td>
                                    <p class="text-dark fs-13 mb-0 text-truncate" style="max-width: 380px;" title="{{ $log->description }}">
                                        {{ $log->description ?? '-' }}
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-dark fs-13">
                                        <i class="ri-user-3-line text-muted me-1.5"></i>
                                        <span>{{ $log->user ? $log->user->name : ($log->is_system_generated ? 'System' : 'System User') }}</span>
                                    </div>
                                </td>
                                <td class="pe-3 text-end text-muted fs-12">
                                    <div>{{ $log->created_at ? $log->created_at->format('d M Y, h:i A') : '-' }}</div>
                                    <small class="text-muted fs-11">{{ $log->formatted_time }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="ri-history-line fs-36 d-block mb-2 text-muted"></i>
                                    <span>No activity logs found.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
