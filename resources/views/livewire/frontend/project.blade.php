<div>
    @push('styles')
    <style>
        @media (max-width: 786px) {
            /* Remove large top margin on slider section */
            .pt-4 {
                padding-top: 0 !important;
            }
            .pt-4 .text-center.mt-5 {
                margin-top: 0 !important;
            }

            /* Aavedan band alert - smaller on mobile */
            .alert.fs-20 {
                font-size: 13px !important;
                padding: 8px 14px !important;
                border-radius: 20px !important;
                margin-top: 8px !important;
            }

            /* Apply GIF - bigger on mobile */
            .apply-gif,
            img.apply-gif {
                width: 60% !important;
                max-width: 200px !important;
                height: auto !important;
                display: block !important;
                margin: 6px auto !important;
            }

            /* Info images - full width and proper fit */
            .col-lg-12 img.img-fluid {
                width: 100% !important;
                height: auto !important;
                object-fit: contain !important;
                display: block !important;
            }

            /* Reduce gap between sections */
            .row.mb-3 {
                margin-bottom: 4px !important;
            }

            /* Slider images full width */
            .swiper.home-slider img {
                width: 100% !important;
                height: auto !important;
                display: block !important;
            }
        }
    </style>
    @endpush
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
                                        <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}" class="w-100 d-block" />
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
                    <img src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="apply-gif" alt="Apply" style="width: 15%;">
                </a>
            @else
                <div class="alert alert-danger d-inline-block px-4 py-2 fw-bold fs-20 rounded-pill mt-3 shadow-sm">
                    <i class="ri-close-circle-fill align-middle me-1"></i> इस योजना के लिए आवेदन बंद हो गए हैं।
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        @foreach ($project->informationImages as $infoImage)
            <div class="col-lg-12 mb-0">
                <a href="{{ route('booking', $project->id) }}">
                    <img src="{{ asset($infoImage->image_path) }}" class="img-fluid w-100" alt="Project Info">
                </a>
            </div>
        @endforeach
    </div>
</div>