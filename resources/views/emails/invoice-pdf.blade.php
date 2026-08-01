<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Invoice-{{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}-{{ str_replace(' ', '_', $company_name) }}
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
            margin-bottom: 14px;
        }

        .project-title {
            font-size: 32px;
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
            margin-bottom: 10px;
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

        /* 2-Column Info Box (Company & Customer) */
        .info-box-table {
            width: 100%;
            border: 1px solid #7c4c2d;
            background-color: #fdfaf5;
            margin-bottom: 14px;
            border-collapse: collapse;
        }

        .info-box-table td {
            padding: 12px 14px;
            vertical-align: top;
            font-size: 13.5px;
            line-height: 1.6;
            color: #2c1a0e;
        }

        .info-box-title {
            font-size: 14px;
            font-weight: 700;
            color: #4a1510;
            border-bottom: 1.5px solid #7c4c2d;
            padding-bottom: 4px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Invoice Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            border: 1px solid #7c4c2d;
        }

        .data-table th {
            background-color: #f3e7d5;
            border: 1px solid #7c4c2d;
            padding: 7px 10px;
            font-size: 14px;
            font-weight: 700;
            color: #4a1510;
            text-align: center;
        }

        .data-table td {
            border: 1px solid #7c4c2d;
            padding: 8px 12px;
            font-size: 13.5px;
            color: #2c1a0e;
        }

        /* Summary Total Box */
        .summary-box {
            width: 100%;
            border: 1px solid #7c4c2d;
            background-color: #fdfaf5;
            padding: 10px 14px;
            margin-bottom: 14px;
            font-size: 13.5px;
        }

        .terms-text {
            font-size: 12.5px;
            color: #2c1a0e;
            margin-bottom: 12px;
            font-style: italic;
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
                                <strong>रसीद संख्या (Invoice No):</strong> {{ $receipt_no }}
                            </td>
                            <td width="40%" align="right">
                                <strong>दिनांक (Date):</strong> {{ $receipt_date }}
                            </td>
                        </tr>
                    </table>

                    <!-- Header Section -->
                    <div class="header-section">
                        <h1 class="project-title">{{ strtoupper($company_name) }}</h1>
                        <div class="subtitle-text">{{ strtoupper($company_city) }}</div>
                        <div class="badge-title-box">
                            <span class="badge-title-text">भुगतान रसीद / INVOICE</span>
                        </div>
                    </div>

                    <!-- Company & Customer Details (2-Column Box) -->
                    <table class="info-box-table">
                        <tr>
                            <!-- Left: Company Details -->
                            <td width="48%">
                                <div class="info-box-title">कंपनी का विवरण (Company)</div>
                                <div><strong>संस्था का नाम:</strong> {{ $company_name }}</div>
                                <div><strong>शहर:</strong> {{ $company_city }}</div>
                                <div><strong>हेल्पलाइन नंबर:</strong> {{ $project_contact_phone }}</div>
                            </td>
                            <!-- Divider -->
                            <td width="4%" style="border-left: 1px solid #7c4c2d; padding: 0;"></td>
                            <!-- Right: Customer Details -->
                            <td width="48%">
                                <div class="info-box-title">ग्राहक का विवरण (Invoice To)</div>
                                <div><strong>ग्राहक का नाम:</strong> {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}</div>
                                <div><strong>मोबाईल नंबर:</strong> {{ $deal->phone }}</div>
                                <div><strong>शहर:</strong> {{ $customer_city }}</div>
                                <div><strong>पंजीकृत परियोजना:</strong> {{ $customer_project }}</div>
                                <div><strong>वेवर कोड (Waiver Code):</strong> {{ $waiver_code }}</div>
                            </td>
                        </tr>
                    </table>

                    <!-- Invoice Data Table -->
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th width="45%">विवरण (Description)</th>
                                <th width="15%">यूनिट प्रकार</th>
                                <th width="20%">ट्रांजैक्शन आईडी</th>
                                <th width="20%" align="right">जमा राशि (Amount)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>आवेदन सह बुकिंग पंजीकरण शुल्क</strong><br>
                                    <span style="font-size: 12px; color: #555;">प्रोजेक्ट: {{ $customer_project }} (Waiver Code: {{ $waiver_code }})</span>
                                </td>
                                <td align="center">{{ $unit_type }}</td>
                                <td align="center"><code>{{ $transaction_id }}</code></td>
                                <td align="right" style="font-weight: 700; color: #4a1510;">
                                    ₹ {{ number_format($amount_paid, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Financial Summary Box -->
                    <table class="summary-box">
                        <tr>
                            <td width="70%">
                                <strong>राशि (शब्दों में):</strong> {{ $amount_in_words }}
                            </td>
                            <td width="30%" align="right" style="font-size: 15px; font-weight: 800; color: #4a1510;">
                                कुल भुगतान: ₹ {{ number_format($amount_paid, 2) }}
                            </td>
                        </tr>
                    </table>

                    <!-- Terms & Verification -->
                    <div class="terms-text">
                        I verify and acknowledge all the terms and conditions mentioned on website.
                    </div>

                    <div class="thanks-text">
                        धन्यवाद !
                    </div>

                    <!-- Sign-off & Digital Seal Block -->
                    <table class="footer-sign-table">
                        <tr>
                            <td width="60%" style="vertical-align: top;">
                                @if(file_exists(public_path('rera.png')))
                                    <img src="{{ asset('rera.png') }}" style="max-height: 85px; width: auto; display: block;" alt="RERA Seal">
                                @endif
                            </td>
                            <td width="40%" align="center" style="font-size: 13.5px; color: #2c1a0e; vertical-align: top;">
                                <strong>{{ strtoupper($company_name) }}</strong>
                                <div style="height: 35px;"></div>
                                <strong>(डिजिटल हस्ताक्षर / डिजिटल सील)</strong><br>
                                <span style="font-size: 12px; color: #555;">{{ strtoupper($company_city) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Bottom Registered Office Box -->
                <div>
                    <div class="footer-address-box">
                        <div><strong>पंजीकृत कार्यालय :</strong> {{ $deal->project?->address ?: '12/456, विनायक पथ, मानसरोवर, जयपुर - 302020 (राज.)' }}</div>
                        <div><strong>मोबाईल / हेल्पलाईन :</strong> {{ $project_contact_phone }} &nbsp;|&nbsp; <strong>ईमेल :</strong> info@rajasthanawas.in &nbsp;|&nbsp; <strong>वेबसाइट :</strong> www.rajasthanawas.in</div>
                    </div>

                    <div class="computer-generated">
                        * यह एक कंप्यूटर जनित रसीद है इसलिए किसी भी हस्ताक्षर की आवश्यकता नहीं है।
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
