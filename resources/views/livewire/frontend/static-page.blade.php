<div>
    <style>
        .static-page-content,
        .static-page-content * {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }
    </style>

    <section class="section bg-light" style="padding-top: 120px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row align-items-center mb-4 g-3">
                        <div class="col-auto">
                            <a href="{{ route('front') }}" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm">
                                <i class="ri-arrow-left-line fs-16"></i> Back to Home
                            </a>
                        </div>
                        <div class="col text-center me-md-5">
                            <h1 class="mb-0">{{ $page->title }}</h1>
                        </div>
                    </div>
                    <div class="bg-white border rounded p-4 p-md-5 static-page-content">
                        {!! $page->content ?: '<p>Content will be updated soon.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function () {
            var content = document.querySelector('.static-page-content');
            if (!content) return;

            // Disable right click
            content.addEventListener('contextmenu', function (e) {
                e.preventDefault();
                return false;
            });

            // Disable text selection via drag
            content.addEventListener('selectstart', function (e) {
                e.preventDefault();
                return false;
            });

            // Disable copy, cut, paste keyboard shortcuts
            document.addEventListener('keydown', function (e) {
                // Ctrl+C, Ctrl+X, Ctrl+A, Ctrl+U (view source), Ctrl+S
                if (e.ctrlKey && (
                    e.key === 'c' || e.key === 'C' ||
                    e.key === 'x' || e.key === 'X' ||
                    e.key === 'a' || e.key === 'A' ||
                    e.key === 'u' || e.key === 'U' ||
                    e.key === 's' || e.key === 'S'
                )) {
                    if (document.querySelector('.static-page-content')) {
                        e.preventDefault();
                        return false;
                    }
                }
            });

            // Disable drag of images/text inside content
            content.addEventListener('dragstart', function (e) {
                e.preventDefault();
                return false;
            });

            // Disable copy event
            content.addEventListener('copy', function (e) {
                e.preventDefault();
                return false;
            });

            // Disable cut event
            content.addEventListener('cut', function (e) {
                e.preventDefault();
                return false;
            });
        })();
    </script>
</div>

