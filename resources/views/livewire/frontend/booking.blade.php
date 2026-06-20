<div>
    <!-- BOOKING FORM -->
    <section class="section nft-hero bg-light" id="booking-form">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="text-center">
                        <h2 class="fw-semibold">
                            Registration Form
                        </h2>
                        <p class="text-muted mb-0">
                            Please fill all mandatory details carefully before proceeding.
                        </p>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border-0">
                <div class="card-body p-4 p-lg-5">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                            </button>
                        </div>
                    @endif
                    <!-- NOTICE -->
                    <div class="alert alert-warning border-0 mb-4">
                        <i class="ri-information-line me-2"></i>
                        If not allotted, the refund will be returned back to the original
                        bank account or card from which the payment was made.
                    </div>
                    <form wire:submit.prevent="submit">
                        <!-- PERSONAL DETAILS -->
                        <div class="mb-4">
                            <h5 class="fw-semibold border-bottom pb-2 mb-4">
                                Personal Information
                            </h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            First Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('first_name') is-invalid @enderror"
                                            wire:model.blur="first_name" placeholder="Enter First Name">
                                        @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Last Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('last_name') is-invalid @enderror"
                                            wire:model.blur="last_name" placeholder="Enter Last Name">
                                        @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Father/Husband Name
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('father_husband_name') is-invalid @enderror"
                                            wire:model.blur="father_husband_name" placeholder="Enter Name">
                                        @error('father_husband_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            PAN Number <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="pan_number"
                                            class="form-control text-uppercase @error('pan_number') is-invalid @enderror"
                                            wire:model.blur="pan_number" placeholder="ABCDE1234F" maxlength="10">
                                        @error('pan_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Gender <span class="text-danger">*</span>
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
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Email Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            wire:model.blur="email" placeholder="Enter Email Address">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Phone <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            wire:model.blur="phone" placeholder="Enter Mobile Number" maxlength="10">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Date Of Birth <span class="text-danger">*</span>
                                        </label>
                                        <input type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            wire:model.blur="date_of_birth">
                                        @error('date_of_birth')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Occupation <span class="text-danger">*</span>
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
                            </div>
                        </div>
                        <!-- ADDRESS -->
                        <div class="mb-4">
                            <h5 class="fw-semibold border-bottom pb-2 mb-4">
                                Address Information
                            </h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Address <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('address') is-invalid @enderror"
                                            wire:model.blur="address" placeholder="Enter Address">
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            State <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('state_id') is-invalid @enderror"
                                            wire:model.blur="state_id">
                                            <option value="">
                                                Select State
                                            </option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}">
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <div class="invalid-feedback">
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
                                        <input type="text"
                                            class="form-control text-capitalize @error('city') is-invalid @enderror"
                                            wire:model.blur="city" placeholder="Enter City">
                                        @error('city')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FLAT DETAILS -->
                        <div class="mb-4">
                            <h5 class="fw-semibold border-bottom pb-2 mb-4">
                                Flat Information
                            </h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Co-Applicant (If Any)
                                        </label>
                                        <input type="text"
                                            class="form-control text-capitalize @error('co_applicant_name') is-invalid @enderror"
                                            wire:model.blur="co_applicant_name" placeholder="Co Applicant Name">
                                        @error('co_applicant_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Flat Size <span class="text-danger">*</span>
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
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Waiver Code
                                        </label>
                                        <input type="text"
                                            class="form-control @error('waiver_code') is-invalid @enderror"
                                            wire:model.blur="waiver_code" placeholder="Enter Waiver Code">
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
                            <div class="col-lg-12">
                                <div class="card bg-success-subtle border-success mb-4">
                                    <div class="card-body text-center">
                                        <h2 class="fw-bold mb-0">
                                            Registration Amount ₹ 21,100
                                        </h2>
                                    </div>
                                </div>
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
                            <div class="mt-3 text-muted">
                                By signing up, you (the client) provide opt-in consent
                                to receive SMS, voice, email and WhatsApp communications
                                related to authentication, promotional and service purposes.
                            </div>
                        </div>
                        <!-- BUTTON -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                Proceed For Payment
                                <i class="ri-arrow-right-line ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
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
</div>