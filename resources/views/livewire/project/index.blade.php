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
                                    <input type="text" class="form-control" placeholder="Project Name / Slug"
                                        wire:model.live.debounce.500ms="keyword">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Project Status
                                    </label>
                                    <select class="form-select" wire:model.live="status">
                                        <option value=""> All Status </option>
                                        @foreach (config('constants.project_status') as $key => $project_status)
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
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif
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
                                            <th width="100"> Image </th>
                                            <th> Project Name </th>
                                            <th> Project Type </th>
                                            <th> Flat </th>
                                            <th> Location </th>
                                            <th>Project Status</th>
                                            <th>Visibility</th>
                                            <th>Show on Homepage</th>
                                            <th width="130"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($projects as $project)
                                            <tr style="cursor:pointer"
                                                onclick="window.location='{{ route('projects.edit', $project->id) }}'">
                                                <td> {{ $loop->iteration }} </td>
                                                <td>
                                                    @if($project->featured_image)
                                                        <img src="{{ asset($project->featured_image) }}"
                                                            alt="{{ $project->name }}"
                                                            class="rounded border"
                                                            style="width:70px;height:50px;object-fit:cover;">
                                                    @else
                                                        <span class="badge bg-light text-muted border">No Image</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="fw-semibold"> {{ $project->name }} </div>
                                                    <small class="text-muted"> {{ $project->slug }} </small>
                                                </td>
                                                <td> {{ $project->projectType?->name }} </td>
                                                <td> {{ $project->flat?->name ?? '-' }} </td>
                                                <td> {{ $project->city }} </td>
                                                <td>
                                                    <span class="badge bg-primary"> {{ ucfirst($project->status) }} </span>
                                                </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="form-check form-switch d-flex align-items-center gap-2">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            wire:change="toggleStatus('{{ $project->id }}')"
                                                            @checked($project->is_active === 'active')>
                                                        <span
                                                            class="badge {{ $project->is_active === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ ucfirst($project->is_active) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="form-check form-switch d-flex align-items-center gap-2">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            wire:change="toggleShowOnHomepage('{{ $project->id }}')"
                                                            @checked($project->show_on_homepage === 'active')>
                                                        <span
                                                            class="badge {{ $project->show_on_homepage === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $project->show_on_homepage === 'active' ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu shadow">
                                                            <li>
                                                                <a class="dropdown-item py-2" href="{{ route('projects.edit', $project->id) }}">
                                                                    <i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item py-2 text-danger" type="button" wire:click="delete('{{ $project->id }}')" wire:confirm="Are you sure?">
                                                                    <i class="ri-delete-bin-line align-bottom me-2"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4"> No projects found. </td>
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
