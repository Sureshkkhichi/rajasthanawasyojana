<!DOCTYPE html>
<html lang="hi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Receipt - {{ $deal->first_name }} {{ $deal->last_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 12mm 10mm 12mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            font-family: 'Hind', 'DejaVu Sans', Arial, sans-serif;
            color: #111;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 14px;
            line-height: 1.5;
        }

        .receipt-box {
            border: 1.5px solid #222;
            padding: 25px 30px;
            min-height: 250mm;
            position: relative;
            background: #fff;
        }

        .header-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .header-title h1 {
            font-size: 26px;
            font-weight: 700;
            margin: 0;
            color: #111;
            letter-spacing: 0.5px;
        }

        .header-title h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 4px 0 0 0;
            color: #333;
            text-transform: uppercase;
        }

        .meta-info {
            margin-bottom: 20px;
            font-size: 14px;
            color: #111;
        }

        .meta-line {
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        .salutation {
            margin: 20px 0 15px 0;
        }

        .salutation h4 {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 6px 0;
        }

        .salutation p {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        .details-table th,
        .details-table td {
            border: 1px solid #222;
            padding: 10px 14px;
            font-size: 14px;
            vertical-align: middle;
        }

        .terms-text {
            font-size: 13.5px;
            margin-top: 25px;
            margin-bottom: 80px;
            color: #111;
        }

        .footer-signature {
            position: absolute;
            bottom: 35px;
            right: 35px;
            text-align: right;
        }

        .footer-signature p {
            margin: 2px 0;
            font-size: 14px;
        }

        .footer-signature .org-name {
            font-size: 16px;
            font-weight: 700;
        }

        .footer-signature .sign-title {
            font-size: 14px;
            font-weight: 700;
            margin-top: 45px;
        }

        .footer-url {
            position: absolute;
            bottom: 10px;
            left: 30px;
            font-size: 11px;
            color: #555;
        }

        @media print {
            .receipt-box {
                border: 1.5px solid #222 !important;
            }
        }
    </style>
</head>

<body>

    <div class="receipt-box">
        <div class="header-title">
            <h1>Rajasthan Awas Yojana</h1>
            <h3>JAIPUR</h3>
        </div>

        <div class="meta-info">
            <div class="meta-line">{{ $receipt_date }}</div>
            <div class="meta-line">रसीद संख्या: {{ $receipt_no }}</div>
            <div class="meta-line">वर्णन: {{ $description_text }}</div>
        </div>

        <div class="salutation">
            <h4>प्रिय Mr./Mrs./Ms {{ strtoupper($deal->first_name . ' ' . $deal->last_name) }}</h4>
            <p>निम्नलिखित विवरण के विरुद्ध भुगतान के लिए धन्यवाद</p>
        </div>

        <table class="details-table">
            <tr>
                <td width="55%"><strong>सम्पत्ति का नाम:</strong> {{ $deal->project?->name ?: 'Rajasthan Awas Yojana' }}</td>
                <td width="45%"><strong>क्षेत्र:</strong> {{ $deal->flat_size ? $deal->flat_size : '-' }}</td>
            </tr>
            <tr>
                <td><strong>वास्तविक राशि:</strong> ₹ {{ number_format($deal->booking_amount ?: 21100, 0) }}</td>
                <td><strong>कर राशि:</strong> ₹ 0</td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>राशि (अंकों के):</strong> ₹ {{ number_format($deal->booking_amount ?: 21100, 0) }} For Booking Amount
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>राशि (शब्द):</strong> {{ $amount_in_words }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>के माध्यम से भुगतान:</strong> Bank Transfer {{ $transaction_id }}
                </td>
            </tr>
        </table>

        <div class="terms-text">
            I verify and acknowledge all the terms and conditions mentioned on website .
        </div>

        <div class="footer-signature">
            <p class="org-name">Rajasthan Awas Yojana</p>
            <p class="sign-title">अधिकृत हस्ताक्षरकर्ता</p>
            <p class="org-name" style="margin-top: 5px;">JAIPUR</p>
        </div>

        <div class="footer-url">
            https://rajasthanawasyojana.com/admin/admin/DealsPayments/printreceipt/{{ $print_id }}
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
