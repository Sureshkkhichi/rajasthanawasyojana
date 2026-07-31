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
                    <div class="text-center mb-4">
                        <h1 class="mb-2">{{ $page->title }}</h1>
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

