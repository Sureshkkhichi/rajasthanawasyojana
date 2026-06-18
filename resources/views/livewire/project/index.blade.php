<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Projects</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">Projects</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    List
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Search Filter --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Search Filter
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-5">
                                    <label class="form-label">
                                        Keyword
                                    </label>
                                    <input type="text" class="form-control" placeholder="Project Name / Slug" wire:model.live.debounce.500ms="keyword">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Project Status
                                    </label>
                                    <select class="form-select" wire:model.live="status">
                                        <option value=""> All Status </option>
                                        @foreach (config('constants.project_status') as $key => $project_status )
                                        <option value="{{ $key }}">{{ $project_status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">
                                        Visibility
                                    </label>
                                    <select class="form-select" wire:model.live="is_active">
                                        <option value="">
                                            All
                                        </option>
                                        <option value="active">
                                            Active
                                        </option>
                                        <option value="inactive">
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Project List --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                Project List
                            </h4>
                            <a href="{{ route('projects.create') }}" class="btn btn-success">
                                <i class="ri-add-line me-1"></i>
                                Add New Project
                            </a>
                        </div>
                        <div class="card-body">
                            <div wire:loading>
                                <div class="alert alert-info mb-3">
                                    Loading...
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="80"> # </th>
                                            <th> Project Name </th>
                                            <th> Project Type </th>
                                            <th> Location </th>
                                            <th>Project Status</th>
                                            <th>Visibility</th>
                                            <th width="130"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($projects as $project)
                                        <tr style="cursor:pointer" onclick="window.location='{{ route('projects.edit', $project->id) }}'">
                                            <td> {{ $loop->iteration }} </td>
                                            <td>
                                                <div class="fw-semibold"> {{ $project->name }} </div>
                                                <small class="text-muted"> {{ $project->slug }} </small>
                                            </td>
                                            <td> {{ $project->projectType?->name }} </td>
                                            <td> {{ $project->city?->name }} @if($project->state) , {{ $project->state?->name }} @endif </td>
                                            <td>
                                                <span class="badge bg-primary"> {{ ucfirst($project->status) }} </span>
                                            </td>
                                            <td onclick="event.stopPropagation();">
                                                <div class="form-check form-switch d-flex align-items-center gap-2">
                                                    <input class="form-check-input" type="checkbox" role="switch" wire:change="toggleStatus('{{ $project->id }}')" @checked($project->is_active === 'active')>
                                                    <span class="badge {{ $project->is_active === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                        {{ ucfirst($project->is_active) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td onclick="event.stopPropagation();">
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-soft-info">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-soft-danger" wire:click="delete('{{ $project->id }}')" wire:confirm="Are you sure?">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4"> No projects found. </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if(method_exists($projects, 'links'))
                            <div class="mt-3"> {{ $projects->links() }} </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
