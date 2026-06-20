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
                                <div class="col-md-4">
                                    <label class="form-label">
                                        Keyword
                                    </label>
                                    <input type="text" class="form-control" placeholder="Name / Mobile / Email / PAN"
                                        wire:model.live.debounce.500ms="keyword">
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
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
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Lead List
                            </h4>
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
                                            <th width="70"> # </th>
                                            <th> Applicant </th>
                                            <th> Contact </th>
                                            <th> Project </th>
                                            <th> Location </th>
                                            <th> Flat Size </th>
                                            <th> Lead Status </th>
                                            <th> Created </th>
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
                                                    <span
                                                        class="badge bg-{{ config('constants.lead_status_colors.' . $lead->status) }}">
                                                        {{ config('constants.lead_statuses.' . $lead->status) }}
                                                    </span>
                                                </td>
                                                <td> {{ $lead->created_at?->format('d M Y h:i A') }} </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('leads.edit', $lead->id) }}"
                                                            class="btn btn-sm btn-soft-success" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-original-title="Edit Lead"><i
                                                                class="ri-pencil-line"></i></a>
                                                        <a href="{{ route('leads.show', $lead->id) }}"
                                                            class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-original-title="View Lead">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                        {{-- <button type="button" class="btn btn-sm btn-soft-danger"
                                                            wire:click="delete('{{ $lead->id }}')"
                                                            wire:confirm="Are you sure?" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-original-title="Delete Lead">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
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