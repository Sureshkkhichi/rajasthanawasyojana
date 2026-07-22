<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Customer Lead Details</title>
    <style>
    body {
        font-family: 'hind', 'Arial', sans-serif;
        color: #212529;
        font-size: 13px;
    }

    .header {
        margin-bottom: 20px;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
    }

    .header h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    .header p {
        margin: 4px 0 0 0;
        color: #666;
        font-size: 12px;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 8px;
        color: #333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 3px;
    }

    .details-table {
        width: 100%;
    }

    .details-table td {
        vertical-align: middle;
    }

    .details-table td.label {
        font-weight: bold;
        width: 35%;
    }

    tr,
    td {
        margin: 0;
        padding: 0;
    }
    </style>
</head>

<body>
    <div class="header">
        <h2>{{ $lead->project?->name ?: 'Rajasthan Awas Yojana' }} (Lead Details)</h2>
    </div>

    <div class="section-title">Personal Information</div>
    <table class="details-table">
        <tr>
            <td class="label">First Name</td>
            <td>{{ $lead->first_name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Last Name</td>
            <td>{{ $lead->last_name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Father / Husband Name</td>
            <td>{{ $lead->father_husband_name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">PAN Number</td>
            <td>{{ $lead->pan_number ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Gender</td>
            <td>{{ $lead->gender ? ucfirst($lead->gender) : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Date of Birth</td>
            <td>{{ $lead->date_of_birth ? $lead->date_of_birth->format('d M Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Occupation</td>
            <td>{{ $lead->occupation ?: '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Contact & Flat Information</div>
    <table class="details-table">
        <tr>
            <td class="label">Project Name</td>
            <td>{{ $lead->project?->name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Mobile Number</td>
            <td>{{ $lead->phone ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Email Address</td>
            <td>{{ $lead->email ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td>{{ $lead->address ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">State / City</td>
            <td>{{ $lead->state_name ?: '-' }} / {{ $lead->city ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Selected Flat Size / Area</td>
            <td>{{ $lead->flat_size ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Co-Applicant Name</td>
            <td>{{ $lead->co_applicant_name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Waiver Code</td>
            <td>{{ $lead->waiver_code ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Transaction ID</td>
            <td>{{ $lead->transaction_id ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Enquiry Date</td>
            <td>{{ $lead->created_at ? $lead->created_at->format('d M Y h:i A') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Lead Status</td>
            <td>{{ config('constants.lead_statuses.' . $lead->status, ucfirst($lead->status)) }}</td>
        </tr>
        <tr>
            <td class="label">Payment Status</td>
            <td>{{ config('constants.payment_statuses.' . $lead->payment_status, ucfirst($lead->payment_status)) }}</td>
        </tr>
    </table>
</body>

</html>
