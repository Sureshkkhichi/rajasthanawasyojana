<div>
    {{-- Top Bar Section --}}
    @if ($top_bar_show && !empty($top_bar_text))
        <section class=""
            style="padding-top: 72px; background: #ff0000; color: #ffffff; min-height: 40px; display: flex; align-items: center;">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 text-center fs-15 fw-bold">
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
    @else
        <div style="padding-top: 72px;"></div>
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
                                        <img src="{{ asset($slide->desktop_image) }}" alt="{{ $slide->title }}"
                                            class="w-100 d-block">
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
        <section class=""
            style="background: #ff0000; color: #ffffff; min-height: 40px; display: flex; align-items: center; margin-top: 0px; margin-bottom: 0px;">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 text-center fs-15 fw-bold">
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

    {{-- Projects Grid Section --}}
    <div class="py-5">
        <div class="container">
            <div class="row text-center justify-content-center">
                @foreach ($projects as $project)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('project.show', $project->slug) }}">
                            @if ($project->featured_image)
                                <img src="{{ asset($project->featured_image) }}" class="img-fluid logo-img" alt="{{ $project->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center border rounded bg-light logo-img mb-2" style="height: 200px;">
                                    <span class="text-muted fw-bold">{{ $project->name }}</span>
                                </div>
                            @endif
                            @if ($project->price)
                                <div class="mt-2 text-danger fw-bold fs-16">{{ $project->price }}</div>
                            @endif
                            <br>
                            <img src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="img-fluid avend-img" alt="Avedan Karen">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Information Section --}}
    <div class="row">
        @foreach ($information_images as $info_img)
            <div class="col-lg-12">
                <a href="#">
                    <img src="{{ asset($info_img->image_path) }}" alt="Information Image" class="w-100 d-block">
                </a>
            </div>
        @endforeach
    </div>
</div>