<div class="py-5" style="background-color: #f8f9fa; min-height: 80vh; margin-top: 70px;">
    <div class="container">
        <!-- Page Heading -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <div class="badge bg-danger-subtle text-danger px-3 py-2 fs-14 fw-bold rounded-pill mb-2">
                    <i class="ri-file-list-3-line me-1"></i> मुख्यमंत्री जन आवास योजना
                </div>
                <h2 class="fw-bold text-dark mb-2" style="color: #4a1510;">आवंटन पत्र / लॉटरी का परिणाम देखें</h2>
                <p class="text-muted fs-15">
                    अपना पंजीकृत 10 अंकों का मोबाइल नंबर दर्ज करें और अपने आवंटन पत्र, मांग पत्र तथा भुगतान रसीद डाउनलोड करें।
                </p>
            </div>
        </div>

        <!-- Search Form Box -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <form wire:submit.prevent="search">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark fs-14">मोबाइल नंबर (Registered Mobile Number)</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-light text-muted border-end-0 fs-16">
                                    <i class="ri-phone-line"></i> +91
                                </span>
                                <input type="text" class="form-control border-start-0 fs-16 @error('mobile') is-invalid @enderror" 
                                    wire:model="mobile" maxlength="10" placeholder="10 अंकों का मोबाइल नंबर दर्ज करें" autofocus>
                            </div>
                            @error('mobile') <span class="text-danger fs-13 mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold rounded-3 shadow-sm"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="ri-search-eye-line me-1"></i> लॉटरी परिणाम / आवंटन पत्र खोजें
                            </span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span> खोजा जा रहा है...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Search Results Section -->
        @if($searched)
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if(count($deals) > 0)
                        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-4 p-3">
                            <i class="ri-checkbox-circle-fill fs-24 me-3 text-success"></i>
                            <div>
                                <h6 class="fw-bold mb-1">आवंटन रिकॉर्ड मिला! (Records Found)</h6>
                                <p class="mb-0 fs-14">मोबाइल नंबर <strong>{{ $mobile }}</strong> पर निम्नलिखित आवंटन पत्र उपलब्ध हैं:</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            @foreach($deals as $deal)
                                @php
                                    $inv = $deal->allottedInventory;
                                    $formNo = $deal->jana_number;
                                @endphp
                                <div class="col-md-6">
                                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden" style="border-top: 4px solid #5c3017 !important;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="badge bg-primary-subtle text-primary fw-bold px-2 py-1 fs-12 mb-1">
                                                        <i class="ri-hashtag"></i> {{ $formNo }}
                                                    </span>
                                                    <h5 class="fw-bold text-dark mb-0">
                                                        {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}
                                                    </h5>
                                                </div>
                                                @if($inv)
                                                    <span class="badge bg-success fw-semibold px-2 py-1 fs-12">
                                                        <i class="ri-checkbox-circle-line me-1"></i> आवंटित (Allotted)
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark fw-semibold px-2 py-1 fs-12">
                                                        <i class="ri-time-line me-1"></i> प्रक्रियाधीन (Pending)
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="bg-light p-3 rounded-3 mb-3 fs-14">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <span class="text-muted d-block fs-12">परियोजना (Project)</span>
                                                        <strong class="text-dark">{{ $deal->project?->name ?: config('constants.site_name') }}</strong>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-muted d-block fs-12">बुकिंग तिथि (Booking Date)</span>
                                                        <strong class="text-dark">{{ $deal->booking_date ? $deal->booking_date->format('d-m-Y') : '-' }}</strong>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <span class="text-muted d-block fs-12">आवंटित इकाई (Unit No)</span>
                                                        <strong class="text-danger fs-15">{{ $inv ? ($inv->flat_no ?: $inv->plot_no) : 'आवंटन जल्द' }}</strong>
                                                    </div>
                                                    <div class="col-6 mt-2">
                                                        <span class="text-muted d-block fs-12">ब्लॉक / टावर (Block/Tower)</span>
                                                        <strong class="text-dark">{{ $inv ? ($inv->block ?: '-') : '-' }}</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Document Download Action Buttons -->
                                            <div class="d-grid gap-2">
                                                @if($inv)
                                                    <a href="{{ route('public.allotment-letter', $deal->id) }}" target="_blank" 
                                                        class="btn btn-outline-danger fw-bold btn-sm py-2 rounded-3 text-start px-3 d-flex justify-content-between align-items-center">
                                                        <span><i class="ri-file-paper-2-line me-2 text-danger"></i> आवंटन पत्र डाउनलोड करें (Allotment Letter)</span>
                                                        <i class="ri-download-2-line"></i>
                                                    </a>

                                                    <a href="{{ route('public.demand-letter', $deal->id) }}" target="_blank" 
                                                        class="btn btn-outline-warning text-dark fw-bold btn-sm py-2 rounded-3 text-start px-3 d-flex justify-content-between align-items-center">
                                                        <span><i class="ri-file-text-line me-2 text-warning"></i> मांग पत्र डाउनलोड करें (Demand Letter)</span>
                                                        <i class="ri-download-2-line"></i>
                                                    </a>
                                                @endif

                                                <a href="{{ route('public.invoice', ['deal' => $deal->id, 'download' => 1]) }}" target="_blank" 
                                                    class="btn btn-outline-success fw-bold btn-sm py-2 rounded-3 text-start px-3 d-flex justify-content-between align-items-center">
                                                    <span><i class="ri-bill-line me-2 text-success"></i> भुगतान रसीद / इनवॉइस डाउनलोड करें (Invoice)</span>
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card border-0 shadow-sm rounded-4 text-center p-5 bg-white">
                            <div class="mb-3">
                                <i class="ri-folder-unknow-line text-warning display-4"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">कोई आवंटन रिकॉर्ड नहीं मिला!</h5>
                            <p class="text-muted fs-14 mb-0">
                                मोबाइल नंबर <strong>{{ $mobile }}</strong> से संबंधित कोई आवंटन या लॉटरी परिणाम दर्ज नहीं है।<br>
                                यदि आपने आवेदन किया है तो कृपया सही मोबाइल नंबर दर्ज करें या हेल्पलाइन पर संपर्क करें।
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
