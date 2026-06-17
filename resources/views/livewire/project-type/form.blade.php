<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Add Project Type</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('project-types.index') }}">Project
                                        Type</a></li>
                                <li class="breadcrumb-item active">Add New Project</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Filter --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Add New Project</h4>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label class="form-label">Project Type</label>
                                            <input type="text" class="form-control rounded-pill"
                                                placeholder="Enter project type">
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label class="form-label">Slug</label>
                                            <input type="text" class="form-control rounded-pill"
                                                placeholder="Enter slug">
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label class="form-label">Status</label>
                                            <select class="form-select rounded-pill mb-3"
                                                aria-label="Default select example">
                                                <option selected="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                <a href="#" class="btn btn-light">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line align-bottom me-1"></i>
                                    Save & Continue
                                </button>
                                <button type="button" class="btn btn-success">
                                    <i class="ri-add-line align-bottom me-1"></i>
                                    Save & Add New
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>