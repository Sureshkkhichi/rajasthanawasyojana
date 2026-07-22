<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>आवंटन पत्र</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 0mm;
        }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
            box-sizing: border-box;
        }

        html {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Hind', Arial, sans-serif;
            color: #333;
        }

        /* Background image wrapper — covers entire page including print */
        .page-wrapper {
            position: relative;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            overflow: hidden;
        }

        .bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        .bg-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: fill;
        }

        .content {
            position: relative;
            z-index: 1;
            padding: 25mm 18mm 15mm 18mm;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .title {
            font-size: 30px;
            color: #d32f2f;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .subtitle {
            font-size: 17px;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .location {
            font-size: 15px;
            margin: 0 0 12px 0;
        }

        .badge-box {
            display: inline-block;
            background-color: #d32f2f !important;
            color: #fff !important;
            font-size: 19px;
            font-weight: bold;
            padding: 5px 22px;
            border-radius: 4px;
            margin-bottom: 18px;
        }

        .meta-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .meta-table td {
            padding: 5px 5px;
            font-size: 14px;
            border: none;
        }

        .meta-label {
            font-weight: bold;
        }

        .divider {
            border-top: 1px solid #aaa;
            margin: 10px 0;
        }

        .subject {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .salutation {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .body-text {
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 12px;
            text-indent: 30px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #aaa;
            padding: 7px;
            font-size: 13px;
            text-align: center;
        }

        .data-table th {
            background-color: #f0f0f0 !important;
            font-weight: bold;
        }

        .footer-note {
            font-size: 12px;
            margin-top: 18px;
            font-weight: bold;
        }

        .computer-generated {
            font-size: 10px;
            color: #666;
            margin-top: 4px;
        }

        .footer-signatures {
            margin-top: 28px;
            width: 100%;
        }

        .footer-signatures td {
            font-size: 13px;
            vertical-align: top;
        }

        @media screen {
            body {
                background: #e0e0e0;
            }

            .page-wrapper {
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
                margin: 20px auto;
            }
        }

        @media print {
            body {
                background: none !important;
            }

            .page-wrapper {
                width: 100%;
                min-height: 100vh;
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <!-- Background image rendered as actual img tag so it always prints -->
        <div class="bg-image">
            <img src="{{ asset('back_img.png') }}" alt="" />
        </div>

        <div class="content">
            <div class="header">
                <div class="title">{{ $project->name }}</div>
                <div class="subtitle">जयपुर विकास प्राधिकरण द्वारा अनुमोदित</div>
                <div class="location">Jaipur</div>
                <div class="badge-box">आवंटन पत्र</div>
            </div>

            <table class="meta-table">
                <tr>
                    <td width="15%"><span class="meta-label">फॉर्म संख्या:</span></td>
                    <td width="35%">
                        RAJAWS-{{ $deal->created_at?->format('Y') ?: date('Y') }}-{{ substr($deal->id, 0, 8) }}</td>
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
                हमें यह उद्घोषित करते हुए प्रसन्नता हो रही है कि हमारी योजना <strong>{{ $project->name }}</strong> में
                आपका
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
                        <td><strong>{{ number_format($inventory->area_sq_yards ?: $inventory->area_sbup, 2) }}</strong>
                        </td>
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
    </div>

    <script type="text/javascript">
        window.onload = function () {
            window.print();
        }
    </script>
</body>

</html>