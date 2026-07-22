@extends('layouts.front')

@section('content')
<section class="section nft-hero bg-light" style="padding: 180px 0 100px 0; min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-success text-white text-center py-4">
                        <i class="ri-checkbox-circle-fill" style="font-size: 64px;"></i>
                        <h3 class="text-white fw-bold mt-2 mb-0">Booking & Payment Confirmed!</h3>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-semibold text-dark">Thank You, {{ $lead->first_name }} {{ $lead->last_name }}!</h4>
                            <p class="text-muted">Your payment of <strong>₹21,100.00</strong> was received successfully.</p>
                        </div>
                        
                        <div class="bg-light p-4 rounded-3 mb-4">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">TRANSACTION ID</span>
                                    <strong class="text-dark">{{ $lead->transaction_id }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">PROJECT NAME</span>
                                    <strong class="text-dark">{{ $lead->project->name ?? '-' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">FLAT/PLOT SIZE</span>
                                    <strong class="text-dark">{{ $lead->flat_size }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-muted d-block fs-13">MOBILE NUMBER</span>
                                    <strong class="text-dark">{{ $lead->phone }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                            <i class="ri-information-line fs-20 me-2 text-info"></i>
                            <span class="fs-14">A confirmation email has been sent to <strong>{{ $lead->email }}</strong>. Please check your inbox for allotment and next steps details.</span>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('front') }}" class="btn btn-primary px-5 py-3 rounded-pill fw-semibold shadow-lg">
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
