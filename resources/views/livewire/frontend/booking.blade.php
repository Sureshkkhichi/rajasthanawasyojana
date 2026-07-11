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
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                            </button>
                        </div>
                    @endif
                </div>
            </div>


            <div class="card shadow-lg border-0" style="background-color: #f8f9fa;">
                <div class="card-body p-3 p-lg-3">
                    <form wire:submit.prevent="submit">
                        <!-- PERSONAL DETAILS -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            First Name
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
                                            Last Name
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
                                            Father/Husband Name
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
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            PAN Number
                                        </label>
                                        <input type="text"
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
                                            Gender
                                        </label>
                                        <select class="form-select @error('gender') is-invalid @enderror"
                                            wire:model.blur="gender">
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
                                            Email Address
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            wire:model.blur="email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Phone <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            wire:model.blur="phone" maxlength="10">
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
                                            Date Of Birth
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
                                            Occupation
                                        </label>
                                        <select class="form-control @error('occupation') is-invalid @enderror"
                                            wire:model.blur="occupation">
                                            <option value="">Select Occupation</option>
                                            <option value="State Govt. Employee">State Govt. Employee</option>
                                            <option value="Center Govt. Employee">Center Govt. Employee</option>
                                            <option value="Army/Force">Army/Force</option>
                                            <option value="Private Salary Employee">Private Salary Employee</option>
                                            <option value="self Employee">Self Employeed</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        @error('occupation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Address
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('address') is-invalid @enderror"
                                            wire:model.blur="address">
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            State <span class="text-danger">*</span>
                                        </label>
                                        <div wire:ignore wire:key="state-container-{{ $state_id }}">
                                            <select id="state-select"
                                                class="js-example-basic-single @error('state_id') is-invalid @enderror"
                                                wire:model.blur="state_id">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}">
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('state_id')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            City <span class="text-danger">*</span>
                                        </label>
                                        <div wire:ignore
                                            wire:key="city-container-{{ $state_id }}-{{ $city_id }}-{{ count($cities) }}">
                                            <select id="city-select"
                                                class="js-example-basic-single @error('city_id') is-invalid @enderror"
                                                wire:model.blur="city_id">
                                                <option value="">Select City</option>
                                                @foreach ($cities as $cityItem)
                                                    <option value="{{ $cityItem->id }}">
                                                        {{ $cityItem->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('city_id')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label class="form-label">
                                            Co-Applicant (If Any)
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
                                            Flat Size
                                        </label>
                                        <select class="form-select @error('flat_size') is-invalid @enderror"
                                            wire:model.blur="flat_size">
                                            <option value="">
                                                Select Flat Size
                                            </option>
                                            <option value="1 BHK">1 BHK</option>
                                            <option value="2 BHK">2 BHK</option>
                                            <option value="3 BHK">3 BHK</option>
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
                            <input type="submit" class="btn btn-success" name="Procceds" value="Proceed for Payment"
                                style="background: #198754;border: #198754;" />

                        </div>
                    </form>
                </div>
            </div>
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