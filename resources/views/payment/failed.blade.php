@extends('layouts.front')

@section('content')
<section class="section nft-hero bg-light" style="padding: 180px 0 100px 0; min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-danger text-white text-center py-4">
                        <i class="ri-error-warning-fill" style="font-size: 64px;"></i>
                        <h3 class="text-white fw-bold mt-2 mb-0">Payment Unsuccessful</h3>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-semibold text-dark">We couldn't process your payment</h4>
                            <p class="text-muted">The transaction for <strong>₹21,100.00</strong> was not completed or failed.</p>
                        </div>
                        
                        @if($lead)
                        <div class="bg-light p-4 rounded-3 mb-4">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">TRANSACTION ID</span>
                                    <strong class="text-dark">{{ $lead->transaction_id ?? '-' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">PROJECT NAME</span>
                                    <strong class="text-dark">{{ $lead->project->name ?? '-' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">CUSTOMER NAME</span>
                                    <strong class="text-dark">{{ $lead->first_name }} {{ $lead->last_name }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">STATUS</span>
                                    <span class="badge bg-danger">Failed / Unpaid</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="alert alert-warning border-0 d-flex align-items-center mb-4">
                            <i class="ri-alert-line fs-20 me-2 text-warning"></i>
                            <span class="fs-14">Don't worry, if any money was deducted from your account, it will be refunded by your bank within 5-7 working days.</span>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            @if($lead)
                            <a href="{{ route('booking', ['project' => $lead->project_id]) }}" class="btn btn-success px-4 py-3 rounded-pill fw-semibold shadow-md">
                                <i class="ri-refresh-line align-middle me-1"></i> Try Booking Again
                            </a>
                            @endif
                            <a href="{{ route('front') }}" class="btn btn-outline-secondary px-4 py-3 rounded-pill fw-semibold">
                                <i class="ri-home-4-line align-middle me-1"></i> Back to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
