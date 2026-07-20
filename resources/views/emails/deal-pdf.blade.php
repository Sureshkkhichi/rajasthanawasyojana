<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Customer Details</title>
    <style>
        body {
            font-family: 'hind', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
        }
        .container {
            border: 4px double #405189;
            padding: 30px;
            margin: 10px;
            position: relative;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .title {
            font-size: 28px;
            color: #405189;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .subtitle {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px 0;
            color: #666;
        }
        .badge-box {
            display: inline-block;
            background-color: #405189;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 5px 25px;
            border-radius: 4px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #405189;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #e9ecef;
            text-align: left;
        }
        .details-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
            width: 30%;
        }
        .details-table td {
            color: #212529;
        }
        .computer-generated {
            font-size: 11px;
            color: #777;
            margin-top: 30px;
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="title">{{ $deal->project?->name ?: 'Rajasthan Awas Yojana' }}</div>
            <div class="subtitle">Application Form Details</div>
            <div class="badge-box">Customer Details</div>
        </div>

        <div class="section-title">Personal Details</div>
        <table class="details-table">
            <tr>
                <th>First Name</th>
                <td>{{ $deal->first_name }}</td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>{{ $deal->last_name }}</td>
            </tr>
            <tr>
                <th>Father / Husband Name</th>
                <td>{{ $deal->father_husband_name ?: '-' }}</td>
            </tr>
            <tr>
                <th>PAN Number</th>
                <td>{{ $deal->pan_number }}</td>
            </tr>
            <tr>
                <th>Gender</th>
                <td>{{ ucfirst($deal->gender) }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>{{ $deal->date_of_birth ? $deal->date_of_birth->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <th>Occupation</th>
                <td>{{ $deal->occupation }}</td>
            </tr>
        </table>

        <div class="section-title">Contact & Booking Details</div>
        <table class="details-table">
            <tr>
                <th>Project Name</th>
                <td><strong>{{ $deal->project?->name ?: '-' }}</strong></td>
            </tr>
            <tr>
                <th>Mobile Number</th>
                <td>{{ $deal->phone }}</td>
            </tr>
            <tr>
                <th>Email Address</th>
                <td>{{ $deal->email }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $deal->address }}</td>
            </tr>
            <tr>
                <th>State / City</th>
                <td>{{ $deal->state_name }} / {{ $deal->city }}</td>
            </tr>
            <tr>
                <th>Selected Flat Size / Area</th>
                <td>{{ $deal->flat_size }}</td>
            </tr>
            <tr>
                <th>Co-Applicant Name</th>
                <td>{{ $deal->co_applicant_name ?: '-' }}</td>
            </tr>
            <tr>
                <th>Waiver Code</th>
                <td>{{ $deal->waiver_code ?: '-' }}</td>
            </tr>
            @if($deal->booking_date)
                <tr>
                    <th>Booking Date</th>
                    <td>{{ $deal->booking_date->format('d M Y h:i A') }}</td>
                </tr>
            @endif
            <tr>
                <th>Booking Amount</th>
                <td>₹ {{ number_format($deal->booking_amount, 2) }}</td>
            </tr>
        </table>

        <div class="computer-generated">
            * This is a computer generated document.
        </div>
    </div>
</body>
</html>
