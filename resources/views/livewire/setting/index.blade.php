<div>
    <div class="page-content">
        <div class="container-fluid">

            {{-- Header Breadcrumb --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0 fw-semibold text-primary">
                            <i class="ri-settings-4-line align-middle me-1"></i> System Settings
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-10 mx-auto">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="card-title text-white mb-0 d-flex align-items-center">
                                <i class="ri-equalizer-line me-2 fs-18"></i> Booking & Waiver Discount Settings
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            
                            <form wire:submit.prevent="saveSettings">
                                <div class="row g-4">
                                    {{-- Booking Amount Field --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark mb-1">
                                            Booking Amount (₹) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 fw-semibold">₹</span>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('booking_amount') is-invalid @enderror"
                                                wire:model="booking_amount"
                                                placeholder="e.g. 21100">
                                        </div>
                                        @error('booking_amount')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">
                                            Standard registration / booking amount charged per customer application.
                                        </small>
                                    </div>

                                    {{-- Waiver Code Discount Amount Field --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-dark mb-1">
                                            Waiver Code Discount Amount (₹) <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 fw-semibold">₹</span>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('waiver_discount_amount') is-invalid @enderror"
                                                wire:model="waiver_discount_amount"
                                                placeholder="e.g. 1000">
                                        </div>
                                        @error('waiver_discount_amount')
                                            <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">
                                            Discount amount provided when a valid Waiver Code is entered by customer.
                                        </small>
                                    </div>

                                    {{-- Submit Button --}}
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="btn btn-primary btn-lg px-4" wire:loading.attr="disabled">
                                            <i class="ri-save-3-line align-middle me-1"></i> Save Settings
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('swal:alert', (event) => {
                    const data = event[0];
                    Swal.fire({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#405189'
                    });
                });
            });
        </script>
    @endpush
</div>
