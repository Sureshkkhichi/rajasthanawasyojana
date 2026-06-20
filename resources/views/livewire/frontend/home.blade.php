<div>
    <section class="" style="padding-top : 72px;">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-sm-10">
                <div class="text-center mt-lg-0 pt-0">
                    <marquee width="100%" direction="left">
                        सभी योजनाओं में आवेदन करने की अंतिम तिथि 07 दिसम्बर 2025 है। सभी योजनाओं के परिणाम
                        www.rajasthanawasyojana.com पर 10 दिसम्बर 2025 को घोषित किए जाएँगे।
                    </marquee>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end shape -->
    </section>
    <section>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="swiper home-slider">
                        <div class="swiper-wrapper">
                            @foreach ($home_sliders as $slide)
                                <div class="swiper-slide">
                                    <a href="{{ $slide->slider_url }}">
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
    <div class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <a href="https://rajasthanawasyojana.test/projects/avya-home"><img
                            src="{{ asset('dummy/aavya.png') }}" class="img-fluid logo-img" alt=""><br><img
                            src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="img-fluid avend-img" alt=""></a>
                </div>
                <div class="col-md-4">
                    <a href="https://rajasthanawasyojana.test/projects/avya-home"> <img
                            src="{{ asset('dummy/RukmaniNagarLogo.png') }}" class="img-fluid logo-img" alt=""><br><img
                            src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="img-fluid avend-img" alt=""></a>
                </div>
                <div class="col-md-4">
                    <a href="https://rajasthanawasyojana.test/projects/avya-home"> <img
                            src="{{ asset('dummy/NavNilyaFlatPriceLogo.png') }}" class="img-fluid logo-img"
                            alt=""><br><img src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="img-fluid avend-img"
                            alt=""></a>
                </div>
                <div class="col-md-4">
                    <a href="https://rajasthanawasyojana.test/projects/avya-home"><img
                            src="{{ asset('dummy/Samarddhi.png') }}" class="img-fluid logo-img" alt=""><br><img
                            src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" width="150px" height="100px"
                            class="img-fluid avend-img" alt=""></a>
                </div>
                <div class="col-md-4">
                    <a href="https://rajasthanawasyojana.test/projects/avya-home"><img
                            src="{{ asset('dummy/joypur.png') }}" class="img-fluid logo-img" alt=""><br><img
                            src="{{ asset('dummy/AVEDAN-KAREN-GIFF.gif') }}" class="img-fluid avend-img" alt=""></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a href="#">
                <img src="{{ asset('dummy/avedancontact.jpg') }}" alt="{{ $slide->title }}" class="w-100 d-block">
            </a>
        </div>
        <div class="col-lg-12">
            <a href="#">
                <img src="{{ asset('dummy/01.jpg') }}" alt="{{ $slide->title }}" class="w-100 d-block">
            </a>
        </div>
        <div class="col-lg-12">
            <a href="#">
                <img src="{{ asset('dummy/02.jpg') }}" alt="{{ $slide->title }}" class="w-100 d-block">
            </a>
        </div>
        <div class="col-lg-12">
            <a href="#">
                <img src="{{ asset('dummy/03.jpg') }}" alt="{{ $slide->title }}" class="w-100 d-block">
            </a>
        </div>
        <div class="col-lg-12">
            <a href="#">
                <img src="{{ asset('dummy/Footer-img.jpg') }}" alt="{{ $slide->title }}" class="w-100 d-block">
            </a>
        </div>
    </div>
</div>