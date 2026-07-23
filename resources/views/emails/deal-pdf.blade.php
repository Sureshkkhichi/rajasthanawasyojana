<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Customer Deal Details</title>
    <style>
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
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
        <h2>{{ $deal->project?->name ?: 'Rajasthan Awas Yojana' }}</h2>
    </div>

    <div class="section-title">Personal Information</div>
    <table class="details-table">
        <tr>
            <td class="label">First Name</td>
            <td>{{ $deal->first_name }}</td>
        </tr>
        <tr>
            <td class="label">Last Name</td>
            <td>{{ $deal->last_name }}</td>
        </tr>
        <tr>
            <td class="label">Father / Husband Name</td>
            <td>{{ $deal->father_husband_name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">PAN Number</td>
            <td>{{ $deal->pan_number }}</td>
        </tr>
        <tr>
            <td class="label">Gender</td>
            <td>{{ ucfirst($deal->gender) }}</td>
        </tr>
        <tr>
            <td class="label">Date of Birth</td>
            <td>{{ $deal->date_of_birth ? $deal->date_of_birth->format('d M Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="label">Occupation</td>
            <td>{{ $deal->occupation }}</td>
        </tr>
    </table>

    <div class="section-title">Contact & Booking Information</div>
    <table class="details-table">
        <tr>
            <td class="label">Project Name</td>
            <td>{{ $deal->project?->name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Mobile Number</td>
            <td>{{ $deal->phone }}</td>
        </tr>
        <tr>
            <td class="label">Email Address</td>
            <td>{{ $deal->email }}</td>
        </tr>
        <tr>
            <td class="label">Address</td>
            <td>{{ $deal->address }}</td>
        </tr>
        <tr>
            <td class="label">State / City</td>
            <td>{{ $deal->state_name }} / {{ $deal->city }}</td>
        </tr>
        <tr>
            <td class="label">Selected Flat Size / Area</td>
            <td>{{ $deal->flat_size }}</td>
        </tr>
        <tr>
            <td class="label">Co-Applicant Name</td>
            <td>{{ $deal->co_applicant_name ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Waiver Code</td>
            <td>{{ $deal->waiver_code ?: '-' }}</td>
        </tr>
        @if($deal->booking_date)
        <tr>
            <td class="label">Booking Date</td>
            <td>{{ $deal->booking_date->format('d M Y h:i A') }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Booking Amount</td>
            <td>₹ {{ number_format($deal->booking_amount, 2) }}</td>
        </tr>
    </table>
</body>

</html>