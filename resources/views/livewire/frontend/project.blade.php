<div>
    <!-- start hero section -->
    <div class="pt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-5">
                    <div class="swiper home-slider">
                        <div class="swiper-wrapper">
                            @foreach ($project->sliders as $slide)
                            <div class="swiper-slide">
                                @if($project->registration_status === 'open')
                                    <a href="{{ route('booking', $project->id) }}">
                                        <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}"
                                            class="w-100 d-block" />
                                    </a>
                                @else
                                    <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}"
                                        class="w-100 d-block" />
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            @if($project->registration_status === 'open')
                <a href="{{ route('booking', $project->id) }}" class="text-decoration-none">
                    <img src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="apply-gif" alt="Apply" style="width: 10%;">
                </a>
            @else
                <div class="alert alert-danger d-inline-block px-4 py-2 fw-bold fs-16 rounded-pill mt-3 shadow-sm">
                    <i class="ri-close-circle-fill align-middle me-1"></i> इस योजना के लिए रजिस्ट्रेशन बंद हो गए हैं।
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        @foreach ($project->informationImages as $infoImage)
        <div class="col-lg-12 mb-2">
            <a href="#"><img src="{{ asset($infoImage->image_path) }}" class="img-fluid w-100" alt="Project Info"></a>
        </div>
        @endforeach
    </div>
</div>