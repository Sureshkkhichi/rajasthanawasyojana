<div>
    <div class="page-content">
        <div class="container-fluid">

            <!-- Breadcrumb Header -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0 fw-semibold text-primary">
                            <i class="ri-file-code-line align-middle me-1"></i> PDF Document Templates
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                                <li class="breadcrumb-item active">PDF Templates</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Target Project Selector -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary-subtle py-3">
                            <h5 class="card-title text-primary mb-0 d-flex align-items-center fw-bold">
                                <i class="ri-building-2-line me-2 fs-18"></i> Select Target Project (परियोजना का चयन करें)
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark fs-14 mb-1">Target Project <span class="text-danger">*</span></label>
                                    <select class="form-select border-2 py-2 fw-semibold text-primary fs-15" wire:model.live="selectedProjectId">
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <div class="bg-light p-3 rounded-3 border">
                                        <span class="badge bg-primary mb-1 fs-12">Dynamic Tags (डायनामिक टैग्स)</span>
                                        <p class="fs-12 text-muted mb-0">कंटेंट में यह टैग्स लिखने पर PDF में असली डेटा आ जाएगा:</p>
                                        <div class="d-flex flex-wrap gap-1 mt-2">
                                            <span class="badge bg-white text-dark border"><code>{PROJECT_NAME}</code> Project</span>
                                            <span class="badge bg-white text-dark border"><code>{PROJECT_ADDRESS}</code> Address</span>
                                            <span class="badge bg-white text-dark border"><code>{CUSTOMER_NAME}</code> Customer</span>
                                            <span class="badge bg-white text-dark border"><code>{UNIT_NO}</code> Plot/Flat</span>
                                            <span class="badge bg-white text-dark border"><code>{FORM_NO}</code> Form No</span>
                                            <span class="badge bg-white text-dark border"><code>{BOOKING_DATE}</code> Date</span>
                                            <span class="badge bg-white text-dark border"><code>{CONTACT_PHONE}</code> Phone</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Template Form -->
            <form wire:submit.prevent="saveSettings">
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header border-bottom bg-light px-4 py-3">
                                <ul class="nav nav-pills card-header-pills" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link fw-bold px-4 py-2 {{ $activeTab === 'allotmentTab' ? 'active bg-primary text-white shadow-sm' : 'text-dark bg-white border' }}" 
                                            wire:click="$set('activeTab', 'allotmentTab')">
                                            <i class="ri-file-list-3-line me-1"></i> Allotment Letter Content (आवंटन पत्र)
                                        </button>
                                    </li>
                                    <li class="nav-item ms-2">
                                        <button type="button" class="nav-link fw-bold px-4 py-2 {{ $activeTab === 'demandTab' ? 'active bg-primary text-white shadow-sm' : 'text-dark bg-white border' }}" 
                                            wire:click="$set('activeTab', 'demandTab')">
                                            <i class="ri-file-text-line me-1"></i> Demand Letter Content (मांग पत्र)
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body p-4">
                                @if($activeTab === 'allotmentTab')
                                    <!-- Tab 1: Allotment Letter -->
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
                                @elseif($activeTab === 'demandTab')
                                    <!-- Tab 2: Demand Letter -->
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
                                @endif
                            </div>

                            <!-- Footer Action Buttons -->
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
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
