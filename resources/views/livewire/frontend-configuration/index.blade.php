<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Home Page Configuration</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title mb-3">Home Page Configuration <small class="text-muted fs-11">(Edit
                                    settings of the first
                                    viewport)</small></h4>

                            {{-- Tab Navigation --}}
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}"
                                        href="javascript:void(0)" wire:click="selectTab('general')" role="tab">
                                        <i class="ri-settings-4-line me-1 align-bottom"></i> Logo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'top-bar' ? 'active' : '' }}"
                                        href="javascript:void(0)" wire:click="selectTab('top-bar')" role="tab">
                                        <i class="ri-window-line me-1 align-bottom"></i> Top Bar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'bottom-bar' ? 'active' : '' }}"
                                        href="javascript:void(0)" wire:click="selectTab('bottom-bar')" role="tab">
                                        <i class="ri-menu-5-line me-1 align-bottom"></i> Bottom Bar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'sliders' ? 'active' : '' }}" href="javascript:void(0)" wire:click="selectTab('sliders')"
                                        role="tab">
                                        <i class="ri-menu-5-line me-1 align-bottom"></i> Sliders
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $activeTab === 'information-section' ? 'active' : '' }}"
                                        href="javascript:void(0)" wire:click="selectTab('information-section')"
                                        role="tab">
                                        <i class="ri-information-line me-1 align-bottom"></i> Information Section
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content text-muted">
                                {{-- ============================================ --}}
                                {{-- General Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'general' ? 'active' : '' }}" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">General Settings</h5>
                                            <p class="text-muted mb-0">Configure general website assets such as the
                                                brand logo.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_general'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success_general') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <form wire:submit.prevent="saveGeneral" class="mt-4">
                                        <div class="row gy-4">
                                            <div class="col-md-6">
                                                <label for="logo_file" class="form-label fw-medium">Website Logo</label>
                                                <input type="file" id="logo_file" class="form-control"
                                                    wire:model="logo_file" wire:key="logo-{{ $logoUploadIteration }}"
                                                    accept="image/*">
                                                <span class="d-block text-muted fs-12 mt-1">Recommended Dimension:
                                                    <strong>199 × 80 px</strong>. Max size: 2MB.</span>
                                                @error('logo_file')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 text-center">
                                                <label class="form-label fw-medium d-block">Current Logo Preview</label>
                                                @if ($logo_file)
                                                <img src="{{ $logo_file->temporaryUrl() }}" class="img-thumbnail"
                                                    style="max-height: 80px; object-fit: contain;">
                                                @elseif ($site_logo)
                                                <img src="{{ asset($site_logo) }}" class="img-thumbnail"
                                                    style="max-height: 80px; object-fit: contain;">
                                                @else
                                                <div class="text-muted border rounded p-4 d-inline-block">
                                                    <i class="ri-image-2-line fs-2 d-block mb-1"></i>
                                                    No Logo Uploaded
                                                </div>
                                                @endif
                                            </div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-success"
                                                    wire:loading.attr="disabled" wire:target="saveGeneral">
                                                    <span wire:loading wire:target="saveGeneral"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true" style="display: none;"></span>
                                                    Save Settings
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                {{-- ==============div=========================== --}}
                                {{-- Top Bar Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'top-bar' ? 'active' : '' }}" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">Top Bar Settings</h5>
                                            <p class="text-muted mb-0">Configure the announcement text, marquee
                                                behavior, and visibility at the top of the webpage.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_top_bar'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success_top_bar') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <form wire:submit.prevent="saveTopBar" class="mt-4">
                                        <div class="row gy-4">
                                            <div class="col-md-12">
                                                <label for="top_bar_text" class="form-label fw-medium">Announcement Text
                                                    (Supports Hindi)</label>
                                                <textarea id="top_bar_text" class="form-control" rows="3"
                                                    wire:model="top_bar_text"
                                                    placeholder="Enter announcement text to show in the top bar"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="top_bar_marquee"
                                                        wire:model="top_bar_marquee">
                                                    <label class="form-check-label fw-medium"
                                                        for="top_bar_marquee">Enable Scrolling Marquee Effect</label>
                                                    <span class="d-block text-muted fs-12">If unchecked, the text will
                                                        remain static.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="top_bar_show"
                                                        wire:model="top_bar_show">
                                                    <label class="form-check-label fw-medium" for="top_bar_show">Show
                                                        Top Bar</label>
                                                    <span class="d-block text-muted fs-12">Toggle to show or hide the
                                                        top bar on the frontend.</span>
                                                </div>
                                            </div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-success"
                                                    wire:loading.attr="disabled" wire:target="saveTopBar">
                                                    <span wire:loading wire:target="saveTopBar"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true" style="display: none;"></span>
                                                    Save Settings
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- ============================================ --}}
                                {{-- Bottom Bar Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'bottom-bar' ? 'active' : '' }}" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">Bottom Bar Settings</h5>
                                            <p class="text-muted mb-0">Configure bottom announcement bar text, marquee
                                                effect, and visibility underneath the home page banner.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_bottom_bar'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success_bottom_bar') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <form wire:submit.prevent="saveBottomBar" class="mt-4">
                                        <div class="row gy-4">
                                            <div class="col-md-12">
                                                <label for="bottom_bar_text" class="form-label fw-medium">Announcement
                                                    Text (Supports Hindi)</label>
                                                <textarea id="bottom_bar_text" class="form-control" rows="3"
                                                    wire:model="bottom_bar_text"
                                                    placeholder="Enter announcement text to show in the bottom bar"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="bottom_bar_marquee" wire:model="bottom_bar_marquee">
                                                    <label class="form-check-label fw-medium"
                                                        for="bottom_bar_marquee">Enable Scrolling Marquee Effect</label>
                                                    <span class="d-block text-muted fs-12">If unchecked, the text will
                                                        remain static.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="bottom_bar_show"
                                                        wire:model="bottom_bar_show">
                                                    <label class="form-check-label fw-medium" for="bottom_bar_show">Show
                                                        Bottom Bar</label>
                                                    <span class="d-block text-muted fs-12">Toggle to show or hide the
                                                        bottom bar on the frontend.</span>
                                                </div>
                                            </div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-success"
                                                    wire:loading.attr="disabled" wire:target="saveBottomBar">
                                                    <span wire:loading wire:target="saveBottomBar"
                                                        class="spinner-border spinner-border-sm me-1" role="status"
                                                        aria-hidden="true" style="display: none;"></span>
                                                    Save Settings
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- ============================================ --}}
                                {{-- Sliders Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'sliders' ? 'active' : '' }}" role="tabpanel">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">Slider Settings</h5>
                                            <p class="text-muted mb-0">Manage slides for the home slider banner (formerly Home Slider).</p>
                                        </div>
                                        @if(!$showBannerForm)
                                            <button type="button" class="btn btn-primary" wire:click="createBanner">
                                                <i class="ri-add-line align-bottom me-1"></i> Add Slide Banner
                                            </button>
                                        @endif
                                    </div>
                                    <hr>

                                    @if (session()->has('success_banner'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_banner') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if($showBannerForm)
                                        {{-- Create / Edit Slide form --}}
                                        <div class="card border shadow-none mt-3">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title mb-0">{{ $bannerId ? 'Edit Slide Banner' : 'Create Slide Banner' }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <form wire:submit.prevent="saveBanner">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control rounded-pill @error('banner_title') is-invalid @enderror" wire:model="banner_title" placeholder="Enter slide title">
                                                            @error('banner_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Subtitle</label>
                                                            <input type="text" class="form-control rounded-pill @error('banner_subtitle') is-invalid @enderror" wire:model="banner_subtitle" placeholder="Enter slide subtitle">
                                                            @error('banner_subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Link Type</label>
                                                            <select class="form-select rounded-pill" wire:model.live="banner_link_type">
                                                                <option value="custom">Custom URL</option>
                                                                <option value="project">Link to Project</option>
                                                            </select>
                                                        </div>

                                                        @if($banner_link_type === 'custom')
                                                            <div class="col-md-8">
                                                                <label class="form-label fw-semibold">Custom Link URL</label>
                                                                <input type="url" class="form-control rounded-pill @error('banner_button_link') is-invalid @enderror" wire:model="banner_button_link" placeholder="https://example.com">
                                                                @error('banner_button_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                        @else
                                                            <div class="col-md-8">
                                                                <label class="form-label fw-semibold">Select Project</label>
                                                                <select class="form-select rounded-pill @error('banner_project_id') is-invalid @enderror" wire:model="banner_project_id">
                                                                    <option value="">Select Project</option>
                                                                    @foreach($projects as $p)
                                                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('banner_project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                        @endif

                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Button Text</label>
                                                            <input type="text" class="form-control rounded-pill @error('banner_button_text') is-invalid @enderror" wire:model="banner_button_text" placeholder="e.g. Register Now">
                                                            @error('banner_button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Sort Order</label>
                                                            <input type="number" class="form-control rounded-pill @error('banner_sort_order') is-invalid @enderror" wire:model="banner_sort_order" min="0">
                                                            @error('banner_sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Status</label>
                                                            <select class="form-select rounded-pill @error('banner_status') is-invalid @enderror" wire:model="banner_status">
                                                                <option value="active">Active</option>
                                                                <option value="inactive">Inactive</option>
                                                            </select>
                                                            @error('banner_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Desktop Image <span class="text-danger">*</span></label>
                                                            <input type="file" class="form-control @error('banner_desktop_file') is-invalid @enderror" wire:model="banner_desktop_file" wire:key="desktop-{{ $bannerUploadIteration }}" accept="image/*">
                                                            <small class="text-muted">Recommended size: 1920x600. Max 2MB.</small>
                                                            @error('banner_desktop_file') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                                            @if($banner_desktop_file)
                                                                <div class="mt-2">
                                                                    <span class="text-success d-block mb-1">Temporary Preview:</span>
                                                                    <img src="{{ $banner_desktop_file->temporaryUrl() }}" class="img-thumbnail" style="max-height: 120px;">
                                                                </div>
                                                            @elseif($banner_desktop_image)
                                                                <div class="mt-2">
                                                                    <span class="text-muted d-block mb-1">Current Image:</span>
                                                                    <img src="{{ asset($banner_desktop_image) }}" class="img-thumbnail" style="max-height: 120px;">
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Mobile Image</label>
                                                            <input type="file" class="form-control @error('banner_mobile_file') is-invalid @enderror" wire:model="banner_mobile_file" wire:key="mobile-{{ $bannerUploadIteration }}" accept="image/*">
                                                            <small class="text-muted">Recommended size: 600x400. Max 2MB.</small>
                                                            @error('banner_mobile_file') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                                            @if($banner_mobile_file)
                                                                <div class="mt-2">
                                                                    <span class="text-success d-block mb-1">Temporary Preview:</span>
                                                                    <img src="{{ $banner_mobile_file->temporaryUrl() }}" class="img-thumbnail" style="max-height: 120px;">
                                                                </div>
                                                            @elseif($banner_mobile_image)
                                                                <div class="mt-2">
                                                                    <span class="text-muted d-block mb-1">Current Image:</span>
                                                                    <img src="{{ asset($banner_mobile_image) }}" class="img-thumbnail" style="max-height: 120px;">
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="col-12 text-end mt-4">
                                                            <button type="button" class="btn btn-light rounded-pill me-2" wire:click="cancelBannerForm">Cancel</button>
                                                            <button type="submit" class="btn btn-success rounded-pill" wire:loading.attr="disabled" wire:target="saveBanner">
                                                                <span wire:loading wire:target="saveBanner" class="spinner-border spinner-border-sm me-1" role="status" style="display: none;"></span>
                                                                Save Slide
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Banner Listing Table --}}
                                        <div class="table-responsive mt-3">
                                            <table class="table table-bordered table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="80">Image</th>
                                                        <th>Title</th>
                                                        <th>Subtitle</th>
                                                        <th>Link</th>
                                                        <th width="100">Sort Order</th>
                                                        <th width="100">Status</th>
                                                        <th width="120">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($banners as $banner)
                                                        <tr wire:key="banner-row-{{ $banner->id }}">
                                                            <td>
                                                                @if($banner->desktop_image)
                                                                    <img src="{{ asset($banner->desktop_image) }}" class="rounded" style="width:70px;height:45px;object-fit:cover;">
                                                                @else
                                                                    <span class="text-muted">No image</span>
                                                                @endif
                                                            </td>
                                                            <td class="fw-medium text-dark">{{ $banner->title }}</td>
                                                            <td>{{ $banner->subtitle }}</td>
                                                            <td>
                                                                @if($banner->button_link)
                                                                    <span class="badge bg-info-subtle text-info">{{ $banner->button_link }}</span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm text-center" value="{{ $banner->sort_order }}" wire:change="updateBannerSortOrder('{{ $banner->id }}', $event.target.value)" style="width: 70px;">
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm {{ $banner->status === 'active' ? 'btn-success' : 'btn-danger' }}" wire:click="toggleBannerStatus('{{ $banner->id }}')">
                                                                    {{ ucfirst($banner->status) }}
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-light" wire:click="editBanner('{{ $banner->id }}')">
                                                                        <i class="ri-edit-line text-primary"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-light" wire:click="deleteBanner('{{ $banner->id }}')" onclick="return confirm('Are you sure you want to delete this slide?')">
                                                                        <i class="ri-delete-bin-line text-danger"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center py-4 text-muted">No banner slides found. Click "Add Slide Banner" to create one.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>

                                {{-- ============================================ --}}
                                {{-- Information Section Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'information-section' ? 'active' : '' }}"
                                    role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">Information Section Images</h5>
                                            <p class="text-muted mb-0">Manage images on the homepage of the div, images
                                                are in the numeric hirarchy like 1,2,3,4.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_info'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success_info') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    {{-- Image Upload block --}}
                                    <div class="card border shadow-none mt-3">
                                        <div class="card-body">
                                            <div class="row align-items-end">
                                                <div class="col-lg-8">
                                                    <label class="form-label fw-semibold">Upload Information
                                                        Images</label>
                                                    <input type="file" class="form-control"
                                                        wire:model="info_image_files"
                                                        wire:key="info-upload-{{ $infoUploadIteration }}" multiple
                                                        accept="image/*">
                                                    <small class="text-muted">You can select multiple images. Supported
                                                        formats: JPG, PNG, and WEBP. Recommended image
                                                        width: 1600px. Height can vary depending on your
                                                        requirements. Maximum file size: 2 MB per image.</small>
                                                    @error('info_image_files.*')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 text-start">
                                                    <div wire:loading wire:target="updatedInfoImageFiles"
                                                        class="text-primary mt-2" style="display: none;">
                                                        <span class="spinner-border spinner-border-sm me-1"
                                                            role="status"></span>
                                                        Uploading and saving images...
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Image List --}}
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="120">Image Preview</th>
                                                    <th>File Path</th>
                                                    <th width="120">Sort Order</th>
                                                    <th width="80">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($infoImages as $img)
                                                <tr wire:key="info-img-row-{{ $img->id }}">
                                                    <td>
                                                        <img src="{{ asset($img->image_path) }}"
                                                            class="rounded img-thumbnail"
                                                            style="width: 100px; height: 60px; object-fit: cover;">
                                                    </td>
                                                    <td class="text-muted fs-13">{{ $img->image_path }}</td>
                                                    <td>
                                                        <input type="number"
                                                            class="form-control form-control-sm text-center"
                                                            value="{{ $img->sort_order }}"
                                                            wire:change="updateInfoImageSortOrder('{{ $img->id }}', $event.target.value)"
                                                            style="width: 70px;">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="deleteInfoImage('{{ $img->id }}')"
                                                            onclick="return confirm('Are you sure you want to delete this image?')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="4" class="text-center py-4 text-muted">No information
                                                        images uploaded. Use the upload field above to add images.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
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