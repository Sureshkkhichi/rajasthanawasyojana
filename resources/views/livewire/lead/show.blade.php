<div>
    <div class="page-content">
        <div class="container-fluid">
            {{-- Page Header --}}
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">
                            Lead Details
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('leads.index') }}">
                                        Leads
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">
                                    View
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- Personal Information --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Personal Information
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="220">First Name</th>
                                    <td>{{ $lead->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td>{{ $lead->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Father / Husband Name</th>
                                    <td>{{ $lead->father_husband_name ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>PAN Number</th>
                                    <td>{{ $lead->pan_number }}</td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td>{{ ucfirst($lead->gender) }}</td>
                                </tr>
                                <tr>
                                    <th>Date Of Birth</th>
                                    <td>
                                        {{ $lead->date_of_birth ? \Carbon\Carbon::parse($lead->date_of_birth)->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td>{{ $lead->occupation }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Contact Information --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Contact Information
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="220">Mobile Number</th>
                                    <td>{{ $lead->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Email Address</th>
                                    <td>{{ $lead->email }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $lead->address }}</td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td>{{ $lead->state?->name }}</td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td>{{ $lead->city }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Flat Information --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Flat Information
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="220">Flat Size</th>
                                    <td>{{ $lead->flat_size }}</td>
                                </tr>
                                <tr>
                                    <th>Co Applicant</th>
                                    <td>{{ $lead->co_applicant_name ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Waiver Code</th>
                                    <td>{{ $lead->waiver_code ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Tracking Information --}}
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Tracking Information
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th width="220">Project</th>
                                    <td>{{ $lead->project?->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($lead->is_submitted)
                                            <span class="badge bg-success">
                                                Submitted
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>IP Address</th>
                                    <td>{{ $lead->ip_address }}</td>
                                </tr>
                                <tr>
                                    <th>User Agent</th>
                                    <td style="word-break: break-word;">
                                        {{ $lead->user_agent }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>
                                        {{ $lead->created_at?->format('d M Y h:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>
                                        {{ $lead->updated_at?->format('d M Y h:i A') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Actions --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex gap-2">
                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-primary">
                                <i class="ri-pencil-line me-1"></i>
                                Edit Lead
                            </a>
                            <a href="{{ route('leads.index') }}" class="btn btn-light">
                                Back To List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>