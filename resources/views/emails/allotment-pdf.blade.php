<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>आवंटन पत्र</title>
    <style>
    body {
        font-family: 'hind', 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        color: #333;
        background-color: #fff;
    }

    .container {
        border: 4px double #d32f2f;
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
        font-size: 32px;
        color: #d32f2f;
        font-weight: bold;
        margin: 0 0 5px 0;
    }

    .subtitle {
        font-size: 18px;
        font-weight: bold;
        margin: 0 0 5px 0;
    }

    .location {
        font-size: 16px;
        margin: 0 0 15px 0;
    }

    .badge-box {
        display: inline-block;
        background-color: #d32f2f;
        color: #fff;
        font-size: 20px;
        font-weight: bold;
        padding: 5px 25px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .meta-table,
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .meta-table td {
        padding: 8px 5px;
        font-size: 15px;
        border: none;
    }

    .meta-label {
        font-weight: bold;
    }

    .divider {
        border-top: 1px solid #ccc;
        margin: 15px 0;
    }

    .subject {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 15px;
    }

    .salutation {
        font-size: 15px;
        margin-bottom: 10px;
    }

    .body-text {
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #ccc;
        padding: 10px;
        font-size: 15px;
        text-align: center;
    }

    .data-table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    .footer-note {
        font-size: 13px;
        margin-top: 25px;
        font-weight: bold;
    }

    .computer-generated {
        font-size: 11px;
        color: #777;
        margin-top: 5px;
    }

    .footer-signatures {
        margin-top: 40px;
        width: 100%;
    }

    .footer-signatures td {
        font-size: 14px;
        vertical-align: top;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title">{{ $project->name }}</div>
            <div class="subtitle">जयपुर विकास प्राधिकरण द्वारा अनुमोदित</div>
            <div class="location">Jaipur</div>
            <div class="badge-box">आवंटन पत्र</div>
        </div>

        <table class="meta-table">
            <tr>
                <td width="15%"><span class="meta-label">फॉर्म संख्या:</span></td>
                <td width="35%">RAJAWS-{{ $deal->created_at?->format('Y') ?: date('Y') }}-{{ substr($deal->id, 0, 8) }}
                </td>
                <td width="15%"><span class="meta-label">दिनांक -</span></td>
                <td width="35%">
                    {{ $deal->booking_date ? \Carbon\Carbon::parse($deal->booking_date)->format('d-m-Y') : date('d-m-Y') }}
                </td>
            </tr>
            <tr>
                <td><span class="meta-label">ग्राहक</span></td>
                <td>{{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}</td>
                <td><span class="meta-label">मोबाइल नंबर</span></td>
                <td>{{ $deal->phone }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <div class="subject">
            विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !
        </div>

        <div class="salutation">महोदय / महोदया,</div>

        <div class="body-text">
            हमें यह उद्घोषित करते हुए प्रसन्नता हो रही है कि हमारी योजना <strong>{{ $project->name }}</strong> में आपका
            भूखण्ड \ फ्लैट का आवंटित किया जाना प्रस्तावित है जिसका विवरण निम्न प्रकार से है:
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ब्लॉक संख्या / भूखण्ड \ फ्लैट संख्या</th>
                    <th>क्षेत्रफल (वर्ग फीट में)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>{{ $inventory->plot_no ?: $inventory->flat_no }}</strong></td>
                    <td><strong>{{ number_format($inventory->area_sq_yards ?: $inventory->area_sbup, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer-note">
            नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।
        </div>
        <div class="computer-generated">
            * यह एक कंप्यूटर जनित पत्र है इसलिए किसी भी हस्ताक्षर की आवश्यकता नहीं है।
        </div>

        <table class="footer-signatures" width="100%">
            <tr>
                <td width="60%">
                    भवदीय<br>
                    <strong>वास्ते - {{ $project->name }}</strong>
                </td>
                <td width="40%" align="right">
                    <strong>संपर्क करें</strong><br>
                    {{ $project_contact_phone }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>