<div>
    @section('styles')
        <link href="{{ asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
        <style>
            /* =========================
                            SALES OVERVIEW CARD
                        ========================= */

            .dashboard-sales-card,
            .dashboard-funnel-card {
                border: 0;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 8px rgba(0, 0, 0, .04);
            }

            .dashboard-sales-card .card-header,
            .dashboard-funnel-card .card-header {
                padding: 18px 20px;
                border-bottom: 1px solid #eef0f7;
            }

            .dashboard-sales-card .card-title,
            .dashboard-funnel-card .card-title {
                font-size: 20px;
                font-weight: 600;
                color: #495057;
            }

            .dashboard-sales-card .card-body {
                padding: 20px;
            }

            .dashboard-funnel-card .card-body {
                padding: 20px;
            }

            .dashboard-sales-card h3 {
                font-size: 18px;
                font-weight: 700;
                color: #495057;
                margin-bottom: 6px;
            }

            .dashboard-sales-card .text-muted {
                font-size: 14px;
            }

            .dashboard-sales-card .border-end {
                border-color: #eef0f7 !important;
            }

            #salesOverviewChart {
                height: 350px !important;
            }

            /* =========================
                            FUNNEL
                        ========================= */

            /* =========================
                            FUNNEL
                        ========================= */

            .lead-funnel-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
                padding-top: 15px;
                padding-bottom: 15px;
            }

            .funnel-stage-parent {
                filter: url(#round-corners);
                /* Rounds the child's polygon corners! */
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .funnel-stage {
                height: 50px;
                clip-path: polygon(8% 0%, 92% 0%, 84% 100%, 16% 100%);
                box-shadow: inset 0 1px 2px rgba(255, 255, 255, .25);
                transition: all 0.3s ease;
            }

            .funnel-stage:hover {
                opacity: 0.95;
                transform: scale(1.02);
            }

            /* Default widths for large desktop screens (>= 1400px) */
            .funnel-1 {
                width: 280px;
                background: linear-gradient(90deg, #8b5cf6, #6366f1);
            }

            .funnel-2 {
                width: 226px;
                background: linear-gradient(90deg, #5b8df9, #5570e8);
            }

            .funnel-3 {
                width: 182px;
                background: linear-gradient(90deg, #f7b84b, #f59e0b);
            }

            .funnel-4 {
                width: 146px;
                background: linear-gradient(90deg, #34c38f, #20c997);
            }

            /* =========================
                            FUNNEL RIGHT SIDE STATS
                        ========================= */

            .funnel-stat-item {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 6px !important;
                position: relative;
                height: 50px;
                /* Aligns vertically with 50px funnel stages */
            }

            .funnel-line {
                width: 6px;
                height: 6px;
                border-radius: 50%;
                flex-shrink: 0;
                position: relative;
                z-index: 2;
            }

            /* Connector Line Base */
            .funnel-line::before {
                content: "";
                position: absolute;
                right: 6px;
                /* start from the circle edge */
                top: 2px;
                /* vertically center inside 6px circle */
                height: 1px;
                background-color: #cbd5e1;
                z-index: 1;
                opacity: 0.5;
            }

            /* Connector Line Lengths for Desktop (>= 1400px) */
            @media(min-width: 1400px) {
                .funnel-stat-item:nth-child(1) .funnel-line::before {
                    width: 20px;
                }

                .funnel-stat-item:nth-child(2) .funnel-line::before {
                    width: 47px;
                }

                .funnel-stat-item:nth-child(3) .funnel-line::before {
                    width: 69px;
                }

                .funnel-stat-item:nth-child(4) .funnel-line::before {
                    width: 87px;
                }

                .funnel-stat-item:nth-child(5) .funnel-line::before {
                    width: 101px;
                }
            }

            /* Connector Line Lengths for Laptop (1200px to 1399px) */
            @media(min-width: 1200px) and (max-width: 1399px) {
                .funnel-stat-item:nth-child(1) .funnel-line::before {
                    width: 15px;
                }

                .funnel-stat-item:nth-child(2) .funnel-line::before {
                    width: 38px;
                }

                .funnel-stat-item:nth-child(3) .funnel-line::before {
                    width: 57px;
                }

                .funnel-stat-item:nth-child(4) .funnel-line::before {
                    width: 72px;
                }

                .funnel-stat-item:nth-child(5) .funnel-line::before {
                    width: 84px;
                }
            }

            /* Connector Line Lengths for Tablet (992px to 1199px) */
            @media(min-width: 992px) and (max-width: 1199px) {
                .funnel-stat-item:nth-child(1) .funnel-line::before {
                    width: 10px;
                }

                .funnel-stat-item:nth-child(2) .funnel-line::before {
                    width: 29px;
                }

                .funnel-stat-item:nth-child(3) .funnel-line::before {
                    width: 45px;
                }

                .funnel-stat-item:nth-child(4) .funnel-line::before {
                    width: 58px;
                }

                .funnel-stat-item:nth-child(5) .funnel-line::before {
                    width: 68px;
                }
            }

            /* Hide connector line on mobile when they stack vertically */
            @media(max-width: 991px) {
                .funnel-line::before {
                    display: none;
                }
            }

            .funnel-line-primary {
                background: #8b5cf6;
            }

            .funnel-line-info {
                background: #5b8df9;
            }

            .funnel-line-success {
                background: #34c38f;
            }

            .funnel-line-warning {
                background: #f7b84b;
            }

            .funnel-line-danger {
                background: #ff6b6b;
            }

            .funnel-stat-item .text-muted {
                font-size: 13px;
                margin-bottom: 2px;
                font-weight: 500;
            }

            .funnel-stat-item h3 {
                font-size: 18px;
                font-weight: 700;
                margin: 0;
            }

            /* =========================
                            FOOTER
                        ========================= */

            .dashboard-funnel-card .card-footer {
                padding: 18px 20px;
                border-top: 1px solid #eef0f7;
                background: #fff;
            }

            .dashboard-funnel-card h2 {
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 0;
            }

            .dashboard-funnel-card .badge {
                font-size: 12px !important;
                padding: 6px 10px;
            }

            .dashboard-funnel-card .avatar-md {
                width: 54px;
                height: 54px;
            }

            .dashboard-funnel-card .avatar-md i {
                font-size: 26px !important;
            }

            /* =========================
                            RESPONSIVE WIDTH ADJUSTMENTS (PREVENTS SQUISHING CHART)
                        ========================= */

            @media(max-width:1399px) {
                .funnel-1 {
                    width: 240px;
                }

                .funnel-2 {
                    width: 194px;
                }

                .funnel-3 {
                    width: 156px;
                }

                .funnel-4 {
                    width: 125px;
                }

                .funnel-stage {
                    height: 42px;
                }

                .funnel-stat-item {
                    height: 42px;
                }
            }

            @media(max-width:1199px) {
                .funnel-1 {
                    width: 200px;
                }

                .funnel-2 {
                    width: 162px;
                }

                .funnel-3 {
                    width: 130px;
                }

                .funnel-4 {
                    width: 104px;
                }

                .funnel-stage {
                    height: 40px;
                }

                .funnel-stat-item {
                    height: 40px;
                }
            }

            @media(max-width:991px) {
                .lead-funnel-wrapper {
                    margin-bottom: 30px;
                }

                .funnel-stat-item {
                    margin-bottom: 15px;
                    height: auto;
                }

                #salesOverviewChart {
                    height: 300px !important;
                }
            }

            /* =========================
                            CUSTOM APEXCHARTS STYLES
                        ========================= */
            .apexcharts-legend-marker {
                position: relative;
                overflow: visible !important;
            }

            .apexcharts-legend-marker::before {
                content: "";
                position: absolute;
                top: 3px;
                left: -6px;
                width: 20px;
                height: 2px;
                background: inherit;
                z-index: -1;
            }

            .apexcharts-legend-text {
                color: #495057 !important;
                font-family: "Poppins", "Inter", sans-serif !important;
                font-size: 13px !important;
                font-weight: 500 !important;
            }

            /* =========================
                            SALES OVERVIEW STATS LEFT ALIGN
                        ========================= */
            .sales-overview-stats .col-md-3 {
                text-align: left;
                padding-left: 20px;
            }

            .sales-overview-stats h3 {
                font-size: 18px !important;
                font-weight: 700 !important;
                color: #495057;
                margin-bottom: 6px;
            }

            .sales-overview-stats p {
                font-size: 12px !important;
                color: #878a99 !important;
                display: flex;
                align-items: center;
                gap: 6px;
                margin-bottom: 0;
            }

            .sales-overview-stats p i {
                font-size: 8px !important;
            }

            /* =========================
                            NEW ROW CARDS (PROJECT STATUS, DEALS, ACTIVITIES)
                        ========================= */
            .dashboard-status-card {
                border: 0 !important;
                border-radius: 12px !important;
                overflow: hidden;
                box-shadow: 0 1px 8px rgba(0, 0, 0, .04) !important;
                background: #fff;
            }

            .dashboard-status-card .card-header {
                padding: 18px 20px;
                border-bottom: 1px solid #eef0f7 !important;
                background: transparent;
            }

            .dashboard-status-card .card-title {
                font-size: 15px;
                font-weight: 600;
                color: #495057;
            }

            .dashboard-status-card .card-body {
                padding: 24px;
            }

            .activity-feed {
                display: flex;
                flex-direction: column;
                gap: 16px;
                width: 100%;
            }

            .activity-item {
                display: flex;
                align-items: center;
                gap: 12px;
                width: 100%;
            }

            .activity-icon-wrap {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .act-bg-success {
                background-color: #ecfdf5;
                color: #10b981;
            }

            .act-bg-indigo {
                background-color: #eff6ff;
                color: #3b82f6;
            }

            .act-bg-warning {
                background-color: #fffbeb;
                color: #f59e0b;
            }

            .act-bg-teal {
                background-color: #f0fdfa;
                color: #0d9488;
            }

            .act-bg-purple {
                background-color: #faf5ff;
                color: #8b5cf6;
            }

            .activity-item-content {
                flex-grow: 1;
            }

            .activity-item-content h5 {
                font-size: 13px;
                font-weight: 500;
                color: #343a40;
                margin-bottom: 2px;
            }

            .activity-item-content p {
                font-size: 11px;
                color: #878a99;
                margin: 0;
            }
        </style>
    @endsection
    <div class="page-content">
        <div class="container-fluid">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Good Morning, {{ auth()->user()->name }}!</h4>
                            <p class="text-muted mb-0">
                                Here's what's happening with your business today.
                            </p>
                        </div>
                        <div class="mt-3 mt-lg-0">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="text-muted fw-semibold fs-12 text-uppercase">From:</span>
                                    <input type="date" class="form-control border-0 minimal-border shadow"
                                        wire:model.live="fromDate" style="max-width: 145px; height: 38px;">
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <span class="text-muted fw-semibold fs-12 text-uppercase">To:</span>
                                    <input type="date" class="form-control border-0 minimal-border shadow"
                                        wire:model.live="toDate" style="max-width: 145px; height: 38px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Widgets --}}
            <div class="row">
                <!-- Total Leads -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('leads.index') }}" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Total Leads
                                        </p>
                                        <h2 class="mb-2">
                                            <span class="counter-value"
                                                data-target="{{ $totalLeads }}">{{ number_format($totalLeads) }}</span>
                                        </h2>
                                        <span class="fs-13 text-primary">
                                            View Leads
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-primary rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-user fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Active Projects -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('projects.index') }}" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Active Projects
                                        </p>
                                        <h2 class="mb-2">
                                            <span class="counter-value"
                                                data-target="{{ $activeProjects }}">{{ number_format($activeProjects) }}</span>
                                        </h2>
                                        <span class="fs-13 text-success">
                                            View Projects
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-success rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-buildings fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Upcoming Projects -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('projects.index') }}" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Upcoming Projects
                                        </p>
                                        <h2 class="mb-2">
                                            <span class="counter-value"
                                                data-target="{{ $upcomingProjects }}">{{ number_format($upcomingProjects) }}</span>
                                        </h2>
                                        <span class="fs-13 text-warning">
                                            View Projects
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-warning rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-calendar fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Total Deals -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('deals.index') }}" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Total Deals
                                        </p>
                                        <h2 class="mb-2">
                                            <span class="counter-value"
                                                data-target="{{ $totalDeals }}">{{ number_format($totalDeals) }}</span>
                                        </h2>
                                        <span class="fs-13 text-secondary">
                                            View Deals
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-secondary rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-heart fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Total Amount -->
                <div class="col-xl-3 col-md-6">
                    <a href="#" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Total Amount
                                        </p>
                                        <h2 class="mb-2">
                                            ₹ <span class="counter-value"
                                                data-target="{{ (int) $totalAmount }}">{{ number_format($totalAmount) }}</span>
                                        </h2>
                                        <span class="fs-13 text-info">
                                            View All
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-info rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-wallet fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Total Collection -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('deals.index') }}" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Total Collection
                                        </p>
                                        <h2 class="mb-2">
                                            ₹ <span class="counter-value"
                                                data-target="{{ (int) $totalCollection }}">{{ number_format($totalCollection) }}</span>
                                        </h2>
                                        <span class="fs-13 text-success">
                                            View All
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-success rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-rupee fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Total Refund -->
                <div class="col-xl-3 col-md-6">
                    <a href="{{ route('refunds.index') }}" class="dashboard-link">
                        <div class="card dashboard-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">
                                            Total Refund
                                        </p>
                                        <h2 class="mb-2">
                                            ₹ <span class="counter-value"
                                                data-target="{{ (int) $totalRefund }}">{{ number_format($totalRefund) }}</span>
                                        </h2>
                                        <span class="fs-13 text-danger">
                                            View All
                                        </span>
                                    </div>
                                    <div
                                        class="avatar-sm bg-gradient bg-danger rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-refresh fs-20 text-light"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- Sales Overview --}}
            <div class="row">
                <!-- Sales Overview -->
                <div class="col-xl-7">
                    <div class="card dashboard-sales-card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Sales Overview
                            </h4>
                        </div>
                        <div class="card-body pt-0">
                            <!-- Stats -->
                            <div class="row mb-4 sales-overview-stats">
                                <div class="col-md-4 border-end">
                                    <h3 class="mb-1 fw-semibold" title="₹ {{ number_format($totalCollection) }}">
                                        @if($totalCollection >= 10000000)
                                            ₹ {{ number_format($totalCollection / 10000000, 2) }} Cr
                                        @elseif($totalCollection >= 100000)
                                            ₹ {{ number_format($totalCollection / 100000, 2) }} L
                                        @else
                                            ₹ {{ number_format($totalCollection) }}
                                        @endif
                                    </h3>
                                    <p class="text-muted mb-0">
                                        <i class="ri-checkbox-blank-circle-fill text-primary me-1"></i>
                                        Total Collection
                                    </p>
                                </div>
                                <div class="col-md-4 border-end">
                                    <h3 class="mb-1 fw-semibold" title="₹ {{ number_format($bookingAmount) }}">
                                        @if($bookingAmount >= 10000000)
                                            ₹ {{ number_format($bookingAmount / 10000000, 2) }} Cr
                                        @elseif($bookingAmount >= 100000)
                                            ₹ {{ number_format($bookingAmount / 100000, 2) }} L
                                        @else
                                            ₹ {{ number_format($bookingAmount) }}
                                        @endif
                                    </h3>
                                    <p class="text-muted mb-0">
                                        <i class="ri-checkbox-blank-circle-fill text-success me-1"></i>
                                        Booking Amount
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <h3 class="mb-1 fw-semibold" title="₹ {{ number_format($totalRefund) }}">
                                        @if($totalRefund >= 10000000)
                                            ₹ {{ number_format($totalRefund / 10000000, 2) }} Cr
                                        @elseif($totalRefund >= 100000)
                                            ₹ {{ number_format($totalRefund / 100000, 2) }} L
                                        @else
                                            ₹ {{ number_format($totalRefund) }}
                                        @endif
                                    </h3>
                                    <p class="text-muted mb-0">
                                        <i class="ri-checkbox-blank-circle-fill text-danger me-1"></i>
                                        Refund Amount
                                    </p>
                                </div>
                            </div>
                            <!-- Chart -->
                            <div id="salesOverviewChart" style="height:350px;"></div>
                        </div>
                    </div>
                </div>
                <!-- Lead Conversion Funnel -->
                <div class="col-xl-5">
                    <div class="card dashboard-funnel-card card-height-100">
                        <div class="card-header border-0">
                            <h4 class="card-title mb-0">
                                Lead Conversion Funnel
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Funnel -->
                                <div class="col-lg-7">
                                    <div class="lead-funnel-wrapper">
                                        <div class="funnel-stage-parent">
                                            <div class="funnel-stage funnel-1"></div>
                                        </div>
                                        <div class="funnel-stage-parent">
                                            <div class="funnel-stage funnel-2"></div>
                                        </div>
                                        <div class="funnel-stage-parent">
                                            <div class="funnel-stage funnel-3"></div>
                                        </div>
                                        <div class="funnel-stage-parent">
                                            <div class="funnel-stage funnel-4"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Stats -->
                                <div class="col-lg-5">
                                    <div class="funnel-stat-item">
                                        <span class="funnel-line funnel-line-primary"></span>
                                        <div>
                                            <div class="text-muted">
                                                Total Leads
                                            </div>
                                            <h3 class="mb-0 text-primary">
                                                {{ number_format($totalLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="funnel-stat-item">
                                        <span class="funnel-line funnel-line-info"></span>
                                        <div>
                                            <div class="text-muted">
                                                In Process
                                            </div>
                                            <h3 class="mb-0 text-info">
                                                {{ number_format($inProcessLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="funnel-stat-item">
                                        <span class="funnel-line funnel-line-warning"></span>
                                        <div>
                                            <div class="text-muted">
                                                Unpaid
                                            </div>
                                            <h3 class="mb-0 text-warning">
                                                {{ number_format($unpaidLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="funnel-stat-item mb-0">
                                        <span class="funnel-line funnel-line-success"></span>
                                        <div>
                                            <div class="text-muted">
                                                Paid
                                            </div>
                                            <h3 class="mb-0 text-success">
                                                {{ number_format($paidLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0 pb-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fs-13">
                                        Conversion Rate
                                    </p>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <h2 class="mb-0 fw-bold fs-22">
                                            {{ $conversionRate }}%
                                        </h2>
                                        <span class="badge bg-success-subtle text-success fs-12 py-1 px-2 rounded">
                                            Live
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="avatar-md bg-light rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="ri-focus-2-line text-primary fs-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Row: Project Status, Deals by Stage, Recent Activities -->
            <div class="row mb-4">
                <!-- Project Status -->
                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Project Status</h4>
                        </div>
                        <div class="card-body">
                            <div id="project-status-source"
                                data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                data-colors-minimal='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                data-colors-interactive='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                data-colors-galaxy='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]'
                                class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>

                <!-- Financial Distribution -->
                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Financial Distribution</h4>
                        </div>
                        <div class="card-body">
                            <div id="deal-stage-source" data-colors='["--vz-success", "--vz-primary", "--vz-danger"]'
                                class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>

                <!-- Lead Status Distribution -->
                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Lead Status Distribution</h4>
                        </div>
                        <div class="card-body">
                            <div id="lead-status-distribution-chart"
                                data-colors='["--vz-info", "--vz-success", "--vz-warning"]' class="apex-charts"
                                dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Row: Collection vs Pending, Sales Trend & Upcoming Follow-ups -->
            <div class="row">
                <!-- Collection vs Pending -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Collection vs Refund <span
                                    class="text-muted fs-12 fw-normal">(This Month)</span></h4>
                        </div>
                        <div class="card-body">
                            <div id="collectionVsPendingChart" class="apex-charts" dir="ltr"
                                style="height: 280px; min-height: 280px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Sales Trend -->
                <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Sales Trend</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-2">
                                <span class="fw-bold text-dark fs-16" title="₹ {{ number_format($totalAmount) }}">
                                    @if($totalAmount >= 10000000)
                                        ₹ {{ number_format($totalAmount / 10000000, 2) }} Cr
                                    @elseif($totalAmount >= 100000)
                                        ₹ {{ number_format($totalAmount / 100000, 2) }} L
                                    @else
                                        ₹ {{ number_format($totalAmount) }}
                                    @endif
                                </span>
                            </div>
                            <div id="salesTrendChart" class="apex-charts" dir="ltr"
                                style="height: 250px; min-height: 250px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Follow-ups -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header border-0 align-items-center d-flex pb-0">
                            <h4 class="card-title mb-0 flex-grow-1">Upcoming Follow-ups</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <!-- Follow-up Item 1 -->
                                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-dashed"
                                    style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px; background-color: #eff6ff; color: #3b82f6; flex-shrink: 0;">
                                            <i class="ri-file-list-3-line fs-16"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-13 fw-semibold mb-0 text-dark">Follow up with Rahul Sharma
                                            </h5>
                                            <p class="text-muted mb-0 fs-12">Sunrise Residency</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-12 fw-medium text-dark">22 Jun 2026</span>
                                        <span class="fs-11 text-muted">10:30 AM</span>
                                    </div>
                                </div>

                                <!-- Follow-up Item 2 -->
                                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-dashed"
                                    style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px; background-color: #ecfdf5; color: #10b981; flex-shrink: 0;">
                                            <i class="ri-calendar-2-line fs-16"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-13 fw-semibold mb-0 text-dark">Meeting with Amit Singh</h5>
                                            <p class="text-muted mb-0 fs-12">Royal Homes</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-12 fw-medium text-dark">22 Jun 2026</span>
                                        <span class="fs-11 text-muted">03:00 PM</span>
                                    </div>
                                </div>

                                <!-- Follow-up Item 3 -->
                                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-dashed"
                                    style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px; background-color: #fff5f5; color: #f87171; flex-shrink: 0;">
                                            <i class="ri-phone-line fs-16"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-13 fw-semibold mb-0 text-dark">Call with Priya Verma</h5>
                                            <p class="text-muted mb-0 fs-12">Green Valley</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-12 fw-medium text-dark">23 Jun 2026</span>
                                        <span class="fs-11 text-muted">11:00 AM</span>
                                    </div>
                                </div>

                                <!-- Follow-up Item 4 -->
                                <div class="d-flex align-items-center justify-content-between pb-1"
                                    style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 38px; height: 38px; background-color: #faf5ff; color: #a855f7; flex-shrink: 0;">
                                            <i class="ri-map-pin-line fs-16"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-13 fw-semibold mb-0 text-dark">Site Visit - Elite Square</h5>
                                            <p class="text-muted mb-0 fs-12">Elite Square</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-12 fw-medium text-dark">24 Jun 2026</span>
                                        <span class="fs-11 text-muted">02:00 PM</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-1 w-100">
                                <a href="#" class="btn btn-light w-100 border fs-13 py-2 fw-medium"
                                    style="border: 1px solid #e2e8f0 !important; background-color: #fff; color: #495057; border-radius: 6px; transition: all 0.2s ease;">
                                    View Calendar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Peak Registration Hours Row -->
            <div class="row mb-4">
                <div class="col-xl-8">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Peak Registration Times (Hourly Trend)</h4>
                        </div>
                        <div class="card-body">
                            <div id="hourlyRegistrationChart" class="apex-charts" dir="ltr"
                                style="height: 300px; min-height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Time Analysis Insights</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div>
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px; flex-shrink: 0;">
                                            <i class="ri-time-line fs-20"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-14 fw-semibold mb-1 text-dark">Peak Traffic Period</h5>
                                            <p class="text-muted mb-0 fs-12" id="peak-period-text">Analyzing peak
                                                hours...</p>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-4">
                                        This chart displays the hourly distribution of lead registrations. Use this data
                                        to optimize sales team shifts, ad campaign schedules, and automated follow-ups.
                                    </p>
                                </div>
                                <div class="bg-light p-3 rounded" style="border: 1px solid #eef0f7;">
                                    <h6 class="fs-13 fw-semibold text-dark mb-2">Campaign Tip:</h6>
                                    <p class="text-muted fs-12 mb-0">
                                        Schedule bulk promotional notifications and SMS blasts 1 hour before the peak
                                        traffic period to maximize open rates and engagement.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Age Wise & City Wise Row -->
            <div class="row mb-4">
                {{-- Age-wise Distribution --}}
                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Age Wise Distribution</h4>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div id="ageWiseChart" class="apex-charts" dir="ltr"
                                style="height: 320px; min-height: 320px;"></div>
                        </div>
                    </div>
                </div>
                {{-- City-wise Distribution --}}
                <div class="col-xl-6">
                    <div class="card card-height-100">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">City Wise Distribution (Top 10)</h4>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-center">
                            <div id="cityWiseChart" class="apex-charts" dir="ltr"
                                style="height: 320px; min-height: 320px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Row: Business Summary -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card dashboard-status-card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Business Summary</h4>
                        </div>
                        <div class="card-body py-4">
                            <div class="row align-items-center">
                                <!-- Total Customers -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px; background-color: #f3e8ff; color: #7c3aed; flex-shrink: 0;">
                                            <i class="ri-user-shared-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Total Customers
                                            </p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">
                                                    {{ number_format($totalLeads) }}
                                                </h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Invoices -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px; background-color: #eff6ff; color: #3b82f6; flex-shrink: 0;">
                                            <i class="ri-file-text-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Total Invoices
                                            </p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">
                                                    {{ number_format($submittedLeads) }}
                                                </h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paid Invoices -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px; background-color: #ecfdf5; color: #10b981; flex-shrink: 0;">
                                            <i class="ri-handshake-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Paid Invoices
                                            </p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">{{ number_format($paidLeads) }}
                                                </h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unpaid Invoices -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px; background-color: #fff5f5; color: #ef4444; flex-shrink: 0;">
                                            <i class="ri-file-warning-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Unpaid Invoices
                                            </p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">
                                                    {{ number_format($pendingLeads) }}
                                                </h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Refunds -->
                                <div class="col">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 42px; height: 42px; background-color: #fff7ed; color: #f97316; flex-shrink: 0;">
                                            <i class="ri-refund-2-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Refunds</p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">
                                                    @if($totalRefund >= 10000000)
                                                        ₹ {{ number_format($totalRefund / 10000000, 2) }} Cr
                                                    @elseif($totalRefund >= 100000)
                                                        ₹ {{ number_format($totalRefund / 100000, 2) }} L
                                                    @else
                                                        ₹ {{ number_format($totalRefund) }}
                                                    @endif
                                                </h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SVG Filter for Rounded Corners on clip-path polygons -->
    <svg style="position: absolute; width: 0; height: 0;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <filter id="round-corners">
                <feGaussianBlur in="SourceGraphic" stdDeviation="3" result="blur" />
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"
                    result="goo" />
                <feComposite in="SourceGraphic" in2="goo" operator="atop" />
            </filter>
        </defs>
    </svg>

    @section('scripts')
        <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>
        <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var options = {
                    series: [{
                        name: "Collection",
                        data: @json($salesTrendCollection)
                    }, {
                        name: "Booking Amount",
                        data: @json($salesTrendBooking)
                    }, {
                        name: "Refund Amount",
                        data: @json($salesTrendRefund)
                    }],
                    chart: {
                        height: 350,
                        type: "line",
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        },
                        dropShadow: {
                            enabled: true,
                            top: 6,
                            left: 0,
                            blur: 4,
                            color: [
                                "#4F6DF5", // Collection
                                "#34C38F", // Booking
                                "#F46A6A" // Refund
                            ],
                            opacity: 0.18
                        }
                    },
                    stroke: {
                        width: 3,
                        curve: "smooth"
                    },
                    markers: {
                        size: 4,
                        strokeColors: "#fff",
                        strokeWidth: 2,
                        hover: {
                            size: 6
                        }
                    },
                    colors: [
                        "#4F6DF5", // Collection
                        "#34C38F", // Booking
                        "#F46A6A" // Refund
                    ],
                    grid: {
                        borderColor: "#eef1f7",
                        strokeDashArray: 4
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: @json($salesTrendDays),
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        tickAmount: 5,
                        labels: {
                            rotate: 0,
                            style: {
                                colors: '#878a99',
                                fontSize: '12px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        }
                    },
                    yaxis: {
                        min: 0,
                        tickAmount: 5,
                        labels: {
                            formatter: function (value) {
                                return value === 0 ? "0" : value + "L";
                            },
                            style: {
                                colors: '#878a99',
                                fontSize: '12px',
                                fontFamily: 'Inter, sans-serif'
                            }
                        }
                    },
                    legend: {
                        position: "bottom",
                        horizontalAlign: "center",
                        fontSize: "13px",
                        offsetY: 8,
                        markers: {
                            width: 8,
                            height: 8,
                            radius: 12
                        }
                    },
                    tooltip: {
                        shared: true,
                        intersect: false
                    }
                };
                window.salesOverviewChart = new ApexCharts(
                    document.querySelector("#salesOverviewChart"), options
                );
                window.salesOverviewChart.render();
            });

            // Financial Distribution
            var chartDeals = getChartColorsArray("deal-stage-source");
            if (chartDeals) {
                var options = {
                    series: [@json($totalCollection), @json($bookingAmount), @json($totalRefund)],
                    labels: ["Total Collection", "Booking Amount", "Total Refund"],
                    chart: {
                        height: 333,
                        type: "donut",
                    },
                    legend: {
                        position: "bottom",
                    },
                    stroke: {
                        show: false
                    },
                    dataLabels: {
                        dropShadow: {
                            enabled: false,
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "₹" + val.toLocaleString('en-IN');
                            }
                        }
                    },
                    colors: chartDeals,
                };

                window.dealsChart = new ApexCharts(
                    document.querySelector("#deal-stage-source"), options
                );
                window.dealsChart.render();
            }

            // Lead Status Distribution
            var chartLeadStatus = getChartColorsArray("lead-status-distribution-chart");
            if (chartLeadStatus) {
                var leadStatusOptions = {
                    series: [@json($inProcessLeads), @json($paidLeads), @json($unpaidLeads)],
                    labels: ["In Process", "Paid", "Unpaid"],
                    chart: {
                        height: 333,
                        type: "donut",
                    },
                    legend: {
                        position: "bottom",
                    },
                    stroke: {
                        show: false
                    },
                    dataLabels: {
                        dropShadow: {
                            enabled: false,
                        },
                    },
                    colors: chartLeadStatus,
                };

                window.leadStatusChart = new ApexCharts(
                    document.querySelector("#lead-status-distribution-chart"), leadStatusOptions
                );
                window.leadStatusChart.render();
            }

            // Project Status
            var chartProjectStatus = getChartColorsArray("project-status-source");
            if (chartProjectStatus) {
                var options = {
                    series: @json($projectStatusData),
                    labels: @json($projectStatusLabels),
                    chart: {
                        height: 333,
                        type: "donut",
                    },
                    legend: {
                        position: "bottom",
                    },
                    stroke: {
                        show: false
                    },
                    dataLabels: {
                        dropShadow: {
                            enabled: false,
                        },
                    },
                    colors: chartProjectStatus,
                };

                window.projectStatusChart = new ApexCharts(
                    document.querySelector("#project-status-source"), options
                );
                window.projectStatusChart.render();
            }

            // Collection vs Refund Chart
            var collectionVsPendingOptions = {
                series: [{
                    name: 'Collection',
                    data: @json($weeklyCollection)
                }, {
                    name: 'Refund',
                    data: @json($weeklyRefund)
                }],
                chart: {
                    type: 'bar',
                    height: 280,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 4
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ['#3b82f6', '#ef4444'],
                xaxis: {
                    categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return val.toFixed(2) + " Lac";
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetY: 8,
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 2
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            var fullAmount = Math.round(val * 100000);
                            return "₹" + fullAmount.toLocaleString('en-IN');
                        }
                    }
                }
            };

            window.collectionVsPendingChart = new ApexCharts(
                document.querySelector("#collectionVsPendingChart"), collectionVsPendingOptions
            );
            window.collectionVsPendingChart.render();

            // Sales Trend Chart
            var salesTrendOptions = {
                series: [{
                    name: 'This Month',
                    data: [8, 12, 17, 23, 20, 25, 33, 24, 32, 31, 37, 41]
                }, {
                    name: 'Last Month',
                    data: [8, 10, 15, 12, 20, 18, 20, 32, 28, 37, 35, 34]
                }],
                chart: {
                    type: 'area',
                    height: 250,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: [3, 2]
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: [0.35, 0],
                        opacityTo: [0.05, 0],
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#3b82f6', '#94a3b8'],
                xaxis: {
                    categories: ['01 Jun', '', '', '07 Jun', '', '', '13 Jun', '', '', '19 Jun', '', '21 Jun'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return val + "L";
                        }
                    },
                    max: 50
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    offsetY: 8,
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 2
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " L";
                        }
                    }
                }
            };

            window.salesTrendChart = new ApexCharts(
                document.querySelector("#salesTrendChart"), salesTrendOptions
            );
            window.salesTrendChart.render();

            // Hourly Registration Chart
            var hourlyData = @json($hourlyData);
            var hourlyLabels = @json($hourlyLabels);

            var hourlyRegistrationOptions = {
                series: [{
                    name: 'Registrations',
                    data: hourlyData
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#6366f1'],
                xaxis: {
                    categories: hourlyLabels,
                    labels: {
                        rotate: -45,
                        rotateAlways: false,
                        style: {
                            colors: '#878a99',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return Math.round(val);
                        },
                        style: {
                            colors: '#878a99',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                grid: {
                    borderColor: "#eef1f7",
                    strokeDashArray: 4
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " leads";
                        }
                    }
                }
            };

            window.hourlyRegistrationChart = new ApexCharts(
                document.querySelector("#hourlyRegistrationChart"), hourlyRegistrationOptions
            );
            window.hourlyRegistrationChart.render();

            // Calculate and display peak hour text
            let maxVal = -1;
            let maxIndex = -1;
            for (let i = 0; i < hourlyData.length; i++) {
                if (hourlyData[i] > maxVal) {
                    maxVal = hourlyData[i];
                    maxIndex = i;
                }
            }

            let peakPeriodText = "No registrations recorded yet.";
            if (maxVal > 0) {
                let peakHour = hourlyLabels[maxIndex];
                let nextHour = hourlyLabels[(maxIndex + 1) % 24];
                peakPeriodText =
                    `Most registrations occur between <strong>${peakHour}</strong> and <strong>${nextHour}</strong> (${maxVal} leads total).`;
            }
            document.getElementById('peak-period-text').innerHTML = peakPeriodText;

            // Age Wise Chart (Donut)
            var ageData = @json($ageData);
            var ageLabels = @json($ageLabels);
            var ageWiseOptions = {
                series: ageData,
                labels: ageLabels,
                chart: {
                    type: 'donut',
                    height: 320,
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontFamily: 'Inter, sans-serif',
                    labels: {
                        colors: '#878a99'
                    }
                },
                dataLabels: {
                    enabled: true,
                    dropShadow: {
                        enabled: false
                    }
                },
                colors: ['#0ab39c', '#405189', '#3577f1', '#f7b84b', '#f06548', '#299cdb'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Leads',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };
            window.ageWiseChart = new ApexCharts(document.querySelector("#ageWiseChart"), ageWiseOptions);
            window.ageWiseChart.render();

            // City Wise Chart (Bar)
            var cityData = @json($cityData);
            var cityLabels = @json($cityLabels);
            var cityWiseOptions = {
                series: [{
                    name: 'Leads',
                    data: cityData
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                        distributed: true,
                        barHeight: '60%'
                    }
                },
                colors: ['#3577f1', '#0ab39c', '#f7b84b', '#f06548', '#299cdb', '#a855f7', '#6366f1', '#ec4899', '#14b8a6',
                    '#f43f5e'
                ],
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val;
                    },
                    offsetX: 10,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                grid: {
                    borderColor: "#eef1f7",
                    strokeDashArray: 4
                },
                xaxis: {
                    categories: cityLabels,
                    labels: {
                        style: {
                            colors: '#878a99',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#878a99',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                },
                legend: {
                    show: false
                }
            };
            window.cityWiseChart = new ApexCharts(document.querySelector("#cityWiseChart"), cityWiseOptions);
            window.cityWiseChart.render();

            window.addEventListener('dashboard-updated', event => {
                const detail = Array.isArray(event.detail) ? event.detail[0] : (event.detail && typeof event.detail ===
                    'object' ? event.detail : {});
                if (!detail) return;

                if (window.salesOverviewChart) {
                    window.salesOverviewChart.updateSeries([{
                        name: "Collection",
                        data: detail.salesTrendCollection
                    },
                    {
                        name: "Booking Amount",
                        data: detail.salesTrendBooking
                    },
                    {
                        name: "Refund Amount",
                        data: detail.salesTrendRefund
                    }
                    ]);
                    window.salesOverviewChart.updateOptions({
                        xaxis: {
                            categories: detail.salesTrendDays
                        }
                    });
                }

                if (window.dealsChart) {
                    window.dealsChart.updateSeries([
                        Number(detail.totalCollection) || 0,
                        Number(detail.bookingAmount) || 0,
                        Number(detail.totalRefund) || 0
                    ]);
                }

                if (window.leadStatusChart) {
                    window.leadStatusChart.updateSeries([
                        Number(detail.inProcessLeads) || 0,
                        Number(detail.paidLeads) || 0,
                        Number(detail.unpaidLeads) || 0
                    ]);
                }

                if (window.projectStatusChart) {
                    window.projectStatusChart.updateSeries(detail.projectStatusData || []);
                }

                if (window.collectionVsPendingChart) {
                    window.collectionVsPendingChart.updateSeries([{
                        name: "Collection",
                        data: detail.weeklyCollection || []
                    }, {
                        name: "Refund",
                        data: detail.weeklyRefund || []
                    }]);
                }

                if (window.salesTrendChart) {
                    window.salesTrendChart.updateSeries([{
                        name: "Collection",
                        data: detail.salesTrendCollection || []
                    },
                    {
                        name: "Booking Amount",
                        data: detail.salesTrendBooking || []
                    },
                    {
                        name: "Refund Amount",
                        data: detail.salesTrendRefund || []
                    }
                    ]);
                    window.salesTrendChart.updateOptions({
                        xaxis: {
                            categories: detail.salesTrendDays || []
                        }
                    });
                }

                if (window.hourlyRegistrationChart) {
                    window.hourlyRegistrationChart.updateSeries([{
                        name: "Registrations",
                        data: detail.hourlyData || []
                    }]);
                }

                if (window.ageWiseChart) {
                    window.ageWiseChart.updateSeries(detail.ageData || []);
                }

                if (window.cityWiseChart) {
                    window.cityWiseChart.updateSeries([{
                        name: "Leads",
                        data: detail.cityData || []
                    }]);
                    window.cityWiseChart.updateOptions({
                        xaxis: {
                            categories: detail.cityLabels || []
                        }
                    });
                }
            });
        </script>
    @endsection
</div>