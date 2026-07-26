<div>
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column justify-content-between">
                <div>
                    <h4 class="fs-18 fw-bold mb-1 text-dark">PDF Document Templates</h4>
                    <p class="text-muted mb-0 fs-13">Manage Project-wise Hindi Content for Allotment & Demand Letters (आवंटन एवं मांग पत्र सामग्री प्रबंधन)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Selector Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark fs-14 mb-1">Select Target Project (परियोजना चुनें) <span class="text-danger">*</span></label>
                    <select class="form-select border-2 py-2 fw-semibold text-primary fs-15" wire:model.live="selectedProjectId">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <div class="bg-light p-3 rounded-3 border">
                        <span class="badge bg-primary mb-1">Dynamic Placeholders (डायनामिक टैग्स)</span>
                        <p class="fs-12 text-muted mb-0">PDF जनरेट होते समय ये टैग्स वास्तविक डेटा से बदल जाएंगे:</p>
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <span class="badge bg-white text-dark border"><code>{PROJECT_NAME}</code> Project Name</span>
                            <span class="badge bg-white text-dark border"><code>{PROJECT_ADDRESS}</code> Address</span>
                            <span class="badge bg-white text-dark border"><code>{CUSTOMER_NAME}</code> Customer</span>
                            <span class="badge bg-white text-dark border"><code>{UNIT_NO}</code> Plot/Flat No</span>
                            <span class="badge bg-white text-dark border"><code>{FORM_NO}</code> Form No</span>
                            <span class="badge bg-white text-dark border"><code>{BOOKING_DATE}</code> Date</span>
                            <span class="badge bg-white text-dark border"><code>{CONTACT_PHONE}</code> Phone</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="saveSettings">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <!-- Nav Tabs Header -->
            <div class="card-header bg-white border-bottom p-0">
                <ul class="nav nav-tabs nav-tabs-custom nav-success card-header-tabs border-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active py-3 px-4 fw-bold fs-14 d-flex align-items-center" data-bs-toggle="tab" href="#allotment-tab" role="tab">
                            <i class="ri-file-list-3-line me-2 fs-18"></i> Allotment Letter Content (आवंटन पत्र सामग्री)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-3 px-4 fw-bold fs-14 d-flex align-items-center" data-bs-toggle="tab" href="#demand-tab" role="tab">
                            <i class="ri-file-text-line me-2 fs-18"></i> Demand Letter Content (मांग पत्र सामग्री)
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content text-muted">
                    <!-- Tab 1: Allotment Letter -->
                    <div class="tab-pane active" id="allotment-tab" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Subtitle (उप-शीर्षक)</label>
                                <input type="text" class="form-control border-2 @error('allotment_subtitle') is-invalid @enderror" 
                                    wire:model="allotment_subtitle" placeholder="e.g. जयपुर विकास प्राधिकरण द्वारा अनुमोदित">
                                @error('allotment_subtitle') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Subject (विषय)</label>
                                <input type="text" class="form-control border-2 @error('allotment_subject') is-invalid @enderror" 
                                    wire:model="allotment_subject" placeholder="e.g. विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !">
                                @error('allotment_subject') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Main Body Paragraph (मुख्य विवरण पाठ)</label>
                                <textarea class="form-control border-2 @error('allotment_body') is-invalid @enderror" rows="4" 
                                    wire:model="allotment_body" placeholder="Enter Hindi allotment body text..."></textarea>
                                @error('allotment_body') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Footer Note (फुटर टिप्पणी)</label>
                                <input type="text" class="form-control border-2 @error('allotment_footer_note') is-invalid @enderror" 
                                    wire:model="allotment_footer_note" placeholder="e.g. नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।">
                                @error('allotment_footer_note') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Demand Letter -->
                    <div class="tab-pane" id="demand-tab" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Subtitle (उप-शीर्षक)</label>
                                <input type="text" class="form-control border-2 @error('demand_subtitle') is-invalid @enderror" 
                                    wire:model="demand_subtitle" placeholder="e.g. जयपुर विकास प्राधिकरण द्वारा अनुमोदित">
                                @error('demand_subtitle') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Subject (विषय)</label>
                                <input type="text" class="form-control border-2 @error('demand_subject') is-invalid @enderror" 
                                    wire:model="demand_subject" placeholder="e.g. विषय: भूखण्ड संख्या {UNIT_NO} की बकाया राशि जमा कराने बाबत।">
                                @error('demand_subject') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Main Body Paragraph (मुख्य विवरण पाठ)</label>
                                <textarea class="form-control border-2 @error('demand_body') is-invalid @enderror" rows="3" 
                                    wire:model="demand_body" placeholder="Enter Hindi demand letter body text..."></textarea>
                                @error('demand_body') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Footer Instructions & Terms Paragraph (मांग पत्र निर्देश व नियम शर्तें)</label>
                                <textarea class="form-control border-2 @error('demand_footer_para') is-invalid @enderror" rows="5" 
                                    wire:model="demand_footer_para" placeholder="Enter payment instructions and terms..."></textarea>
                                @error('demand_footer_para') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark">Footer Note (फुटर टिप्पणी)</label>
                                <input type="text" class="form-control border-2 @error('demand_footer_note') is-invalid @enderror" 
                                    wire:model="demand_footer_note" placeholder="e.g. नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।">
                                @error('demand_footer_note') <span class="text-danger fs-12">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="card-footer bg-light p-3 d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-outline-secondary px-3" wire:click="resetToDefault" 
                    wire:confirm="Are you sure you want to reset template content to default for this project?">
                    <i class="ri-refresh-line me-1"></i> Reset to Default (डिफ़ॉल्ट रीसेट करें)
                </button>
                <button type="submit" class="btn btn-success px-4 fw-bold">
                    <i class="ri-save-line me-1"></i> Save Settings (सेटिंग्स सुरक्षित करें)
                </button>
            </div>
        </div>
    </form>
</div>
