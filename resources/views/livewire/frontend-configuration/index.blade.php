<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Frontend Configuration</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Frontend</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Configuration
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0">
                            <h4 class="card-title mb-3">Manage Website Sections</h4>
                            {{-- Tab Navigation --}}
                             <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                 <li class="nav-item">
                                     <a class="nav-link {{ $activeTab === 'general' ? 'active' : '' }}" href="javascript:void(0)" wire:click="selectTab('general')" role="tab">
                                         <i class="ri-settings-4-line me-1 align-bottom"></i> General
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link {{ $activeTab === 'top-bar' ? 'active' : '' }}" href="javascript:void(0)" wire:click="selectTab('top-bar')" role="tab">
                                         <i class="ri-window-line me-1 align-bottom"></i> Top Bar
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link {{ $activeTab === 'bottom-bar' ? 'active' : '' }}" href="javascript:void(0)" wire:click="selectTab('bottom-bar')" role="tab">
                                         <i class="ri-menu-5-line me-1 align-bottom"></i> Bottom Bar
                                     </a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link {{ $activeTab === 'information-section' ? 'active' : '' }}" href="javascript:void(0)" wire:click="selectTab('information-section')" role="tab">
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
                                             <p class="text-muted mb-0">Configure general website assets such as the brand logo.</p>
                                         </div>
                                     </div>
                                     <hr>

                                     @if (session()->has('success_general'))
                                         <div class="alert alert-success alert-dismissible fade show" role="alert">
                                             {{ session('success_general') }}
                                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                         </div>
                                     @endif

                                     <form wire:submit.prevent="saveGeneral" class="mt-4">
                                         <div class="row gy-4">
                                             <div class="col-md-6">
                                                 <label for="logo_file" class="form-label fw-medium">Website Logo</label>
                                                 <input type="file" id="logo_file" class="form-control" wire:model="logo_file" wire:key="logo-{{ $logoUploadIteration }}" accept="image/*">
                                                 <span class="d-block text-muted fs-12 mt-1">Recommended Dimension: <strong>199 × 80 px</strong>. Max size: 2MB.</span>
                                                 @error('logo_file')
                                                     <div class="text-danger mt-1">{{ $message }}</div>
                                                 @enderror
                                             </div>

                                             <div class="col-md-6 text-center">
                                                 <label class="form-label fw-medium d-block">Current Logo Preview</label>
                                                 @if ($logo_file)
                                                     <img src="{{ $logo_file->temporaryUrl() }}" class="img-thumbnail" style="max-height: 80px; object-fit: contain;">
                                                 @elseif ($site_logo)
                                                     <img src="{{ asset($site_logo) }}" class="img-thumbnail" style="max-height: 80px; object-fit: contain;">
                                                 @else
                                                     <div class="text-muted border rounded p-4 d-inline-block">
                                                         <i class="ri-image-2-line fs-2 d-block mb-1"></i>
                                                         No Logo Uploaded
                                                     </div>
                                                 @endif
                                             </div>

                                             <div class="col-12 text-end">
                                                 <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="saveGeneral">
                                                     <span wire:loading wire:target="saveGeneral" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" style="display: none;"></span>
                                                     Save Settings
                                                 </button>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                                {{-- ============================================ --}}
                                {{-- Top Bar Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'top-bar' ? 'active' : '' }}" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">Top Bar Settings</h5>
                                            <p class="text-muted mb-0">Configure the announcement text, marquee behavior, and visibility at the top of the webpage.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_top_bar'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_top_bar') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form wire:submit.prevent="saveTopBar" class="mt-4">
                                        <div class="row gy-4">
                                            <div class="col-md-12">
                                                <label for="top_bar_text" class="form-label fw-medium">Announcement Text (Supports Hindi)</label>
                                                <textarea id="top_bar_text" class="form-control" rows="3" wire:model="top_bar_text" placeholder="Enter announcement text to show in the top bar"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="top_bar_marquee" wire:model="top_bar_marquee">
                                                    <label class="form-check-label fw-medium" for="top_bar_marquee">Enable Scrolling Marquee Effect</label>
                                                    <span class="d-block text-muted fs-12">If unchecked, the text will remain static.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="top_bar_show" wire:model="top_bar_show">
                                                    <label class="form-check-label fw-medium" for="top_bar_show">Show Top Bar</label>
                                                    <span class="d-block text-muted fs-12">Toggle to show or hide the top bar on the frontend.</span>
                                                </div>
                                            </div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="saveTopBar">
                                                    <span wire:loading wire:target="saveTopBar" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" style="display: none;"></span>
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
                                            <p class="text-muted mb-0">Configure bottom announcement bar text, marquee effect, and visibility underneath the home page banner.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_bottom_bar'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_bottom_bar') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form wire:submit.prevent="saveBottomBar" class="mt-4">
                                        <div class="row gy-4">
                                            <div class="col-md-12">
                                                <label for="bottom_bar_text" class="form-label fw-medium">Announcement Text (Supports Hindi)</label>
                                                <textarea id="bottom_bar_text" class="form-control" rows="3" wire:model="bottom_bar_text" placeholder="Enter announcement text to show in the bottom bar"></textarea>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="bottom_bar_marquee" wire:model="bottom_bar_marquee">
                                                    <label class="form-check-label fw-medium" for="bottom_bar_marquee">Enable Scrolling Marquee Effect</label>
                                                    <span class="d-block text-muted fs-12">If unchecked, the text will remain static.</span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-switch-md">
                                                    <input class="form-check-input" type="checkbox" id="bottom_bar_show" wire:model="bottom_bar_show">
                                                    <label class="form-check-label fw-medium" for="bottom_bar_show">Show Bottom Bar</label>
                                                    <span class="d-block text-muted fs-12">Toggle to show or hide the bottom bar on the frontend.</span>
                                                </div>
                                            </div>

                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:target="saveBottomBar">
                                                    <span wire:loading wire:target="saveBottomBar" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true" style="display: none;"></span>
                                                    Save Settings
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- ============================================ --}}
                                {{-- Information Section Tab --}}
                                {{-- ============================================ --}}
                                <div class="tab-pane {{ $activeTab === 'information-section' ? 'active' : '' }}" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-grow-1">
                                            <h5 class="fs-16 fw-semibold text-dark">Information Section Images</h5>
                                            <p class="text-muted mb-0">Manage images displayed in the informational grid at the bottom of the home page.</p>
                                        </div>
                                    </div>
                                    <hr>

                                    @if (session()->has('success_info'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success_info') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    {{-- Image Upload block --}}
                                    <div class="card border shadow-none mt-3">
                                        <div class="card-body">
                                            <div class="row align-items-end">
                                                <div class="col-lg-8">
                                                    <label class="form-label fw-semibold">Upload Information Images</label>
                                                    <input type="file" class="form-control" wire:model="info_image_files" wire:key="info-upload-{{ $infoUploadIteration }}" multiple accept="image/*">
                                                    <small class="text-muted">You can select multiple images. Supported formats: JPG, PNG, WEBP. Max 2MB each.</small>
                                                    @error('info_image_files.*')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 text-start">
                                                    <div wire:loading wire:target="updatedInfoImageFiles" class="text-primary mt-2" style="display: none;">
                                                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
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
                                                            <img src="{{ asset($img->image_path) }}" class="rounded img-thumbnail" style="width: 100px; height: 60px; object-fit: cover;">
                                                        </td>
                                                        <td class="text-muted fs-13">{{ $img->image_path }}</td>
                                                        <td>
                                                            <input type="number" class="form-control form-control-sm text-center" value="{{ $img->sort_order }}" wire:change="updateInfoImageSortOrder('{{ $img->id }}', $event.target.value)" style="width: 70px;">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-danger" wire:click="deleteInfoImage('{{ $img->id }}')" onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">No information images uploaded. Use the upload field above to add images.</td>
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
