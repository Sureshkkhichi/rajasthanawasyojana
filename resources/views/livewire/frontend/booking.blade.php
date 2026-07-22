<div>
    @push('styles')
        <style>
            select.is-invalid+.select2-container .select2-selection {
                border-color: #dc3545 !important;
            }

            .project-detail-body {
                background: #f8f9fa;
                padding: 20px 28px;
            }

            .nft-hero {
                background-image: unset;
                padding: 110px 0 60px 0;
            }

            label {
                font-weight: normal !important;
                font-size: 1rem !important;
            }

            .form-label {
                margin-bottom: 0px !important;
            }

            /* Project Info Panel */
            .proj-panel {
                background: #f8f9fa;
                border: 1px solid #e8e8e8;
                border-radius: 12px;
                box-shadow: none;
                margin-bottom: 22px;
                overflow: hidden;
            }
            .proj-panel-top {
                padding: 18px 24px 14px;
                border-bottom: 1px solid #e0e0e0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                flex-wrap: wrap;
            }
            .proj-panel-name {
                font-size: 19px;
                font-weight: 700;
                color: #1a1a1a;
                margin: 0 0 3px 0;
                line-height: 1.3;
            }
            .proj-panel-meta {
                font-size: 13px;
                color: #777;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 6px;
            }
            .proj-panel-meta i {
                font-size: 14px;
                color: #aaa;
            }
            .proj-status-pill {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: #f0fdf4;
                color: #16a34a;
                border: 1px solid #bbf7d0;
                border-radius: 20px;
                padding: 4px 12px;
                font-size: 12px;
                font-weight: 600;
                white-space: nowrap;
            }
            .proj-status-pill .dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #22c55e;
                display: inline-block;
                animation: pulse-dot 1.5s infinite;
            }
            @keyframes pulse-dot {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.4; }
            }
            .proj-stats {
                display: flex;
                flex-wrap: wrap;
                padding: 0;
                border-bottom: 1px solid #e0e0e0;
            }
            .proj-stat-item {
                flex: 1;
                min-width: 120px;
                padding: 14px 22px;
                border-right: 1px solid #e0e0e0;
                position: relative;
            }
            .proj-stat-item:last-child {
                border-right: none;
            }
            .proj-stat-label {
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: #999;
                margin-bottom: 5px;
            }
            .proj-stat-value {
                font-size: 15px;
                font-weight: 700;
                color: #1a1a1a;
                margin: 0;
                line-height: 1.2;
            }
            .proj-stat-value.accent {
                color: #c0392b;
            }
            .proj-stat-sub {
                font-size: 11px;
                color: #aaa;
                font-weight: 400;
                margin-top: 2px;
            }
            .proj-sizes-row {
                padding: 12px 24px;
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }
            .proj-sizes-label {
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.6px;
                color: #999;
                white-space: nowrap;
            }
            .proj-size-chip {
                background: #fff;
                border: 1px solid #ddd;
                color: #444;
                border-radius: 6px;
                padding: 3px 10px;
                font-size: 12px;
                font-weight: 600;
            }
            .proj-address {
                padding: 10px 24px 14px;
                font-size: 13px;
                color: #666;
                display: flex;
                align-items: flex-start;
                gap: 6px;
                border-top: 1px solid #e0e0e0;
            }
            .proj-address i {
                color: #bbb;
                margin-top: 1px;
                flex-shrink: 0;
            }
        </style>
    @endpush
    <!-- BOOKING FORM -->
    <section class="section nft-hero bg-light" id="booking-form">
        <div class="container">
            @if($project->registration_status === 'open')
            <div class="row justify-content-center mb-0">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h2 class="fw-semibold">
                            आवेदन करें
                        </h2>
                        <div class="text-danger border-0 m-0" style="font-weight: 800;">
                            <i class="ri-information-line me-2"></i>
                            <span>If not allotted, all the refund will be
                                returned back to the original
                                bank account or card where
                                the payment was initially made.</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- PROJECT INFO PANEL --}}
            <div class="proj-panel">
                {{-- Top: Name + Status --}}
                <div class="proj-panel-top">
                    <div>
                        <div class="proj-panel-name">{{ $project->name }}</div>
                        <div class="proj-panel-meta">
                            <i class="ri-map-pin-2-fill"></i>
                            {{ $project->city ?? 'Jaipur' }}
                            <span style="color:#ddd;">|</span>
                            जयपुर विकास प्राधिकरण द्वारा अनुमोदित
                        </div>
                    </div>
                    <div class="proj-status-pill">
                        <span class="dot"></span> Registration Open
                    </div>
                </div>

                {{-- Stats Strip --}}
                <div class="proj-stats">
                    <div class="proj-stat-item">
                        <div class="proj-stat-label">Property Type</div>
                        <div class="proj-stat-value">
                            @if($project->inventory_type === 'flat') Flat @else Plot @endif
                        </div>
                    </div>
                    @if($project->price)
                    <div class="proj-stat-item">
                        <div class="proj-stat-label">Base Price</div>
                        <div class="proj-stat-value accent">₹ {{ number_format($project->price) }}</div>
                        @if($project->inventory_type !== 'flat')
                        <div class="proj-stat-sub">per sq. yard</div>
                        @endif
                    </div>
                    @endif
                    <div class="proj-stat-item">
                        <div class="proj-stat-label">Registration Amount</div>
                        <div class="proj-stat-value accent">₹ {{ number_format(\App\Models\FrontendSetting::getVal('booking_amount', 21100)) }}</div>
                        <div class="proj-stat-sub">One-time, refundable</div>
                    </div>
                </div>

                {{-- Available Sizes --}}
                @if(count($sizes) > 0)
                <div class="proj-sizes-row">
                    <span class="proj-sizes-label">
                        @if($project->inventory_type === 'flat') Flat Sizes: @else Plot Sizes (Sq Yds): @endif
                    </span>
                    @foreach($sizes as $sz)
                        @php
                            $szLabel = match($sz) {
                                'EWS' => 'EWS (1BHK)',
                                'LIG' => 'LIG (2BHK)',
                                default => $sz,
                            };
                        @endphp
                        <span class="proj-size-chip">{{ $szLabel }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Address --}}
                @if($project->address)
                <div class="proj-address">
                    <i class="ri-map-pin-line"></i>
                    <span>{{ $project->address }}</span>
                </div>
                @endif
            </div>

            <div class="card border-0 p-0">
                <div class="card-body p-0 p-lg-0">
                    @if(session()->has('success'))
                        <div id="swal-success-message" data-message="{{ session('success') }}" style="display:none;"></div>
                    @endif
                    @if(session()->has('error'))
                        <div id="swal-error-message" data-message="{{ session('error') }}" style="display:none;"></div>
                    @endif
                </div>
            </div>


            <div class="card shadow-lg border-0" style="background-color: #f8f9fa;">
                <div class="card-body p-3 p-lg-3">
                    <form wire:submit.prevent="submit" class="position-relative">
                        {{-- Loader Overlay --}}
                        <div wire:loading wire:target="submit" style="display: none;">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center rounded shadow" style="background: rgba(255,255,255,0.7); z-index: 1050; min-height: 400px;">
                                <div class="text-center" style="position: sticky; top: 50%;">
                                    <div class="spinner-grow text-success" role="status" style="width: 3rem; height: 3rem;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h5 class="text-success mt-3 fw-semibold">Processing booking form, please wait...</h5>
                                </div>
                            </div>
                        </div>
                        <!-- PERSONAL DETAILS -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            First Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('first_name') is-invalid @enderror"
                                            wire:model.blur="first_name">
                                        @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Last Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('last_name') is-invalid @enderror"
                                            wire:model.blur="last_name">
                                        @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Father / Husband Name
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('father_husband_name') is-invalid @enderror"
                                            wire:model.blur="father_husband_name">
                                        @error('father_husband_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            PAN Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="pan_number"
                                            class="form-control text-uppercase @error('pan_number') is-invalid @enderror"
                                            wire:model.blur="pan_number" maxlength="10">
                                        @error('pan_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Gender <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('gender') is-invalid @enderror"
                                            wire:model="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Email <span class="text-danger">*</span>
                                        </label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            wire:model.blur="email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Mobile Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            wire:model.blur="phone">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Date of Birth <span class="text-danger">*</span>
                                        </label>
                                        <input type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            wire:model.blur="date_of_birth"
                                            max="{{ now()->subYears(18)->format('Y-m-d') }}">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Occupation <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('occupation') is-invalid @enderror"
                                            wire:model="occupation">
                                            <option value="">Select Occupation</option>
                                            <option value="Salaried">Salaried</option>
                                            <option value="Self Employed">Self Employed</option>
                                            <option value="Business">Business</option>
                                            <option value="Professional">Professional</option>
                                            <option value="Retired">Retired</option>
                                            <option value="House Wife">House Wife</option>
                                            <option value="Student">Student</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('occupation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ADDRESS DETAILS -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            State <span class="text-danger">*</span>
                                        </label>
                                        <div wire:ignore>
                                            <select id="state-select" class="form-select">
                                                <option value="">Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" @selected($state->id == $state_id)>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                            <div class="text-danger fs-13 mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            City <span class="text-danger">*</span>
                                        </label>
                                        <div wire:ignore>
                                            <select id="city-select" class="form-select">
                                                <option value="">Select City</option>
                                                @foreach($cities as $c)
                                                    <option value="{{ $c->id }}" @selected($c->id == $city_id)>
                                                        {{ $c->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('city_id')
                                            <div class="text-danger fs-13 mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Permanent Address <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control text-capitalize @error('address') is-invalid @enderror"
                                            wire:model.blur="address" rows="2"></textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- APPLICATION DETAIL -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Co-Applicant Name
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('co_applicant_name') is-invalid @enderror"
                                            wire:model.blur="co_applicant_name">
                                        @error('co_applicant_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            @if($project->inventory_type === 'flat')
                                                Select Flat Size <span class="text-danger">*</span>
                                            @else
                                                Select Plot Size (Sq Yards) <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <select class="form-select @error('flat_size') is-invalid @enderror"
                                            wire:model="flat_size">
                                            <option value="">Select Option</option>
                                            @foreach($sizes as $size)
                                                @php
                                                    $sizeLabel = match($size) {
                                                        'EWS' => 'EWS (1BHK)',
                                                        'LIG' => 'LIG (2BHK)',
                                                        default => $size,
                                                    };
                                                @endphp
                                                <option value="{{ $size }}">{{ $sizeLabel }}</option>
                                            @endforeach
                                        </select>
                                        @error('flat_size')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Waiver Code
                                        </label>
                                        <input type="text"
                                            class="form-control @error('waiver_code') is-invalid @enderror"
                                            wire:model.blur="waiver_code"
                                            maxlength="5"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        @error('waiver_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- PRICE CARD -->
                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label>Total Flat value </label>
                                <h2 id="total" style=" border-bottom:2px dotted #000;"></h2>
                                <h3 class="" style="font-weight: 500;">Registration Amount Rs. {{ number_format(\App\Models\FrontendSetting::getVal('booking_amount', 21100)) }}</h3>
                            </div>
                        </div>
                        <!-- TERMS -->
                        <div id="terms" class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                    id="termsCheck" wire:model="terms">
                                <label class="form-check-label" for="termsCheck">
                                    I Agree
                                    <a href="#" class="fw-semibold">
                                        Terms & Conditions
                                    </a>
                                    for booking.
                                </label>
                            </div>
                            <div class="mt-3 text-dark">
                                By signing up, you (the client) provide opt-in consent to Rajasthan Awas Yogna for
                                receiving SMS, voice, email, and WhatsApp messages for authentication, promotional, RCS
                                and service-related purposes.
                            </div>
                        </div>
                        <!-- BUTTON -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success rounded-pill fw-semibold shadow-lg"
                                style="background: #198754; border-color: #198754;"
                                wire:loading.attr="disabled"
                                wire:target="submit">
                                <span wire:loading.remove wire:target="submit">
                                    Proceed for Payment <i class="ri-arrow-right-line ms-1 align-middle"></i>
                                </span>
                                <span wire:loading wire:target="submit">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Processing Payment...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0 py-5 px-4 text-center rounded-4 bg-white">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="ri-error-warning-fill text-danger" style="font-size: 64px;"></i>
                            </div>
                            <h3 class="fw-bold text-dark mb-3">रजिस्ट्रेशन बंद हो गए हैं!</h3>
                            <p class="text-muted fs-15 mb-4">
                                क्षमा करें, इस योजना (<strong>{{ $project->name }}</strong>) के लिए ऑनलाइन आवेदन / रजिस्ट्रेशन की समय सीमा समाप्त हो चुकी है। अधिक जानकारी के लिए कृपया प्रशासनिक कार्यालय से संपर्क करें.
                            </p>
                            <a href="{{ route('front') }}" class="btn btn-primary px-4 py-2 fs-15 rounded-pill shadow-sm" style="background-color: #ff0000; border-color: #ff0000; border: none;">
                                <i class="ri-home-4-line align-middle me-1"></i> मुख्य पृष्ठ पर जाएं
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <!--jquery cdn-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--select2 cdn-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="{{ asset('assets/js/pages/select2.init.js') }}"></script>
        <script>
            function initSelect2() {
                // Initialize State Select2
                const stateSelect = $('#state-select');
                if (stateSelect.length) {
                    if (stateSelect.hasClass("select2-hidden-accessible")) {
                        stateSelect.select2('destroy');
                    }
                    stateSelect.select2({
                        placeholder: "Select State",
                        allowClear: false
                    }).on('change', function (e) {
                        let val = $(this).val();
                        if (String(val || '') !== String(@this.state_id || '')) {
                            @this.set('state_id', val);
                        }
                    });

                    // Add validation styling based on error message presence
                    if (stateSelect.closest('.mb-3').find('.invalid-feedback').length) {
                        stateSelect.next('.select2-container').find('.select2-selection').css('border-color', '#dc3545');
                    } else {
                        stateSelect.next('.select2-container').find('.select2-selection').css('border-color', '');
                    }
                }

                // Initialize City Select2
                const citySelect = $('#city-select');
                if (citySelect.length) {
                    if (citySelect.hasClass("select2-hidden-accessible")) {
                        citySelect.select2('destroy');
                    }
                    citySelect.select2({
                        placeholder: "Select City",
                        allowClear: false
                    }).on('change', function (e) {
                        let val = $(this).val();
                        if (String(val || '') !== String(@this.city_id || '')) {
                            @this.set('city_id', val);
                        }
                    });

                    // Add validation styling based on error message presence
                    if (citySelect.closest('.mb-3').find('.invalid-feedback').length) {
                        citySelect.next('.select2-container').find('.select2-selection').css('border-color', '#dc3545');
                    } else {
                        citySelect.next('.select2-container').find('.select2-selection').css('border-color', '');
                    }
                }
            }

            $(document).ready(function () {
                initSelect2();
            });

            document.addEventListener('livewire:init', () => {
                Livewire.hook('request', ({
                    fail,
                    respond,
                    succeed
                }) => {
                    succeed(({
                        status,
                        response
                    }) => {
                        setTimeout(() => {
                            initSelect2();
                        }, 50);
                    });
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const panInput = document.getElementById('pan_number');
                if (!panInput) {
                    return;
                }
                panInput.addEventListener('input', function (e) {
                    let value = e.target.value.toUpperCase();
                    let result = '';
                    for (let i = 0; i < value.length; i++) {
                        let char = value[i];
                        // First 5 characters = A-Z
                        if (i < 5) {
                            if (/[A-Z]/.test(char)) {
                                result += char;
                            }
                        }
                        // Next 4 characters = 0-9
                        else if (i >= 5 && i <= 8) {
                            if (/[0-9]/.test(char)) {
                                result += char;
                            }
                        }
                        // Last character = A-Z
                        else if (i === 9) {
                            if (/[A-Z]/.test(char)) {
                                result += char;
                            }
                        }
                    }
                    e.target.value = result;
                });
            });
        </script>
    @endpush
</div>