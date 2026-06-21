<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Home Slider</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Home Slider</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card">

                        <div class="card-header">
                            <div class="row align-items-center g-3">

                                <div class="col-md-4">
                                    <h4 class="card-title mb-0">
                                        Home Sliders
                                    </h4>
                                </div>

                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Search title or subtitle..."
                                        wire:model.live.debounce.300ms="search">
                                </div>

                                <div class="col-md-2">
                                    <select class="form-select" wire:model.live="status">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-2 text-md-end">
                                    <a href="{{ route('home-sliders.create') }}" class="btn btn-primary w-100">
                                        <i class="ri-add-line align-bottom me-1"></i>
                                        Add Slider
                                    </a>
                                </div>

                            </div>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover align-middle mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th width="60">#</th>
                                            <th width="120">Image</th>
                                            <th>Title</th>
                                            <th>Subtitle</th>
                                            <th width="100">Order</th>
                                            <th width="120">Status</th>
                                            <th width="180">Created</th>
                                            <th width="180">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($sliders as $slider)

                                            <tr>
                                                <td>
                                                    {{ $loop->iteration + (($sliders->currentPage() - 1) * $sliders->perPage()) }}
                                                </td>

                                                <td>
                                                    @if($slider->desktop_image)
                                                        <img src="{{ asset($slider->desktop_image) }}"
                                                            alt="{{ $slider->title }}" class="img-thumbnail"
                                                            style="height:60px;width:100px;object-fit:cover;">
                                                    @else
                                                        <span class="text-muted">
                                                            No Image
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <strong>{{ $slider->title }}</strong>
                                                </td>

                                                <td>
                                                    {{ $slider->subtitle ?: '-' }}
                                                </td>

                                                <td>
                                                    {{ $slider->sort_order }}
                                                </td>

                                                <td>
                                                    <button type="button" wire:click="updateStatus('{{ $slider->id }}')"
                                                        class="btn btn-sm {{ $slider->status === 'active' ? 'btn-success' : 'btn-danger' }}">
                                                        {{ ucfirst($slider->status) }}
                                                    </button>
                                                </td>

                                                <td>
                                                    {{ $slider->created_at?->format('d M Y') }}
                                                </td>

                                                <td>

                                                    <div class="d-flex gap-2">

                                                        <a href="{{ route('home-sliders.edit', $slider->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>

                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="delete('{{ $slider->id }}')"
                                                            wire:confirm="Are you sure you want to delete this slider?">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    No sliders found.
                                                </td>
                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                            @if($sliders->hasPages())
                                <div class="mt-3">
                                    {{ $sliders->links() }}
                                </div>
                            @endif

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>