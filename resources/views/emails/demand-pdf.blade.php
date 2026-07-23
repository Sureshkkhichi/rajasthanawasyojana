@php
    $bgImagePath = public_path('back_img.png');
    $bgImageData = file_exists($bgImagePath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($bgImagePath)) : asset('back_img.png');
@endphp
<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>मांग पत्र</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Hind';
            font-style: normal;
            font-weight: 400;
            src: url("{{ storage_path('fonts/Hind-Regular.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'Hind';
            font-style: normal;
            font-weight: 700;
            src: url("{{ storage_path('fonts/Hind-Bold.ttf') }}") format('truetype');
        }

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

        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Hind', Arial, sans-serif;
            color: #333;
        }

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
            padding: 22mm 18mm 12mm 18mm;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 10px;
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
            margin: 0 0 3px 0;
        }

        .location {
            font-size: 14px;
            margin: 0 0 10px 0;
        }

        .badge-box {
            display: inline-block;
            background-color: #d32f2f !important;
            color: #fff !important;
            font-size: 19px;
            font-weight: bold;
            padding: 5px 22px;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        /* Customer block */
        .customer-block {
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        /* Subject line */
        .subject {
            font-size: 13px;
            margin-bottom: 8px;
        }

        /* Salutation & body */
        .salutation {
            font-size: 14px;
            margin-bottom: 6px;
        }

        .body-text {
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 12px;
            text-indent: 30px;
        }

        /* Main data table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .data-table th {
            background-color: #f0f0f0 !important;
            font-weight: bold;
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: center;
        }

        .data-table td {
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: center;
            vertical-align: middle;
        }

        /* Financial summary table */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .summary-table th {
            background-color: #f0f0f0 !important;
            font-weight: bold;
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: center;
        }

        .summary-table td {
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: center;
        }

        /* Footer paragraph */
        .footer-para {
            font-size: 12px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .contact-block {
            font-size: 13px;
            margin-bottom: 10px;
        }

        .thanks-block {
            font-size: 14px;
            margin-bottom: 6px;
        }

        .project-name-sign {
            font-size: 14px;
            font-weight: bold;
        }

        .footer-note {
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
        }

        .computer-generated {
            font-size: 10px;
            color: #666;
            text-align: center;
            margin-top: 4px;
        }

        @media screen {
            body { background: #e0e0e0; }
            .page-wrapper {
                box-shadow: 0 0 20px rgba(0,0,0,0.3);
                margin: 20px auto;
            }
        }

        @media print {
            body { background: none !important; }
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
        <!-- Background as actual img tag so it always prints -->
        <div class="bg-image">
            <img src="{{ $bgImageData }}" alt="" />
        </div>

        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="title">{{ $project->name }}</div>
                <div class="subtitle">जयपुर विकास प्राधिकरण द्वारा अनुमोदित</div>
                <div class="location">{{ $project->address ?? 'Jaipur' }}</div>
                <div class="badge-box">मांग पत्र</div>
            </div>

            <!-- Customer details -->
            <div class="customer-block">
                {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}<br>
                {{ $deal->address ?? '' }}<br>
                {{ $deal->phone }}
            </div>

            <!-- Subject -->
            <div class="subject">
                <strong>विषय:</strong> भूखण्ड संख्या <strong>{{ $inventory->plot_no ?: $inventory->flat_no }}</strong> की बकाया राशि जमा कराने बाबत।
            </div>

            <!-- Salutation -->
            <div class="salutation">महोदय / महोदया,</div>

            <!-- Body -->
            <div class="body-text">
                <strong>{{ $project->name }}</strong> में आवेदन पत्र संख्या
                <strong>RAJAWS-{{ $deal->created_at?->format('Y') ?: date('Y') }}-{{ substr($deal->id, 0, 8) }}</strong>
                के द्वारा आपने भूखण्ड आवंटन किये जाने हेतु बुकिंग कराई थी, आपको आवंटित भूखण्ड एवं उसके विक्रय प्रतिफल के पेटे जमा कराई जाने वाली राशि का विवरण निम्न प्रकार है:-
            </div>

            <!-- Plot / Unit details + financial table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ब्लॉक संख्या / भूखण्ड संख्या / फ्लैट संख्या</th>
                        <th>क्षेत्रफल (वर्ग फीट में)</th>
                        <th>कुल मूल्य (₹)</th>
                        <th>बुकिंग राशि जमा (₹)</th>
                        <th>बकाया राशि (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ $inventory->plot_no ?: $inventory->flat_no }}</strong></td>
                        <td><strong>{{ number_format($inventory->area_sq_yards ?: $inventory->area_sbup, 2) }}</strong></td>
                        <td>₹ {{ number_format($totalAmount, 2) }}</td>
                        <td>₹ {{ number_format($bookingAmount, 2) }}</td>
                        <td style="color: #c0392b; font-weight: bold;">₹ {{ number_format($balanceDue, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Footer instruction paragraph -->
            <div class="footer-para">
                अतः आपसे अनुरोध है कि इस मांग पत्र के जारी होने की दिनांक से उक्तानुसार राशि जमा करावे अथवा लोन के लिए बैंक एवं फर्म द्वारा मांगे गए दस्तावेज, <strong>{{ $project->address ?? '' }}</strong> स्थित कार्यालय में स्वयं उपस्थित होकर जमा करावे। यदि किसी भी कारण से आप द्वारा उक्त राशि निर्धारित समयावधि में जमा नहीं कराई गयी तो बकाया राशि पर 18 प्रतिशत वार्षिक ब्याज की दर से ब्याज जमा कराना होगा।<br><br>
                राशि के चेक / आरटीजीएस / एनईएफटी / आईएमपीएस / ऑनलाइन <strong>{{ $project->name }}</strong> के नाम से देय होंगे।
            </div>

            <!-- Contact -->
            <div class="contact-block">
                <strong>संपर्क करें: {{ $project_contact_phone }}</strong>
            </div>

            <!-- Signature -->
            <div class="thanks-block">
                धन्यवाद,<br><br>
                <span class="project-name-sign">{{ $project->name }}</span>
            </div>

            <!-- Notes -->
            <div class="footer-note">
                नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।
            </div>
            <div class="computer-generated">
                * यह एक कंप्यूटर जनित पत्र है इसलिए किसी भी हस्ताक्षर की आवश्यकता नहीं है।
            </div>
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function () {
            window.print();
        }
    </script>
</body>

</html>
