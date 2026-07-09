<div>
    <!-- Start footer -->
    <footer class="text-center text-lg-start bg-light text-muted">
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <div class="me-5 d-none d-lg-block">
                <span>Rajasthan Awas Realty Group | Apka Sath Sabka Vikas </span>
            </div>
            <div>
                <a href="{{ route('pages.terms') }}" class="me-4 text-reset">
                    Term and Condition
                </a>
                <a href="{{ route('pages.privacy') }}" class="me-4 text-reset">
                    Privacy policy
                </a>
                <a href="{{ route('pages.refund-policy') }}" class="me-4 text-reset">
                    Cancellation Refund policy
                </a>
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