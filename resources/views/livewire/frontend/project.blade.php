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
                                <a href="{{ route('booking', $project->id) }}">
                                    <img src="{{ asset($slide->image) }}" alt="{{ $slide->title }}"
                                        class="w-100 d-block" />
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="{{ route('booking', $project->id) }}" class="text-decoration-none">
                <img src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="apply-gif" alt="Apply" style="width: 10%;">
            </a>
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