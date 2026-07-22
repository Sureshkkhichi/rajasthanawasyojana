<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment & Booking Confirmed</title>
</head>

<body>

    <h2>
        Dear {{ $lead->first_name }} {{ $lead->last_name }},
    </h2>

    <p>
        We are pleased to inform you that your booking payment of <strong>₹21,100.00</strong> has been successfully received and confirmed.
    </p>

    <p>
        Your application for <strong>{{ $lead->project->name ?? 'Project' }}</strong> is now processed and a deal has been generated.
    </p>

    <hr>

    <h4>Payment & Booking Details</h4>

    <p>
        <strong>Transaction ID:</strong>
        {{ $lead->transaction_id }}
    </p>

    <p>
        <strong>Amount Paid:</strong>
        ₹21,100.00
    </p>

    <p>
        <strong>Project Name:</strong>
        {{ $lead->project->name ?? '-' }}
    </p>

    <p>
        <strong>Customer Name:</strong>
        {{ $lead->first_name }} {{ $lead->last_name }}
    </p>

    <p>
        <strong>Email:</strong>
        {{ $lead->email }}
    </p>

    <p>
        <strong>Mobile:</strong>
        {{ $lead->phone }}
    </p>

    <p>
        <strong>Flat/Plot Size:</strong>
        {{ $lead->flat_size }}
    </p>

    <p>
        <strong>Booking Date:</strong>
        {{ now()->format('d M Y h:i A') }}
    </p>

    <br>

    <p>
        Our team will contact you shortly regarding the next steps and allotment process.
    </p>

    <p>
        Regards,<br>
        Rajasthan Awas Yojana Team
    </p>

</body>

</html>
