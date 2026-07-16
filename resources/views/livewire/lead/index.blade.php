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
                            <div class="row g-3 mt-1">
                                <div class="col-md-3">
                                    <label class="form-label">
                                        City
                                    </label>
                                    <select class="form-select" wire:model.live="search_city">
                                        <option value="">
                                            All Cities
                                        </option>
                                        @foreach($cities as $cityItem)
                                            @if(!empty(trim($cityItem)))
                                                <option value="{{ $cityItem }}">{{ $cityItem }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Flat Size
                                    </label>
                                    <select class="form-select" wire:model.live="search_flat_size">
                                        <option value="">
                                            All Flat Sizes
                                        </option>
                                        <option value="1 BHK">1 BHK</option>
                                        <option value="2 BHK">2 BHK</option>
                                        <option value="3 BHK">3 BHK</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Enquiry Date
                                    </label>
                                    <input type="date" class="form-control" wire:model.live="search_date">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-soft-danger w-100" wire:click="resetFilters">
                                        <i class="ri-refresh-line align-bottom me-1"></i> Reset Filters
                                    </button>
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
                                            <th> Lead Status </th>
                                            <th> Payment Status </th>
                                            <th> Enquiry Date </th>
                                            <th> Enquiry Time </th>
                                            <th width="120"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($leads as $lead)
                                        <tr>
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
                                            <td>
                                                @php
                                                    $payColors = [
                                                        'paid' => 'success',
                                                        'unpaid' => 'danger',
                                                        'failed' => 'warning',
                                                        'refunded' => 'info',
                                                        'partial' => 'warning',
                                                        'pending' => 'secondary',
                                                    ];
                                                    $col = $payColors[$lead->payment_status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $col }}">
                                                    {{ config('constants.payment_statuses.' . $lead->payment_status, ucfirst($lead->payment_status)) }}
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
                                                        @if(!is_null($lead->created_by))
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('leads.edit', $lead->id) }}">
                                                                <i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit
                                                            </a>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item py-2" href="{{ route('leads.show', $lead->id) }}">
                                                                <i class="ri-eye-line align-bottom me-2 text-muted"></i> View
                                                            </a>
                                                        </li>
                                                        @if(auth()->user()->can('leads.delete'))
                                                        <li>
                                                            <button class="dropdown-item py-2 text-danger" type="button" wire:click="delete('{{ $lead->id }}')" wire:confirm="Are you sure?">
                                                                <i class="ri-delete-bin-line align-bottom me-2"></i> Delete
                                                            </button>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item py-2" type="button" wire:click="sendMail('{{ $lead->id }}')">
                                                                <i class="ri-mail-send-line align-bottom me-2 text-muted"></i> Send Mail
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item py-2" type="button" wire:click="sendSMS('{{ $lead->id }}')">
                                                                <i class="ri-message-3-line align-bottom me-2 text-muted"></i> Send SMS
                                                            </button>
                                                        </li>
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

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('swal:alert', (event) => {
                    const data = event[0];
                    Swal.fire({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#405189'
                    });
                });
            });
        </script>
    @endpush
</div>