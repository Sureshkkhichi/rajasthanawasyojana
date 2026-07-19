<!DOCTYPE html>
<html lang="hi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>ग्राहक विवरण (Deal Details)</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            <div class="title">{{ $deal->project?->name ?: 'मुख्यमंत्री जन आवास योजना' }}</div>
            <div class="subtitle">आवेदन फॉर्म विवरण (Application Form Details)</div>
            <div class="badge-box">ग्राहक विवरण पत्र (Customer Details)</div>
        </div>

        <div class="section-title">व्यक्तिगत विवरण (Personal Details)</div>
        <table class="details-table">
            <tr>
                <th>प्रथम नाम (First Name)</th>
                <td>{{ $deal->first_name }}</td>
            </tr>
            <tr>
                <th>अंतिम नाम (Last Name)</th>
                <td>{{ $deal->last_name }}</td>
            </tr>
            <tr>
                <th>पिता / पति का नाम (Father / Husband Name)</th>
                <td>{{ $deal->father_husband_name ?: '-' }}</td>
            </tr>
            <tr>
                <th>पैन नंबर (PAN Number)</th>
                <td>{{ $deal->pan_number }}</td>
            </tr>
            <tr>
                <th>लिंग (Gender)</th>
                <td>{{ ucfirst($deal->gender) }}</td>
            </tr>
            <tr>
                <th>जन्म तिथि (Date of Birth)</th>
                <td>{{ $deal->date_of_birth ? $deal->date_of_birth->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <th>व्यवसाय (Occupation)</th>
                <td>{{ $deal->occupation }}</td>
            </tr>
        </table>

        <div class="section-title">संपर्क एवं बुकिंग विवरण (Contact & Booking Details)</div>
        <table class="details-table">
            <tr>
                <th>योजना का नाम (Project Name)</th>
                <td><strong>{{ $deal->project?->name ?: '-' }}</strong></td>
            </tr>
            <tr>
                <th>मोबाइल नंबर (Mobile Number)</th>
                <td>{{ $deal->phone }}</td>
            </tr>
            <tr>
                <th>ईमेल पता (Email Address)</th>
                <td>{{ $deal->email }}</td>
            </tr>
            <tr>
                <th>पता (Address)</th>
                <td>{{ $deal->address }}</td>
            </tr>
            <tr>
                <th>राज्य / शहर (State / City)</th>
                <td>{{ $deal->state_name }} / {{ $deal->city }}</td>
            </tr>
            <tr>
                <th>चयनित आकार (Selected Flat Size / Area)</th>
                <td>{{ $deal->flat_size }}</td>
            </tr>
            <tr>
                <th>सह-आवेदक (Co-Applicant Name)</th>
                <td>{{ $deal->co_applicant_name ?: '-' }}</td>
            </tr>
            <tr>
                <th>वेवर कोड (Waiver Code)</th>
                <td>{{ $deal->waiver_code ?: '-' }}</td>
            </tr>
            @if($deal->booking_date)
                <tr>
                    <th>बुकिंग तिथि (Booking Date)</th>
                    <td>{{ $deal->booking_date->format('d M Y h:i A') }}</td>
                </tr>
            @endif
            <tr>
                <th>बुकिंग राशि (Booking Amount)</th>
                <td>₹ {{ number_format($deal->booking_amount, 2) }}</td>
            </tr>
        </table>

        <div class="computer-generated">
            * यह एक कंप्यूटर जनित विवरण पत्र है।
        </div>
    </div>
</body>
</html>
