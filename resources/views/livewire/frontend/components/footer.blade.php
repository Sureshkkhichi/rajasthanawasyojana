<div>
    <!-- Start footer -->
    @php
        use App\Models\StaticPage;
        $footerPages = StaticPage::whereIn('slug', [
            'terms-and-conditions',
            'privacy-policy',
            'cancellation-refund-policy',
        ])->where('status', 'active')->get()->keyBy('slug');
    @endphp

    <!-- Allotment Result / View Allotment Letter Button Section -->
    <div class="py-3 text-center" style="background: linear-gradient(135deg, #4a1510 0%, #7c4c2d 100%); color: #fff;">
        <div class="container d-flex flex-wrap align-items-center justify-content-center justify-content-md-between gap-3">
            <div class="text-center text-md-start">
                <h5 class="fw-bold mb-1" style="color: #f6eedf;">
                    <i class="ri-award-line me-1 text-warning"></i> मुख्यमंत्री जन आवास योजना - आवंटन पत्र / लॉटरी परिणाम
                </h5>
                <p class="mb-0 fs-13 text-white-50">
                    अपना मोबाइल नंबर दर्ज करके अपना आवंटन पत्र, मांग पत्र तथा भुगतान रसीद डाउनलोड करें।
                </p>
            </div>
            <div>
                <a href="{{ route('allotment-result') }}" class="btn btn-danger btn-lg fw-bold rounded-pill shadow-sm px-4 py-2" style="background-color: #dc2626; border: none;">
                    <i class="ri-file-search-line me-1"></i> आवंटन पत्र / लॉटरी का परिणाम देखें
                </a>
            </div>
        </div>
    </div>

    <footer class="text-center text-lg-start bg-light text-muted">
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <div class="me-5 d-none d-lg-block">
                <span>{{ config('constants.site_name') }} | {{ "घर का सपना, अब होगा अपना" }}</span>
            </div>
            <div>
                @if(isset($footerPages['terms-and-conditions']))
                    <a href="{{ route('pages.terms') }}" class="me-4 text-reset">
                        Term and Condition
                    </a>
                @endif

                @if(isset($footerPages['privacy-policy']))
                    <a href="{{ route('pages.privacy') }}" class="me-4 text-reset">
                        Privacy policy
                    </a>
                @endif

                @if(isset($footerPages['cancellation-refund-policy']))
                    <a href="{{ route('pages.refund-policy') }}" class="me-4 text-reset">
                        Cancellation Refund policy
                    </a>
                @endif

                <a href="#" class="me-4 text-reset">
                    Contact Us
                </a>
            </div>
        </section>
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            {{ date('Y') }} © {{ config('constants.site_name') }}. All rights reserved.
        </div>
    </footer>
    <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
</div>