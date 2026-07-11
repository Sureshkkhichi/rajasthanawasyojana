<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>{{ isset($Title) ? $Title . ' | ' . config('constants.site_name') : config('constants.site_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('constants.site_description') }}" name="description" />
    <meta content="{{ config('constants.site_author') }}" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    @livewireStyles
    @stack('styles')
    <style>
        .custom-header {
            background: #fffdf6;
            /* background-image: url('{{ asset("assets/images/header.jpg") }}'); */
            background-repeat: no-repeat;
            background-size: 100% 100%;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 15px rgba(0, 0, 0, .08);
            z-index: 999;
            height: auto;
        }

        .custom-header .container {
            max-width: 1400px;
        }

        .header-logo img {
            height: 72px;
            width: auto;
        }

        .digital-logo {
            height: 58px;
            width: auto;
        }

        .header-rera {
            font-size: 30px;
            font-weight: 700;
            color: #212529;
            background-color: #f8f9fa;
            padding: 4px 14px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            margin-left: 20px;
            white-space: nowrap;
            display: inline-block;
        }

        .header-contact {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 50px;
        }

        .header-contact a {
            color: #4a2100;
            font-size: 46px;
            font-weight: 700;
            text-decoration: none;
            transition: .3s;
            line-height: 1;
        }

        .header-contact a:hover {
            color: #d62939;
        }

        @media(max-width:991px) {
            .custom-header {
                height: 88px;
            }

            .header-logo img {
                height: 54px;
            }

            .header-contact {
                gap: 15px;
                justify-content: flex-end;
            }

            .header-contact a {
                font-size: 18px;
            }

            .header-rera {
                font-size: 16px;
                margin-left: 10px;
                padding: 2px 8px;
            }
        }

        @media(max-width:576px) {
            .custom-header {
                height: 88px;
            }

            .header-logo img {
                height: 46px;
            }

            .header-contact {
                flex-direction: column;
                align-items: flex-end;
                gap: 2px;
            }

            .header-contact a {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper landing">
        <nav class="navbar navbar-expand-lg fixed-top custom-header">
            <div class="container">
                <div class="row w-100 align-items-center">
                    <div class="col-lg-8 col-12 d-flex flex-wrap align-items-center gap-2 order-1 justify-content-center justify-content-lg-start">
                        <a href="{{ route('front') }}" class="header-logo">
                            @php
                                $siteLogo = \App\Models\FrontendSetting::getVal('site_logo');
                            @endphp
                            <img src="{{ $siteLogo ? asset($siteLogo) : asset('jda-logo.png') }}" class="img-fluid"
                                alt="{{ config('constants.site_name') }}">
                        </a>
                        @php
                            $reraNumber = \App\Models\FrontendSetting::getVal('rera_number');
                        @endphp
                        @if(!empty($reraNumber))
                            <span class="header-rera">RERA No: {{ $reraNumber }}</span>
                        @endif
                    </div>
                    {{-- Right Contact --}}
                    <div class="col-lg-4 col-12 order-2 mt-2 mt-lg-0">
                        <div class="header-contact justify-content-center justify-content-lg-end">
                            @php
                                $mobile1 = \App\Models\FrontendSetting::getVal('mobile_number_1', '9876543210');
                                $mobile2 = \App\Models\FrontendSetting::getVal('mobile_number_2', '9876543210');
                            @endphp
                            @if(!empty($mobile1))
                                <a href="tel:+91{{ $mobile1 }}" class="fs-2">
                                    {{ $mobile1 }}
                                </a>
                            @endif
                            @if(!empty($mobile2))
                                <a href="tel:+91{{ $mobile2 }}" class="fs-2">
                                    {{ $mobile2 }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>
        {{ $slot }}
        <livewire:frontend.components.footer />
    </div>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/landing.init.js') }}"></script>
    @stack('scripts')
    @livewireScripts
</body>

</html>