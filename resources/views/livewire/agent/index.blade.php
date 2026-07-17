<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Agents</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Agents</a></li>
                               <li class="breadcrumb-item active">List</li>
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
                            <h4 class="card-title mb-0">Search Filter</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Search by Name" wire:model.live.debounce.500ms="search_name">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Waiver Code</label>
                                    <input type="text" class="form-control" placeholder="Search by Waiver Code" wire:model.live.debounce.500ms="search_code">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" wire:model.live="status">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Agent List --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Agent List</h4>
                            <a href="{{ route('agents.create') }}" class="btn btn-primary btn-sm">
                                <i class="ri-add-line align-bottom me-1"></i> Add New Agent
                            </a>
                        </div>
                        <div class="card-body">
                            <div wire:loading>
                                <div class="alert alert-info mb-3">Loading...</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="70">SR. No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Waiver Code</th>
                                            <th>Commission Type</th>
                                            <th>Commission Value</th>
                                            <th width="100">Status</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($agents as $agent)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-semibold">{{ $agent->name }}</td>
                                                <td>{{ $agent->email ?: '-' }}</td>
                                                <td>{{ $agent->phone ?: '-' }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                                        <span class="badge bg-light text-primary border border-primary fs-13">
                                                            {{ $agent->code }}
                                                        </span>
                                                        <button class="btn btn-link p-0 text-muted fs-15 lh-1" type="button" 
                                                            onclick="copyToClipboard('{{ $agent->code }}', this)" 
                                                            title="Copy Waiver Code">
                                                            <i class="ri-file-copy-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info text-uppercase">
                                                        {{ $agent->commission_type }}
                                                    </span>
                                                </td>
                                                <td class="fw-bold">
                                                    @if($agent->commission_type === 'percentage')
                                                        {{ number_format($agent->commission_value, 2) }}%
                                                    @else
                                                        ₹{{ number_format($agent->commission_value, 2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch form-switch-md">
                                                        <input class="form-check-input" type="checkbox" role="switch" 
                                                            id="switch-{{ $agent->id }}" 
                                                            {{ $agent->status === 'active' ? 'checked' : '' }} 
                                                            wire:click="toggleStatus('{{ $agent->id }}')">
                                                    </div>
                                                </td>
                                                <td onclick="event.stopPropagation();">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu shadow">
                                                            <li>
                                                                <a class="dropdown-item py-2" href="{{ route('agents.edit', $agent->id) }}">
                                                                    <i class="ri-edit-line align-bottom me-2 text-muted"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button class="dropdown-item py-2 text-danger" type="button" 
                                                                    wire:click="delete('{{ $agent->id }}')" 
                                                                    wire:confirm="Are you sure you want to delete this agent?">
                                                                    <i class="ri-delete-bin-line align-bottom me-2"></i> Delete
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4">No agents found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $agents->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function copyToClipboard(text, buttonElement) {
                navigator.clipboard.writeText(text).then(() => {
                    const icon = buttonElement.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'ri-check-line text-success';
                    buttonElement.setAttribute('title', 'Copied!');
                    
                    setTimeout(() => {
                        icon.className = originalClass;
                        buttonElement.setAttribute('title', 'Copy Waiver Code');
                    }, 1500);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            }
        </script>
    @endpush
</div>
