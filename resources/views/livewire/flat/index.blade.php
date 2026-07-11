<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Flats</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Flats</a>
                                </li>
                                <li class="breadcrumb-item active">List</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Table --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Flat List</h4>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 250px;">
                                        <input type="text" class="form-control rounded-pill" placeholder="Search..." wire:model.live.debounce.500ms="search">
                                    </div>
                                    @can('flats.create')
                                        <a href="{{ route('flats.create') }}" class="btn btn-success rounded-pill">
                                            <i class="ri-add-line align-bottom me-1"></i> Add New
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th width="80">#</th>
                                            <th>Flat Name</th>
                                            <th>Slug</th>
                                            <th width="120">Status</th>
                                            <th width="150">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($flats as $flat)
                                            <tr wire:key="flat-row-{{ $flat->id }}">
                                                <td>{{ $flats->firstItem() + $loop->index }}</td>
                                                <td>{{ $flat->name }}</td>
                                                <td>{{ $flat->slug }}</td>
                                                <td>
                                                    @if($flat->status === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(auth()->user()->can('flats.edit') || auth()->user()->can('flats.delete'))
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu shadow">
                                                            @can('flats.edit')
                                                            <li>
                                                                <a class="dropdown-item py-2" href="{{ route('flats.edit', $flat->id) }}">
                                                                    <i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            @endcan
                                                            @can('flats.delete')
                                                            <li>
                                                                <button class="dropdown-item py-2 text-danger" type="button" wire:click="delete('{{ $flat->id }}')" wire:confirm="Are you sure?">
                                                                    <i class="ri-delete-bin-line align-bottom me-2"></i> Delete
                                                                </button>
                                                            </li>
                                                            @endcan
                                                        </ul>
                                                    </div>
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">No records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($flats->hasPages())
                            <div class="card-footer">
                                {{ $flats->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
