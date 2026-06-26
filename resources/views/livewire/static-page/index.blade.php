<div>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Pages</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Frontend</a>
                                </li>
                                <li class="breadcrumb-item active">Pages</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Static Page Editor</h4>
                            </div>
                            <div class="card-body">
                                <div class="row gy-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Page</label>
                                        <select class="form-select rounded-pill @error('selectedPageId') is-invalid @enderror" wire:model.live="selectedPageId">
                                            @foreach($pages as $pageOption)
                                                <option value="{{ $pageOption->id }}">{{ $pageOption->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('selectedPageId')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control rounded-pill @error('title') is-invalid @enderror" wire:model="title">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-select rounded-pill @error('status') is-invalid @enderror" wire:model="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Content Editor</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" rows="18" wire:model="content" placeholder="Enter page content. HTML tags are supported."></textarea>
                                        <small class="text-muted">HTML tags are supported for headings, paragraphs, lists, links, and formatting.</small>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                @can('pages.edit')
                                    <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                        <i class="ri-save-line align-bottom me-1"></i>
                                        Save Page
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
