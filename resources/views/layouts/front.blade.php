<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>
        {{ isset($Title) ? $Title . ' | ' . config('constants.site_name') : config('constants.site_name') . ' | ' . "Ghar Ka Sapna, Ab Hoga Apna" }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('constants.site_description') }}" name="description" />
    <meta content="{{ config('constants.site_author') }}" name="author" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    <!-- Sweet Alert css-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

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
        .custom-header,
        .custom-header.is-sticky,
        nav.custom-header {
            background-color: #ffffff !important;
            background: #ffffff !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, .12) !important;
            z-index: 99999 !important;
            padding: 8px 0;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            opacity: 1 !important;
        }

        .custom-header .container {
            max-width: 1400px;
        }

        /* Desktop Styles */
        @media (min-width: 992px) {
            .header-logo img {
                height: 72px;
                width: auto;
            }
            .header-contact {
                gap: 50px;
            }
            .header-contact a {
                font-size: 46px;
                font-weight: 700;
            }
            .header-rera {
                font-size: 13px !important;
                padding: 4px 12px;
            }
        }

        .header-logo img {
            height: 52px;
            width: auto;
            max-width: 100%;
            object-fit: contain;
        }

        .header-rera {
            padding: 3px 8px;
            white-space: nowrap;
            display: inline-block;
            color: #4a2100;
            font-weight: 700;
            font-size: 11px !important;
            line-height: 1.2;
            background: #fdf6ea;
            border: 1px solid #f3e5d0;
            border-radius: 4px;
        }

        .header-contact {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 20px;
        }

        .header-contact a {
            color: #4a2100;
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
            transition: .3s;
            line-height: 1;
            white-space: nowrap;
        }

        .header-contact a:hover {
            color: #dc2626;
        }

        @media (max-width: 991px) {
            .header-logo img {
                height: 44px;
            }
            .header-contact a {
                font-size: 18px;
            }
            .header-contact {
                gap: 12px;
            }
        }

        @media (max-width: 576px) {
            .custom-header {
                padding: 6px 0;
            }
            .header-logo img {
                height: 38px;
            }
            .header-rera {
                font-size: 10px !important;
                padding: 2px 5px;
            }
            .header-contact {
                flex-direction: column;
                align-items: flex-end;
                gap: 2px;
            }
            .header-contact a {
                font-size: 14px;
                font-weight: 800;
            }
        }
    </style>
</head>

<body>
    <div class="layout-wrapper landing" style="padding-top: 68px;">
        <nav class="navbar fixed-top custom-header">
            <div class="container">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <!-- Left Logo & RERA -->
                    <div class="d-flex align-items-center gap-2">
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
                    <!-- Right Contact Phone Numbers -->
                    <div class="header-contact">
                        @php
                            $mobile1 = \App\Models\FrontendSetting::getVal('mobile_number_1', '9876543210');
                            $mobile2 = \App\Models\FrontendSetting::getVal('mobile_number_2', '9876543210');
                        @endphp
                        @if(!empty($mobile1))
                            <a href="tel:+91{{ $mobile1 }}">
                                {{ $mobile1 }}
                            </a>
                        @endif
                        @if(!empty($mobile2))
                            <a href="tel:+91{{ $mobile2 }}">
                                {{ $mobile2 }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>
        {{ $slot ?? '' }}
        @yield('content')
        <livewire:frontend.components.footer />
    </div>

    @php
        $floatPhone = \App\Models\FrontendSetting::getVal('mobile_number_1', '9587044244');
        $cleanPhone = preg_replace('/[^0-9]/', '', $floatPhone);
    @endphp
    @if(!empty($cleanPhone))
        <div class="floating-contact-buttons">
            <a href="https://wa.me/91{{ $cleanPhone }}?text=Hello" target="_blank" class="floating-btn btn-whatsapp" title="Chat on WhatsApp" aria-label="WhatsApp">
                <i class="ri-whatsapp-fill"></i>
            </a>
            <a href="tel:+91{{ $cleanPhone }}" class="floating-btn btn-phone" title="Call Us" aria-label="Call">
                <i class="ri-phone-fill"></i>
            </a>
        </div>
    @endif

    <style>
        .floating-contact-buttons {
            position: fixed;
            bottom: 80px;
            right: 25px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff !important;
            font-size: 26px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none !important;
        }

        .floating-btn:hover {
            transform: scale(1.12);
            color: #fff !important;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
        }

        .btn-whatsapp {
            background-color: #25D366;
        }

        .btn-phone {
            background-color: #0d6efd;
        }

        @media (max-width: 576px) {
            .floating-contact-buttons {
                bottom: 75px;
                right: 15px;
                gap: 10px;
            }

            .floating-btn {
                width: 44px;
                height: 44px;
                font-size: 22px;
            }
        }
    </style>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/landing.init.js') }}"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')
    @livewireScripts
    <script>
        function formatPanInput(el) {
            let val = el.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            let formatted = '';
            for (let i = 0; i < val.length && i < 10; i++) {
                let char = val[i];
                if (i < 5) {
                    if (/[A-Z]/.test(char)) formatted += char;
                } else if (i < 9) {
                    if (/[0-9]/.test(char)) formatted += char;
                } else {
                    if (/[A-Z]/.test(char)) formatted += char;
                }
            }
            el.value = formatted;
        }
    </script>
</body>

</html>