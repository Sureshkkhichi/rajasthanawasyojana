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
        @forelse ($project->informationImages as $infoImage)
            <div class="col-lg-12 mb-2">
                <a href="#"><img src="{{ asset($infoImage->image_path) }}" class="img-fluid w-100" alt="Project Info"></a>
            </div>
        @empty
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/avedancontact.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/04.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/05.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/06.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/07.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/08.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/09.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/10.jpg') }}" class="img-fluid w-100"></a>
            </div>
            <div class="col-lg-12">
                <a href="#"><img src="{{ asset('dummy/avedancontact.jpg') }}" class="img-fluid w-100"></a>
            </div>
        @endforelse
    </div>
</div>