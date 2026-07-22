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
            background: linear-gradient(90deg, #34c38f, #20c997);
        }

        .funnel-4 {
            width: 146px;
            background: linear-gradient(90deg, #f7b84b, #f59e0b);
        }

        .funnel-5 {
            width: 118px;
            background: linear-gradient(90deg, #ff6b6b, #ff4d4f);
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

            .funnel-5 {
                width: 101px;
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

            .funnel-5 {
                width: 84px;
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
                            <form action="javascript:void(0);">
                                <div class="row g-3 mb-0 align-items-center">
                                    <div class="col-sm-auto">
                                        <div class="input-group">
                                            <input type="text" class="form-control border-0 minimal-border dash-filter-picker shadow" data-provider="flatpickr" data-range-date="true" data-date-format="d M, Y" data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                            <div class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-2-line"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                            <span class="counter-value" data-target="{{ $totalLeads }}">0</span>
                                        </h2>
                                        <span class="fs-13 text-primary">
                                            View Leads
                                        </span>
                                    </div>
                                    <div class="avatar-sm bg-gradient bg-primary rounded d-flex align-items-center justify-content-center">
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
                                            <span class="counter-value" data-target="{{ $activeProjects }}">0</span>
                                        </h2>
                                        <span class="fs-13 text-success">
                                            View Projects
                                        </span>
                                    </div>
                                    <div class="avatar-sm bg-gradient bg-success rounded d-flex align-items-center justify-content-center">
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
                                            <span class="counter-value" data-target="{{ $upcomingProjects }}">0</span>
                                        </h2>
                                        <span class="fs-13 text-warning">
                                            View Projects
                                        </span>
                                    </div>
                                    <div class="avatar-sm bg-gradient bg-warning rounded d-flex align-items-center justify-content-center">
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
                                            <span class="counter-value" data-target="{{ $totalDeals }}">0</span>
                                        </h2>
                                        <span class="fs-13 text-secondary">
                                            View Deals
                                        </span>
                                    </div>
                                    <div class="avatar-sm bg-gradient bg-secondary rounded d-flex align-items-center justify-content-center">
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
                                            ₹ <span class="counter-value" data-target="{{ (int)$totalAmount }}">0</span>
                                        </h2>
                                        <span class="fs-13 text-info">
                                            View All
                                        </span>
                                    </div>
                                    <div class="avatar-sm bg-gradient bg-info rounded d-flex align-items-center justify-content-center">
                                        <i class="bx bx-wallet fs-20 text-light"></i>
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
                                            ₹ <span class="counter-value" data-target="{{ (int)$totalRefund }}">0</span>
                                        </h2>
                                        <span class="fs-13 text-danger">
                                            View All
                                        </span>
                                    </div>
                                    <div class="avatar-sm bg-gradient bg-danger rounded d-flex align-items-center justify-content-center">
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
                            <div class="flex-shrink-0">
                                <select class="form-select form-select-sm">
                                    <option>This Month</option>
                                    <option>Last Month</option>
                                    <option>This Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!-- Stats -->
                            <div class="row mb-4 sales-overview-stats">
                                <div class="col-md-3 border-end">
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
                                <div class="col-md-3 border-end">
                                    <h3 class="mb-1 fw-semibold" title="₹ {{ number_format($pendingAmount) }}">
                                        @if($pendingAmount >= 10000000)
                                            ₹ {{ number_format($pendingAmount / 10000000, 2) }} Cr
                                        @elseif($pendingAmount >= 100000)
                                            ₹ {{ number_format($pendingAmount / 100000, 2) }} L
                                        @else
                                            ₹ {{ number_format($pendingAmount) }}
                                        @endif
                                    </h3>
                                    <p class="text-muted mb-0">
                                        <i class="ri-checkbox-blank-circle-fill text-warning me-1"></i>
                                        Pending Amount
                                    </p>
                                </div>
                                <div class="col-md-3 border-end">
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
                                <div class="col-md-3">
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
                                        <div class="funnel-stage-parent">
                                            <div class="funnel-stage funnel-5"></div>
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
                                                Submitted
                                            </div>
                                            <h3 class="mb-0 text-info">
                                                {{ number_format($submittedLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="funnel-stat-item">
                                        <span class="funnel-line funnel-line-success"></span>
                                        <div>
                                            <div class="text-muted">
                                                Paid Bookings
                                            </div>
                                            <h3 class="mb-0 text-success">
                                                {{ number_format($paidLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="funnel-stat-item">
                                        <span class="funnel-line funnel-line-warning"></span>
                                        <div>
                                            <div class="text-muted">
                                                Pending Payment
                                            </div>
                                            <h3 class="mb-0 text-warning">
                                                {{ number_format($pendingLeads) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="funnel-stat-item mb-0">
                                        <span class="funnel-line funnel-line-danger"></span>
                                        <div>
                                            <div class="text-muted">
                                                Drafts
                                            </div>
                                            <h3 class="mb-0 text-danger">
                                                {{ number_format($draftLeads) }}
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
                                    <div class="avatar-md bg-light rounded-circle d-flex align-items-center justify-content-center">
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
                            <div id="project-status-source" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' data-colors-minimal='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]' data-colors-interactive='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]' data-colors-galaxy='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>

                <!-- Deals by Stage -->
                <div class="col-xl-4">
                    <div class="card card-height-100">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Deals by Stage</h4>
                        </div>
                        <div class="card-body">
                            <div id="deal-stage-source" data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]' data-colors-minimal='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]' data-colors-interactive='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]' data-colors-galaxy='["--vz-primary", "--vz-primary-rgb, 0.85", "--vz-primary-rgb, 0.70", "--vz-primary-rgb, 0.60", "--vz-primary-rgb, 0.45"]' class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="col-xl-4 col-lg-4">
                    <div class="card h-100 dashboard-status-card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <div class="activity-feed">
                                <div class="activity-item">
                                    <div class="activity-icon-wrap act-bg-success">
                                        <i class="ri-user-add-line fs-16"></i>
                                    </div>
                                    <div class="activity-item-content">
                                        <h5>New lead <span class="fw-semibold text-dark">Rahul Sharma</span>
                                            created</h5>
                                        <p>2 min ago</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon-wrap act-bg-indigo">
                                        <i class="ri-file-text-line fs-16"></i>
                                    </div>
                                    <div class="activity-item-content">
                                        <h5>Project <span class="fw-semibold text-dark">"Sunrise
                                                Residency"</span> created</h5>
                                        <p>15 min ago</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon-wrap act-bg-warning">
                                        <i class="ri-file-list-3-line fs-16"></i>
                                    </div>
                                    <div class="activity-item-content">
                                        <h5>Invoice <span class="fw-semibold text-dark">#INV-00125</span>
                                            generated</h5>
                                        <p>45 min ago</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon-wrap act-bg-teal">
                                        <i class="ri-wallet-3-line fs-16"></i>
                                    </div>
                                    <div class="activity-item-content">
                                        <h5>Payment received for Invoice <span class="fw-semibold text-dark">#INV-00120</span></h5>
                                        <p>1 hr ago</p>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon-wrap act-bg-purple">
                                        <i class="ri-handshake-line fs-16"></i>
                                    </div>
                                    <div class="activity-item-content">
                                        <h5>New deal <span class="fw-semibold text-dark">"Green
                                                Valley"</span> won</h5>
                                        <p>2 hrs ago</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-1 w-100">
                                <a href="#" class="btn btn-light w-100 border fs-13 py-2 fw-medium" style="border: 1px solid #e2e8f0 !important; background-color: #fff; color: #495057; border-radius: 6px; transition: all 0.2s ease;">
                                    View All Activities
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Row: Top Performing Projects & Recent Leads -->
            <div class="row mb-4">
                <!-- Top Performing Projects -->
                <div class="col-xl-6">
                    <div class="card h-100 dashboard-status-card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Top Performing Projects</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Project Name</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Leads</th>
                                            <th scope="col">Deals</th>
                                            <th scope="col">Collection</th>
                                            <th scope="col">Progress</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="fw-semibold">Sunrise Residency</td>
                                            <td>Residential</td>
                                            <td>186</td>
                                            <td>42</td>
                                            <td>₹ 2.45 Cr</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress progress-sm flex-grow-1" style="height: 5px; width: 60px; border-radius: 30px; background-color: #eff2f7;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%; border-radius: 30px;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="fs-12 fw-medium text-muted">75%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary-subtle text-primary py-1 px-2 rounded fs-11">In Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="fw-semibold">Green Valley</td>
                                            <td>Residential</td>
                                            <td>152</td>
                                            <td>38</td>
                                            <td>₹ 1.98 Cr</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress progress-sm flex-grow-1" style="height: 5px; width: 60px; border-radius: 30px; background-color: #eff2f7;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; border-radius: 30px;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="fs-12 fw-medium text-muted">60%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary-subtle text-primary py-1 px-2 rounded fs-11">In Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="fw-semibold">Royal Homes</td>
                                            <td>Commercial</td>
                                            <td>98</td>
                                            <td>26</td>
                                            <td>₹ 1.42 Cr</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress progress-sm flex-grow-1" style="height: 5px; width: 60px; border-radius: 30px; background-color: #eff2f7;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 45%; border-radius: 30px;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="fs-12 fw-medium text-muted">45%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-primary-subtle text-primary py-1 px-2 rounded fs-11">In Progress</span></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="fw-semibold">Elite Square</td>
                                            <td>Commercial</td>
                                            <td>74</td>
                                            <td>18</td>
                                            <td>₹ 0.96 Cr</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress progress-sm flex-grow-1" style="height: 5px; width: 60px; border-radius: 30px; background-color: #eff2f7;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 35%; border-radius: 30px;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="fs-12 fw-medium text-muted">35%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-warning-subtle text-warning py-1 px-2 rounded fs-11">On Hold</span></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="fw-semibold">Lake View Residency</td>
                                            <td>Residential</td>
                                            <td>65</td>
                                            <td>15</td>
                                            <td>₹ 0.68 Cr</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="progress progress-sm flex-grow-1" style="height: 5px; width: 60px; border-radius: 30px; background-color: #eff2f7;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 20%; border-radius: 30px;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span class="fs-12 fw-medium text-muted">20%</span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-warning-subtle text-warning py-1 px-2 rounded fs-11">On Hold</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 pt-1 w-100">
                                <a href="#" class="btn btn-light w-100 border fs-13 py-2 fw-medium" style="border: 1px solid #e2e8f0 !important; background-color: #fff; color: #495057; border-radius: 6px; transition: all 0.2s ease;">
                                    View All Projects
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Leads -->
                <div class="col-xl-6">
                    <div class="card h-100 dashboard-status-card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Recent Leads</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                    <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Project Interest</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-semibold">Rahul Sharma</td>
                                            <td class="text-muted">9876543210</td>
                                            <td>Sunrise Residency</td>
                                            <td><span class="badge bg-primary-subtle text-primary py-1 px-2 rounded fs-11">New</span></td>
                                            <td class="text-muted">21 Jun 2026</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Priya Verma</td>
                                            <td class="text-muted">8765432109</td>
                                            <td>Green Valley</td>
                                            <td><span class="badge bg-success-subtle text-success py-1 px-2 rounded fs-11">Contacted</span></td>
                                            <td class="text-muted">21 Jun 2026</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Amit Singh</td>
                                            <td class="text-muted">7654321098</td>
                                            <td>Royal Homes</td>
                                            <td><span class="badge bg-info-subtle text-info py-1 px-2 rounded fs-11" style="background-color: #f3f0ff !important; color: #7c3aed !important;">Qualified</span></td>
                                            <td class="text-muted">20 Jun 2026</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Neha Joshi</td>
                                            <td class="text-muted">6543210987</td>
                                            <td>Elite Square</td>
                                            <td><span class="badge bg-primary-subtle text-primary py-1 px-2 rounded fs-11">New</span></td>
                                            <td class="text-muted">20 Jun 2026</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-semibold">Vikram Patel</td>
                                            <td class="text-muted">5432109876</td>
                                            <td>Lake View Residency</td>
                                            <td><span class="badge bg-success-subtle text-success py-1 px-2 rounded fs-11">Contacted</span></td>
                                            <td class="text-muted">19 Jun 2026</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 pt-1 w-100">
                                <a href="#" class="btn btn-light w-100 border fs-13 py-2 fw-medium" style="border: 1px solid #e2e8f0 !important; background-color: #fff; color: #495057; border-radius: 6px; transition: all 0.2s ease;">
                                    View All Leads
                                </a>
                            </div>
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
                            <h4 class="card-title mb-0 flex-grow-1">Collection vs Pending <span class="text-muted fs-12 fw-normal">(This Month)</span></h4>
                        </div>
                        <div class="card-body">
                            <div id="collectionVsPendingChart" class="apex-charts" dir="ltr" style="height: 280px; min-height: 280px;"></div>
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
                            <div id="salesTrendChart" class="apex-charts" dir="ltr" style="height: 250px; min-height: 250px;"></div>
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
                                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-dashed" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #eff6ff; color: #3b82f6; flex-shrink: 0;">
                                            <i class="ri-file-list-3-line fs-16"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-13 fw-semibold mb-0 text-dark">Follow up with Rahul Sharma</h5>
                                            <p class="text-muted mb-0 fs-12">Sunrise Residency</p>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-12 fw-medium text-dark">22 Jun 2026</span>
                                        <span class="fs-11 text-muted">10:30 AM</span>
                                    </div>
                                </div>

                                <!-- Follow-up Item 2 -->
                                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-dashed" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #ecfdf5; color: #10b981; flex-shrink: 0;">
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
                                <div class="d-flex align-items-center justify-content-between pb-3 border-bottom border-dashed" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #fff5f5; color: #f87171; flex-shrink: 0;">
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
                                <div class="d-flex align-items-center justify-content-between pb-1" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: #faf5ff; color: #a855f7; flex-shrink: 0;">
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
                                <a href="#" class="btn btn-light w-100 border fs-13 py-2 fw-medium" style="border: 1px solid #e2e8f0 !important; background-color: #fff; color: #495057; border-radius: 6px; transition: all 0.2s ease;">
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
                            <div id="hourlyRegistrationChart" class="apex-charts" dir="ltr" style="height: 300px; min-height: 300px;"></div>
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
                                        <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; flex-shrink: 0;">
                                            <i class="ri-time-line fs-20"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-14 fw-semibold mb-1 text-dark">Peak Traffic Period</h5>
                                            <p class="text-muted mb-0 fs-12" id="peak-period-text">Analyzing peak hours...</p>
                                        </div>
                                    </div>
                                    <p class="text-muted fs-13 mb-4">
                                        This chart displays the hourly distribution of lead registrations. Use this data to optimize sales team shifts, ad campaign schedules, and automated follow-ups.
                                    </p>
                                </div>
                                <div class="bg-light p-3 rounded" style="border: 1px solid #eef0f7;">
                                    <h6 class="fs-13 fw-semibold text-dark mb-2">Campaign Tip:</h6>
                                    <p class="text-muted fs-12 mb-0">
                                        Schedule bulk promotional notifications and SMS blasts 1 hour before the peak traffic period to maximize open rates and engagement.
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
                            <div id="ageWiseChart" class="apex-charts" dir="ltr" style="height: 320px; min-height: 320px;"></div>
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
                            <div id="cityWiseChart" class="apex-charts" dir="ltr" style="height: 320px; min-height: 320px;"></div>
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
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #f3e8ff; color: #7c3aed; flex-shrink: 0;">
                                            <i class="ri-user-shared-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Total Customers</p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">{{ number_format($totalLeads) }}</h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Invoices -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #eff6ff; color: #3b82f6; flex-shrink: 0;">
                                            <i class="ri-file-text-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Total Invoices</p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">{{ number_format($submittedLeads) }}</h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paid Invoices -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #ecfdf5; color: #10b981; flex-shrink: 0;">
                                            <i class="ri-handshake-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Paid Invoices</p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">{{ number_format($paidLeads) }}</h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unpaid Invoices -->
                                <div class="col border-end" style="border-color: #f1f5f9 !important;">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fff5f5; color: #ef4444; flex-shrink: 0;">
                                            <i class="ri-file-warning-line fs-18"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 fs-12 text-uppercase fw-semibold">Unpaid Invoices</p>
                                            <div class="d-flex align-items-center gap-2">
                                                <h3 class="mb-0 fw-bold fs-20 text-dark">{{ number_format($pendingLeads) }}</h3>
                                                <span class="text-success fs-12 fw-medium">Live</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Refunds -->
                                <div class="col">
                                    <div class="d-flex align-items-center gap-3 ps-3">
                                        <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background-color: #fff7ed; color: #f97316; flex-shrink: 0;">
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
                <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
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
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                series: [{
                        name: "Collection"
                        , data: @json($salesTrendCollection)
                    }
                    , {
                        name: "Pending Amount"
                        , data: @json($salesTrendPending)
                    }
                    , {
                        name: "Booking Amount"
                        , data: @json($salesTrendBooking)
                    }
                    , {
                        name: "Refund Amount"
                        , data: @json($salesTrendRefund)
                    }
                ]
                , chart: {
                    height: 350
                    , type: "line"
                    , toolbar: {
                        show: false
                    }
                    , zoom: {
                        enabled: false
                    }
                    , dropShadow: {
                        enabled: true
                        , top: 6
                        , left: 0
                        , blur: 4
                        , color: [
                            "#4F6DF5", // Collection
                            "#F7A928", // Pending
                            "#34C38F", // Booking
                            "#F46A6A" // Refund
                        ]
                        , opacity: 0.18
                    }
                }
                , stroke: {
                    width: 3
                    , curve: "smooth"
                }
                , markers: {
                    size: 4
                    , strokeColors: "#fff"
                    , strokeWidth: 2
                    , hover: {
                        size: 6
                    }
                }
                , colors: [
                    "#4F6DF5", // Collection
                    "#F7A928", // Pending
                    "#34C38F", // Booking
                    "#F46A6A" // Refund
                ]
                , grid: {
                    borderColor: "#eef1f7"
                    , strokeDashArray: 4
                }
                , dataLabels: {
                    enabled: false
                }
                , xaxis: {
                    categories: @json($salesTrendDays)
                    , axisBorder: {
                        show: false
                    }
                    , axisTicks: {
                        show: false
                    }
                    , tickAmount: 5
                    , labels: {
                        rotate: 0
                        , style: {
                            colors: '#878a99'
                            , fontSize: '12px'
                            , fontFamily: 'Inter, sans-serif'
                        }
                    }
                }
                , yaxis: {
                    min: 0
                    , tickAmount: 5
                    , labels: {
                        formatter: function(value) {
                            return value === 0 ? "0" : value + "L";
                        }
                        , style: {
                            colors: '#878a99'
                            , fontSize: '12px'
                            , fontFamily: 'Inter, sans-serif'
                        }
                    }
                }
                , legend: {
                    position: "bottom"
                    , horizontalAlign: "center"
                    , fontSize: "13px"
                    , offsetY: 8
                    , markers: {
                        width: 8
                        , height: 8
                        , radius: 12
                    }
                }
                , tooltip: {
                    shared: true
                    , intersect: false
                }
            };
            var chart = new ApexCharts(
                document.querySelector("#salesOverviewChart")
                , options
            );
            chart.render();
        });

        // Deals
        var chartDeals = getChartColorsArray("deal-stage-source");
        if (chartDeals) {
            var options = {
                series: [@json($paidLeads), @json($pendingLeads), @json($draftLeads)]
                , labels: ["Paid", "Pending Payment", "Draft"]
                , chart: {
                    height: 333
                    , type: "donut"
                , }
                , legend: {
                    position: "bottom"
                , }
                , stroke: {
                    show: false
                }
                , dataLabels: {
                    dropShadow: {
                        enabled: false
                    , }
                , }
                , colors: chartDeals
            , };

            var chart = new ApexCharts(
                document.querySelector("#deal-stage-source")
                , options
            );
            chart.render();
        }

        // Project Status
        var chartProjectStatus = getChartColorsArray("project-status-source");
        if (chartProjectStatus) {
            var options = {
                series: @json($projectStatusData)
                , labels: @json($projectStatusLabels)
                , chart: {
                    height: 333
                    , type: "donut"
                , }
                , legend: {
                    position: "bottom"
                , }
                , stroke: {
                    show: false
                }
                , dataLabels: {
                    dropShadow: {
                        enabled: false
                    , }
                , }
                , colors: chartProjectStatus
            , };

            var chart = new ApexCharts(
                document.querySelector("#project-status-source")
                , options
            );
            chart.render();
        }

        // Collection vs Pending Chart
        var collectionVsPendingOptions = {
            series: [{
                name: 'Collection'
                , data: [135, 195, 158, 210]
            }, {
                name: 'Pending'
                , data: [48, 105, 70, 112]
            }]
            , chart: {
                type: 'bar'
                , height: 280
                , toolbar: {
                    show: false
                }
            }
            , plotOptions: {
                bar: {
                    horizontal: false
                    , columnWidth: '45%'
                    , borderRadius: 4
                }
            , }
            , dataLabels: {
                enabled: false
            }
            , stroke: {
                show: true
                , width: 2
                , colors: ['transparent']
            }
            , colors: ['#3b82f6', '#f59e0b']
            , xaxis: {
                categories: ['Week 1', 'Week 2', 'Week 3', 'Week 4']
                , axisBorder: {
                    show: false
                }
                , axisTicks: {
                    show: false
                }
            }
            , yaxis: {
                labels: {
                    formatter: function(val) {
                        return val + "L";
                    }
                }
            }
            , fill: {
                opacity: 1
            }
            , legend: {
                position: 'bottom'
                , horizontalAlign: 'center'
                , offsetY: 8
                , markers: {
                    width: 10
                    , height: 10
                    , radius: 2
                }
            }
            , tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " L";
                    }
                }
            }
        };

        var collectionVsPendingChart = new ApexCharts(
            document.querySelector("#collectionVsPendingChart")
            , collectionVsPendingOptions
        );
        collectionVsPendingChart.render();

        // Sales Trend Chart
        var salesTrendOptions = {
            series: [{
                name: 'This Month'
                , data: [8, 12, 17, 23, 20, 25, 33, 24, 32, 31, 37, 41]
            }, {
                name: 'Last Month'
                , data: [8, 10, 15, 12, 20, 18, 20, 32, 28, 37, 35, 34]
            }]
            , chart: {
                type: 'area'
                , height: 250
                , toolbar: {
                    show: false
                }
            }
            , stroke: {
                curve: 'smooth'
                , width: [3, 2]
            }
            , fill: {
                type: 'gradient'
                , gradient: {
                    shadeIntensity: 1
                    , opacityFrom: [0.35, 0]
                    , opacityTo: [0.05, 0]
                    , stops: [0, 90, 100]
                }
            }
            , colors: ['#3b82f6', '#94a3b8']
            , xaxis: {
                categories: ['01 Jun', '', '', '07 Jun', '', '', '13 Jun', '', '', '19 Jun', '', '21 Jun']
                , axisBorder: {
                    show: false
                }
                , axisTicks: {
                    show: false
                }
            }
            , yaxis: {
                labels: {
                    formatter: function(val) {
                        return val + "L";
                    }
                }
                , max: 50
            }
            , legend: {
                position: 'bottom'
                , horizontalAlign: 'center'
                , offsetY: 8
                , markers: {
                    width: 10
                    , height: 10
                    , radius: 2
                }
            }
            , tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " L";
                    }
                }
            }
        };

        var salesTrendChart = new ApexCharts(
            document.querySelector("#salesTrendChart")
            , salesTrendOptions
        );
        salesTrendChart.render();

        // Hourly Registration Chart
        var hourlyData = @json($hourlyData);
        var hourlyLabels = @json($hourlyLabels);

        var hourlyRegistrationOptions = {
            series: [{
                name: 'Registrations'
                , data: hourlyData
            }]
            , chart: {
                type: 'area'
                , height: 300
                , toolbar: {
                    show: false
                }
                , zoom: {
                    enabled: false
                }
            }
            , stroke: {
                curve: 'smooth'
                , width: 3
            }
            , fill: {
                type: 'gradient'
                , gradient: {
                    shadeIntensity: 1
                    , opacityFrom: 0.4
                    , opacityTo: 0.05
                    , stops: [0, 90, 100]
                }
            }
            , colors: ['#6366f1']
            , xaxis: {
                categories: hourlyLabels
                , labels: {
                    rotate: -45
                    , rotateAlways: false
                    , style: {
                        colors: '#878a99'
                        , fontSize: '11px'
                        , fontFamily: 'Inter, sans-serif'
                    }
                }
                , axisBorder: {
                    show: false
                }
                , axisTicks: {
                    show: false
                }
            }
            , yaxis: {
                labels: {
                    formatter: function(val) {
                        return Math.round(val);
                    }
                    , style: {
                        colors: '#878a99'
                        , fontSize: '11px'
                        , fontFamily: 'Inter, sans-serif'
                    }
                }
            }
            , dataLabels: {
                enabled: false
            }
            , grid: {
                borderColor: "#eef1f7"
                , strokeDashArray: 4
            }
            , tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " leads";
                    }
                }
            }
        };

        var hourlyRegistrationChart = new ApexCharts(
            document.querySelector("#hourlyRegistrationChart")
            , hourlyRegistrationOptions
        );
        hourlyRegistrationChart.render();

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
            peakPeriodText = `Most registrations occur between <strong>${peakHour}</strong> and <strong>${nextHour}</strong> (${maxVal} leads total).`;
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
        var ageWiseChart = new ApexCharts(document.querySelector("#ageWiseChart"), ageWiseOptions);
        ageWiseChart.render();

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
            colors: ['#3577f1', '#0ab39c', '#f7b84b', '#f06548', '#299cdb', '#a855f7', '#6366f1', '#ec4899', '#14b8a6', '#f43f5e'],
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
        var cityWiseChart = new ApexCharts(document.querySelector("#cityWiseChart"), cityWiseOptions);
        cityWiseChart.render();

    </script>
    @endsection
</div>
