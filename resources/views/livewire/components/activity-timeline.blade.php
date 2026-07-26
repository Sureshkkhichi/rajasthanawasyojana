<div>
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
            <i class="ri-history-line text-primary me-2 fs-18"></i> Activity Timeline
        </h6>
        <button type="button" wire:click="$refresh" class="btn btn-sm btn-light border text-muted shadow-none py-1 px-2 fs-12">
            <i class="ri-refresh-line me-1"></i> Refresh
        </button>
    </div>

    @if(count($activities) === 0)
        <div class="text-center py-4 bg-light rounded-3 border border-dashed">
            <i class="ri-pulse-line text-muted fs-32"></i>
            <p class="text-muted fs-13 mt-1 mb-0">No activity recorded yet.</p>
        </div>
    @else
        <div class="activity-timeline-wrapper position-relative ps-3">
            <!-- Timeline vertical line -->
            <div class="position-absolute start-0 top-0 bottom-0 bg-light border-start border-2 ms-2" style="z-index: 1;"></div>

            <div class="d-flex flex-column gap-3">
                @foreach($activities as $log)
                    <div class="position-relative ps-4" style="z-index: 2;">
                        <!-- Node Icon -->
                        <div class="position-absolute start-0 top-0 translate-middle-x rounded-circle d-flex align-items-center justify-content-between shadow-sm bg-white border border-2 border-{{ $log->badge_color }}" 
                            style="width: 28px; height: 28px; left: -1px; margin-left: 2px;">
                            <i class="{{ $log->icon }} text-{{ $log->badge_color }} mx-auto fs-13"></i>
                        </div>

                        <!-- Card Content -->
                        <div class="card border border-light shadow-sm rounded-3 overflow-hidden">
                            <div class="card-body p-2 px-3">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold text-dark fs-13">{{ $log->title }}</span>
                                    <span class="text-muted fs-11" title="{{ $log->created_at ? $log->created_at->format('d M Y, h:i A') : '' }}">
                                        <i class="ri-time-line me-1"></i>{{ $log->formatted_time }}
                                    </span>
                                </div>

                                @if($log->description)
                                    <p class="text-muted fs-12 mb-1">{!! $log->formatted_description_html !!}</p>
                                @endif

                                <div class="d-flex align-items-center justify-content-between mt-1 pt-1 border-top border-light">
                                    <div class="d-flex align-items-center text-muted fs-11">
                                        <i class="ri-user-line me-1"></i>
                                        <span>{{ $log->user ? $log->user->name : ($log->is_system_generated ? 'System' : 'System User') }}</span>
                                    </div>
                                    <span class="badge bg-{{ $log->badge_color }}-subtle text-{{ $log->badge_color }} fw-semibold fs-10 px-2 py-0.5 rounded-pill text-uppercase">
                                        {{ $log->log_type }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
