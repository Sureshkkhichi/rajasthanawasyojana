<div>
    @push('styles')
        <style>
            select.is-invalid+.select2-container .select2-selection {
                border-color: #dc3545 !important;
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
                                                <option value="{{ $size }}">{{ $size }}</option>
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
                                            class="form-control text-uppercase @error('waiver_code') is-invalid @enderror"
                                            wire:model.blur="waiver_code">
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
                                <h3 class="" style="font-weight: 500;">Registration Amount Rs. 21100</h3>
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