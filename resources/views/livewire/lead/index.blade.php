<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">
                            Leads
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="javascript:void(0)">
                                        Leads
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
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Name
                                    </label>
                                    <input type="text" class="form-control" placeholder="Search by Name"
                                        wire:model.live.debounce.500ms="search_name">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Mobile Number
                                    </label>
                                    <input type="text" class="form-control" placeholder="Search by Mobile"
                                        wire:model.live.debounce.500ms="search_mobile">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Email
                                    </label>
                                    <input type="text" class="form-control" placeholder="Search by Email"
                                        wire:model.live.debounce.500ms="search_email">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Project
                                    </label>
                                    <select class="form-select" wire:model.live="project_id">
                                        <option value="">
                                            All Projects
                                        </option>
                                        @foreach($projects as $project)
                                        <option value="{{ $project->id }}">
                                            {{ $project->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Lead Status
                                    </label>
                                    <select class="form-select" wire:model.live="status">
                                        <option value="">
                                            All Lead Status
                                        </option>
                                        @foreach (config('constants.lead_statuses') as $key => $status)
                                        <option value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
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
            {{-- Lead List --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                Lead List
                            </h4>
                            <div class="d-flex gap-2">
                                <button type="button" wire:click="export" class="btn btn-success btn-sm">
                                    <i class="ri-file-download-line align-bottom me-1"></i> Download Excel
                                </button>
                                @can('leads.edit')
                                <a href="{{ route('leads.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ri-add-line align-bottom me-1"></i> Add New Lead
                                </a>
                                @endcan
                            </div>
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
                                            <th width="70"> SR. No. </th>
                                            <th> Name </th>
                                            <th> Mobile </th>
                                            <th> Project </th>
                                            <th> City </th>
                                            <th> Flat Size </th>
                                            <th> Source / Added By </th>
                                            <th> Lead Status </th>
                                            <th> Enquiry Date </th>
                                            <th> Enquiry Time </th>
                                            <th width="120"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($leads as $lead)
                                        <tr style="cursor:pointer"
                                            onclick="window.location='{{ route('leads.edit', $lead->id) }}'">
                                            <td> {{ $loop->iteration }} </td>
                                            <td>
                                                <div class="fw-semibold">
                                                    {{ $lead->first_name }}
                                                    {{ $lead->last_name }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $lead->pan_number }}
                                                </small>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $lead->phone }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $lead->email }}
                                                </small>
                                            </td>
                                            <td> {{ $lead->project?->name }} </td>
                                            <td> {{ $lead->city }} </td>
                                            <td> {{ $lead->flat_size }} </td>
                                            <td>
                                                @if(is_null($lead->created_by))
                                                    <span class="badge bg-soft-success text-success">
                                                        Website
                                                    </span>
                                                @else
                                                    <span class="badge bg-soft-primary text-primary" title="Added by {{ $lead->creator?->name }}">
                                                        <i class="ri-user-line me-1"></i> {{ $lead->creator?->name }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ config('constants.lead_status_colors.' . $lead->status) }}">
                                                    {{ config('constants.lead_statuses.' . $lead->status) }}
                                                </span>
                                            </td>
                                            <td> {{ $lead->created_at?->format('d M Y') }} </td>
                                            <td> {{ $lead->created_at?->format('h:i A') }} </td>
                                            <td onclick="event.stopPropagation();">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu shadow">
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('leads.edit', $lead->id) }}">
                                                                <i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('leads.show', $lead->id) }}">
                                                                <i class="ri-eye-line align-bottom me-2 text-muted"></i> View
                                                            </a>
                                                        </li>
                                                        @if(auth()->user()->can('leads.delete') && $lead->created_by === auth()->id())
                                                        <li>
                                                            <button class="dropdown-item py-2 text-danger" type="button" wire:click="delete('{{ $lead->id }}')" wire:confirm="Are you sure?">
                                                                <i class="ri-delete-bin-line align-bottom me-2"></i> Delete
                                                            </button>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4">
                                                No leads found.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if(method_exists($leads, 'links'))
                            <div class="mt-3">
                                {{ $leads->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>