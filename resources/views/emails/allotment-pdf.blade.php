<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Allotment-{{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}-{{ str_replace(' ', '_', $project->name) }}
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

        html, body {
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

        .body-paragraph {
            font-size: 13.5px;
            line-height: 1.6;
            color: #2c1a0e;
            margin-bottom: 12px;
            text-align: justify;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            border: 1px solid #7c4c2d;
        }

        .details-table th {
            background-color: #f3e7d5;
            border: 1px solid #7c4c2d;
            padding: 6px;
            font-size: 15px;
            font-weight: 700;
            color: #4a1510;
            text-align: center;
        }

        .details-table td {
            border: 1px solid #7c4c2d;
            padding: 5px 12px;
            font-size: 13.5px;
            color: #2c1a0e;
        }

        .label-col {
            width: 38%;
            font-weight: 600;
            background-color: #fdfaf5;
        }

        .value-col {
            width: 62%;
            font-weight: 600;
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
                                <strong>पंजीकरण क्रमांक :</strong> {{ $form_no }}
                            </td>
                            <td width="40%" align="right">
                                <strong>दिनांक :</strong> {{ $allotted_date }}
                            </td>
                        </tr>
                    </table>

                    <!-- Header -->
                    <div class="header-section">
                        <h1 class="project-title">{{ strtoupper($project->name) }}</h1>
                        <div class="subtitle-text">{!! nl2br(e($allotment_subtitle)) !!}</div>
                        <div class="badge-title-box">
                            <span class="badge-title-text">{!! e($allotment_subject) !!}</span>
                        </div>
                    </div>

                    <!-- Salutation Block -->
                    <div class="salutation-block">
                        <div><strong>प्रति,</strong></div>
                        <div style="font-size: 14.5px;"><strong>श्री / श्रीमती {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}</strong></div>
                        <div><strong>पता :</strong> {{ $deal->address ?: '-' }}, {{ $deal->city ?: 'जयपुर' }}, {{ $deal->state?->name ?: 'राजस्थान' }} - {{ $deal->pincode ?: '302021' }}</div>
                        <div><strong>मोबाईल :</strong> {{ $deal->phone }}</div>
                    </div>

                    <!-- Body Paragraph -->
                    <div class="body-paragraph">
                        {!! nl2br(e($allotment_body)) !!}
                    </div>

                    <!-- Details Table -->
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th colspan="2">आवंटन विवरण</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label-col">पंजीकरण संख्या</td>
                                <td class="value-col">{{ $form_no }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">आवेदक का नाम</td>
                                <td class="value-col">श्री {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">परियोजना का नाम</td>
                                <td class="value-col">{{ strtoupper($project->name) }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">टावर / ब्लॉक</td>
                                <td class="value-col">{{ $block_tower }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">मंजिल</td>
                                <td class="value-col">{{ $floor_str }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">फ्लैट / यूनिट नंबर</td>
                                <td class="value-col">{{ $unit_no }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">प्रकार</td>
                                <td class="value-col">{{ $unit_type }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">कारपेट एरिया</td>
                                <td class="value-col">{{ $carpet_area }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">आवंटन दिनांक</td>
                                <td class="value-col">{{ $allotted_date }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Terms & Notes -->
                    <div class="terms-block">
                        {!! nl2br(e($allotment_footer_note)) !!}
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
                <div class="footer-address-box">
                    <div><strong>पंजीकृत कार्यालय :</strong> {{ $project->address ?: '12/456, विनायक पथ, मानसरोवर, जयपुर - 302020 (राज.)' }}</div>
                    <div><strong>मोबाईल :</strong> {{ $project_contact_phone }} &nbsp;|&nbsp; <strong>ईमेल :</strong> info@rajasthanawas.in &nbsp;|&nbsp; <strong>वेबसाइट :</strong> www.rajasthanawas.in</div>
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