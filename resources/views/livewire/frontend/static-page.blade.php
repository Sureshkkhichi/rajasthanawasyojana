<div>
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
</div>
