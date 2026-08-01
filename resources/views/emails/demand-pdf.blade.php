<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Demand-{{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}-{{ str_replace(' ', '_', $project->name) }}
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Hind', Arial, sans-serif;
            color: #2c1a0e;
            background-color: #f5efe6;
        }

        .page-wrapper {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background-color: #faf6f0;
            padding: 8mm;
            box-sizing: border-box;
        }

        .document-frame {
            border: 2px solid #5c3017;
            padding: 3px;
            box-sizing: border-box;
            background-color: #faf6f0;
            min-height: 281mm;
        }

        .document-inner {
            border: 1px solid #7c4c2d;
            padding: 16px 22px;
            box-sizing: border-box;
            min-height: 279mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .top-meta-table {
            width: 100%;
            margin-bottom: 10px;
            font-size: 13.5px;
            color: #2c1a0e;
        }

        .header-section {
            text-align: center;
            margin-bottom: 12px;
        }

        .project-title {
            font-size: 34px;
            font-weight: 800;
            color: #4a1510;
            margin: 0 0 2px 0;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            line-height: 1.1;
        }

        .subtitle-text {
            font-size: 15px;
            font-weight: 600;
            color: #3d2b1f;
            margin-bottom: 12px;
        }

        .badge-title-box {
            display: inline-block;
            border: 3px double #6b3e1e;
            padding: 4px 35px;
            background-color: #f6eedf;
            margin-bottom: 12px;
        }

        .badge-title-text {
            font-size: 22px;
            font-weight: 700;
            color: #4a1510;
            letter-spacing: 1px;
        }

        .salutation-block {
            font-size: 13.5px;
            line-height: 1.55;
            color: #2c1a0e;
            margin-bottom: 12px;
        }

        .subject-block {
            font-size: 13.5px;
            font-weight: 700;
            color: #2c1a0e;
            margin-bottom: 8px;
        }

        .body-paragraph {
            font-size: 13.5px;
            line-height: 1.6;
            color: #2c1a0e;
            margin-bottom: 12px;
            text-align: justify;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            border: 1px solid #7c4c2d;
        }

        .data-table th {
            background-color: #f3e7d5;
            border: 1px solid #7c4c2d;
            padding: 6px;
            font-size: 14px;
            font-weight: 700;
            color: #4a1510;
            text-align: center;
        }

        .data-table td {
            border: 1px solid #7c4c2d;
            padding: 6px 12px;
            font-size: 13.5px;
            color: #2c1a0e;
            text-align: center;
        }

        .terms-block {
            font-size: 13px;
            line-height: 1.55;
            color: #2c1a0e;
            margin-bottom: 10px;
            text-align: justify;
        }

        .thanks-text {
            font-size: 14px;
            font-weight: 700;
            color: #2c1a0e;
            margin-bottom: 15px;
        }

        .footer-sign-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .footer-address-box {
            border: 1px solid #7c4c2d;
            padding: 6px 10px;
            text-align: center;
            font-size: 12px;
            color: #2c1a0e;
            background-color: #fdfaf5;
            line-height: 1.45;
        }

        .footer-note {
            font-size: 12px;
            font-weight: 700;
            margin-top: 8px;
            text-align: center;
            color: #4a1510;
        }

        .computer-generated {
            font-size: 10.5px;
            color: #666;
            text-align: center;
            margin-top: 4px;
        }

        @media screen {
            body {
                background: #e0e0e0;
                padding: 20px 0;
            }

            .page-wrapper {
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.25);
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
                padding: 5mm;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="document-frame">
            <div class="document-inner">
                <div>
                    <!-- Top Meta Line -->
                    <table class="top-meta-table">
                        <tr>
                            <td width="60%">
                                <strong>आवेदन पत्र संख्या :</strong> {{ 'RAJAWS-' . ($deal->created_at?->format('Y') ?: date('Y')) . '-' . substr($deal->id, 0, 8) }}
                            </td>
                            <td width="40%" align="right">
                                <strong>दिनांक :</strong> {{ $deal->booking_date ? \Carbon\Carbon::parse($deal->booking_date)->format('d/m/Y') : date('d/m/Y') }}
                            </td>
                        </tr>
                    </table>

                    <!-- Header Section -->
                    <div class="header-section">
                        <h1 class="project-title">{{ strtoupper($project->name) }}</h1>
                        <div class="subtitle-text">{!! nl2br(e($demand_subtitle ?? 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित')) !!}</div>
                        <div class="badge-title-box">
                            <span class="badge-title-text">मांग पत्र</span>
                        </div>
                    </div>

                    <!-- Salutation Block -->
                    <div class="salutation-block">
                        <div><strong>प्रति,</strong></div>
                        <div style="font-size: 14.5px;"><strong>श्री / श्रीमती {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}</strong></div>
                        <div><strong>पता :</strong> {{ $deal->address ?: '-' }}, {{ $deal->city ?: 'जयपुर' }}, {{ $deal->state?->name ?: 'राजस्थान' }} - {{ $deal->pincode ?: '302021' }}</div>
                        <div><strong>मोबाईल :</strong> {{ $deal->phone }}</div>
                    </div>

                    <!-- Subject -->
                    <div class="subject-block">
                        {!! nl2br(e($demand_subject ?? 'विषय: भूखण्ड संख्या ' . ($inventory->plot_no ?: $inventory->flat_no) . ' की बकाया राशि जमा कराने बाबत।')) !!}
                    </div>

                    <div class="salutation-block" style="margin-bottom: 6px;">
                        <strong>महोदय / महोदया,</strong>
                    </div>

                    <!-- Body Paragraph -->
                    <div class="body-paragraph">
                        {!! nl2br(e($demand_body ?? "{$project->name} में आवेदन पत्र संख्या RAJAWS-" . ($deal->created_at?->format('Y') ?: date('Y')) . '-' . substr($deal->id, 0, 8) . " के द्वारा आपने भूखण्ड आवंटन किये जाने हेतु बुकिंग कराई थी, आपको आवंटित भूखण्ड एवं उसके विक्रय प्रतिफल के पेटे जमा कराई जाने वाली राशि का विवरण निम्न प्रकार है:-")) !!}
                    </div>

                    <!-- Data Table -->
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

                    <!-- Terms & Instructions -->
                    <div class="terms-block">
                        {!! nl2br(e($demand_footer_para ?? "अतः आपसे अनुरोध है कि इस मांग पत्र के जारी होने की दिनांक से उक्तानुसार राशि जमा करावे अथवा लोन के लिए बैंक एवं फर्म द्वारा मांगे गए दस्तावेज, {$project->address} स्थित कार्यालय में स्वयं उपस्थित होकर जमा करावे। यदि किसी भी कारण से आप द्वारा उक्त राशि निर्धारित समयावधि में जमा नहीं कराई गयी तो बकाया राशि पर 18 प्रतिशत वार्षिक ब्याज की दर से ब्याज जमा कराना होगा。\n\nराशि के चेक / आरटीजीएस / एनईएफटी / आईएमपीएस / ऑनलाइन {$project->name} के नाम से देय होंगे।")) !!}
                    </div>

                    <div style="font-size: 13.5px; font-weight: 700; color: #2c1a0e; margin-bottom: 10px;">
                        संपर्क करें: {{ $project_contact_phone }}
                    </div>

                    <div class="thanks-text">
                        धन्यवाद !
                    </div>

                    <!-- Sign-off Block -->
                    <table class="footer-sign-table">
                        <tr>
                            <td width="60%"></td>
                            <td width="40%" align="center" style="font-size: 13.5px; color: #2c1a0e; vertical-align: top;">
                                <strong>भवदीय,</strong>
                                <div style="height: 40px;"></div>
                                <strong>( अधिकृत हस्ताक्षर )</strong><br>
                                <strong>{{ strtoupper($project->name) }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Bottom Registered Office Box -->
                <div>
                    <div class="footer-address-box">
                        <div><strong>पंजीकृत कार्यालय :</strong> {{ $project->address ?: '12/456, विनायक पथ, मानसरोवर, जयपुर - 302020 (राज.)' }}</div>
                        <div><strong>मोबाईल :</strong> {{ $project_contact_phone }} &nbsp;|&nbsp; <strong>ईमेल :</strong> info@rajasthanawas.in &nbsp;|&nbsp; <strong>वेबसाइट :</strong> www.rajasthanawas.in</div>
                    </div>

                    <div class="footer-note">
                        {!! nl2br(e($demand_footer_note ?? 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।')) !!}
                    </div>
                    <div class="computer-generated">
                        * यह एक कंप्यूटर जनित पत्र है इसलिए किसी भी हस्ताक्षर की आवश्यकता नहीं है।
                    </div>
                </div>
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