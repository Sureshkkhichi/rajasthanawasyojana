<div>
    @push('styles')
        <style>
            .announcement-bar {
                background: #dc2626;
                color: #ffffff;
                padding: 4px 0;
                width: 100%;
                overflow: hidden;
                box-sizing: border-box;
            }
            .announcement-bar .container-fluid,
            .announcement-bar .row,
            .announcement-bar .col-12 {
                margin: 0 !important;
                padding: 0 8px !important;
            }
            .announcement-bar marquee,
            .announcement-bar span {
                font-size: 13.5px;
                font-weight: 600;
                line-height: 1.2;
                margin: 0;
                padding: 2px 0;
                display: block;
                height: 22px;
            }
            @media (max-width: 576px) {
                .announcement-bar {
                    padding: 3px 0;
                }
                .announcement-bar marquee,
                .announcement-bar span {
                    font-size: 12px;
                    line-height: 1.2;
                    height: 18px;
                    padding: 1px 0;
                }
            }
            .home-slider img, .info-image-block img {
                width: 100%;
                height: auto;
                max-width: 100%;
                object-fit: contain;
                display: block;
            }
            .project-card {
                overflow: hidden;
                transition: .35s;
                border-radius: 12px;
            }

            .project-card .project-image-area {
                width: 100%;
                background: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 180px;
            }

            .project-card .project-image-area img {
                width: 100%;
                height: auto;
                max-height: 260px;
                object-fit: contain;
                display: block;
            }
        </style>
    @endpush
    {{-- Top Bar Section --}}
    @if ($top_bar_show && !empty($top_bar_text))
        <section class="announcement-bar">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        @if ($top_bar_marquee)
                            <marquee width="100%" direction="left" scrollamount="5">
                                {{ $top_bar_text }}
                            </marquee>
                        @else
                            <span>{{ $top_bar_text }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- Banner / Slider Section --}}
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="swiper home-slider">
                        <div class="swiper-wrapper">
                            @foreach ($home_sliders as $slide)
                                <div class="swiper-slide">
                                    <a href="{{ $this->getSliderUrl($slide) }}">
                                        <img src="{{ asset($slide->desktop_image) }}"
                                            alt="{{ $slide->project ? $slide->project->name : '' }}" class="w-100 d-block">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Bottom Bar Section --}}
    @if ($bottom_bar_show && !empty($bottom_bar_text))
        <section class="announcement-bar">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        @if ($bottom_bar_marquee)
                            <marquee width="100%" direction="left" scrollamount="5">
                                {{ $bottom_bar_text }}
                            </marquee>
                        @else
                            <span>{{ $bottom_bar_text }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section class="project-section py-2">
        <div class="container">
            {{-- Heading --}}
            <div class="row mb-3">
                <div class="col-lg-12 text-center">
                    <h2 class="project-heading mt-3">
                        वर्तमान आवासीय योजनाएँ
                    </h2>
                </div>
            </div>
            <div class="row g-4">
                @foreach($projects as $project)
                    <div class="col-sm-6 col-xl-3">
                        <div class="card project-card shadow-sm h-100">
                            <a href="{{ route('project.show', $project->slug) }}" class="text-decoration-none">
                                <div class="project-image-area">
                                    @if($project->featured_image)
                                        <img src="{{ asset($project->featured_image) }}" class="card-img-top img-fluid"
                                            alt="{{ $project->name }}">
                                    @else
                                        <img src="{{ asset('no-image.png') }}" class="card-img-top img-fluid"
                                            alt="{{ $project->name }}">
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="d-flex"
                                        style="flex-direction: row; justify-content: space-between; align-items: center;">
                                        <span class="text-dark fs-13 fw-semibold">
                                            <i class="ri-map-pin-line text-primary"></i>
                                            {{ $project->city }}
                                        </span>
                                        @if($project->registration_status === 'open')
                                            <span class="text-success fs-13 fw-semibold">
                                                <i class="ri-checkbox-circle-fill"></i>
                                                Registration Open
                                            </span>
                                        @else
                                            <span class="text-danger fs-13 fw-semibold">
                                                <i class="ri-close-circle-fill"></i>
                                                Registration Closed
                                            </span>
                                        @endif
                                    </div>
                                    <h4 class="card-title mt-2 mb-1"
                                        style="font-size: 16px; font-weight: 700; color: #212529;">{{ $project->name }}</h4>
                                    <p class="text-muted fs-12 mb-2"
                                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 36px;">
                                        <i class="ri-navigation-line me-1"></i>{{ $project->address }}
                                    </p>
                                    <div class="mt-2">
                                        <div class="text-muted fs-12 fw-bold" style="line-height: 1.2;">Starting@</div>
                                        <div style="font-size: 22px; color: #dc2626; font-weight: 800; line-height: 1.2;"
                                            class="d-flex align-items-baseline flex-wrap gap-1">
                                            <span>₹ {{ indianCurrency($project->price) }}/-</span>
                                            @if($project->inventory_type === 'plot')
                                                <span class="fs-13 fw-bold" style="color: #dc2626;">Sq. yards</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @if($project->registration_status === 'open')
                                <a href="{{ route('booking', $project->id) }}" class="text-decoration-none">
                                    <div class="card-footer text-center p-2 bg-white border-top-0 d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="apply-gif" alt="Apply"
                                            style="max-height: 48px; width: auto; max-width: 90%; object-fit: contain; margin: 0 auto;">
                                    </div>
                                </a>
                            @else
                                <div class="card-footer text-center py-2"
                                    style="background-color: #f8d7da; border-top: 1px solid #f5c2c7; margin: 0; padding: 0; height: 49px; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-danger fw-bold fs-14">
                                        <i class="ri-close-circle-fill align-middle me-1"></i> आवेदन बंद हो गए हैं
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- Information Section --}}
    <div class="row g-0">
        @foreach ($information_images as $info_img)
            <div class="col-lg-12 info-image-block">
                <a href="#">
                    <img src="{{ asset($info_img->image_path) }}" alt="Information Image" class="w-100 d-block img-fluid">
                </a>
            </div>
        @endforeach
    </div>
</div>