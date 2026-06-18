<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Project Type</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">
                                        Project Type
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">
                                    List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif
            {{-- Table --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">
                                    Project Type List
                                </h4>
                                <div class="d-flex align-items-center gap-2">

                                    <div style="width: 250px;">
                                        <input type="text" class="form-control rounded-pill" placeholder="Search..."
                                            wire:model.live.debounce.500ms="search">
                                    </div>

                                    <a href="{{ route('project-types.create') }}" class="btn btn-success rounded-pill">

                                        <i class="ri-add-line align-bottom me-1"></i>
                                        Add New
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th width="80">
                                                #
                                            </th>
                                            <th>
                                                Project Type
                                            </th>
                                            <th>
                                                Slug
                                            </th>
                                            <th width="120">
                                                Status
                                            </th>
                                            <th width="150">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($projectTypes as $projectType)
                                            <tr>
                                                <td>
                                                    {{ $projectTypes->firstItem() + $loop->index }}
                                                </td>
                                                <td>
                                                    {{ $projectType->name }}
                                                </td>
                                                <td>
                                                    {{ $projectType->slug }}
                                                </td>
                                                <td>
                                                    @if($projectType->status === 'active')
                                                        <span class="badge bg-success">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('project-types.edit', $projectType->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="delete('{{ $projectType->id }}')"
                                                            wire:confirm="Are you sure?">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4">
                                                    No records found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($projectTypes->hasPages())
                            <div class="card-footer">
                                {{ $projectTypes->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>