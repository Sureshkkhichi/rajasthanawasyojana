<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration Submitted</title>
</head>

<body>

    <h2>
        Dear {{ $lead->first_name }} {{ $lead->last_name }},
    </h2>

    <p>
        Thank you for submitting your registration form.
    </p>

    <p>
        We have successfully received your application for
        <strong>{{ $lead->project->name ?? 'Project' }}</strong>.
    </p>

    <p>
        Our team will review your details and contact you if any
        additional information is required.
    </p>

    <hr>

    <h4>Registration Details</h4>

    <p>
        <strong>Name:</strong>
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
        <strong>Flat Size:</strong>
        {{ $lead->flat_size }}
    </p>

    <p>
        <strong>Project:</strong>
        {{ $lead->project->name ?? '-' }}
    </p>

    <br>

    <p>
        Regards,<br>
        Rajasthan Awas Yojana Team
    </p>

</body>

</html>