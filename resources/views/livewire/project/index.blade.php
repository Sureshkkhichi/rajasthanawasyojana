<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Projects</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Projects</a></li>
                                <li class="breadcrumb-item active">List</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Input Example</h4>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-3 col-md-6">
                                        <div>
                                            <label for="exampleInputrounded" class="form-label">Status</label>
                                            <input type="text" class="form-control rounded-pill"
                                                id="exampleInputrounded" placeholder="Enter your name">
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

                                    <div class="col-xxl-3 col-md-6">
                                        <div class="d-flex justify-content-end align-items-bottom gap-2 flex-wrap">
                                            <button type="button" class="btn btn-success">
                                                <i class="ri-add-line align-bottom me-1"></i>
                                                Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Table --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Project List</h4>
                            <div class="flex-shrink-0">
                                <a href="{{ route('projects.create') }}" class="btn btn-success btn-label rounded-pill">
                                    <i class="ri-add-line label-icon align-middle rounded-pill fs-16 me-2">
                                    </i>
                                    Add New Project
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive">
                                    <table class="table table-hover table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">SR. No.</th>
                                                <th scope="col">Project Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Default</td>
                                                <td>Monkey Karry</td>
                                                <td>Medical Specialist</td>
                                                <td>Orthopedics</td>
                                            </tr>
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
