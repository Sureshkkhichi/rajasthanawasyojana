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