<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\FrontendSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

use App\Services\ActivityLogger;

class DealDocumentController extends Controller
{
    public function allotmentLetter(Deal $deal)
    {
        abort_unless(auth()->user()->can('leads.view'), 403);

        $deal->load(['project', 'allottedInventory']);
        $inventory = $deal->allottedInventory;

        if (!$inventory) {
            abort(404, 'No allotted unit found for this deal.');
        }

        ActivityLogger::logDeal($deal, 'allotment_pdf_downloaded', 'Allotment Letter Downloaded', "Downloaded Allotment Letter PDF for {$deal->first_name} {$deal->last_name}");

        $project_contact_phone = FrontendSetting::getVal('mobile_number_1', '7374044044');
        $pid = $deal->project_id;
        $projectName = $deal->project?->name ?? 'Project';

        $allotment_subtitle = FrontendSetting::getVal("project_{$pid}_allotment_subtitle", 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित');
        $allotment_subject = FrontendSetting::getVal("project_{$pid}_allotment_subject", 'विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !');
        $allotment_body = FrontendSetting::getVal("project_{$pid}_allotment_body", "हमें यह उद्घोषित करते हुए प्रसन्नता हो रही है कि हमारी योजना {$projectName} में आपका भूखण्ड \ फ्लैट का आवंटित किया जाना प्रस्तावित है जिसका विवरण निम्न प्रकार से है:");
        $allotment_footer_note = FrontendSetting::getVal("project_{$pid}_allotment_footer_note", 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।');

        $replacements = [
            '{PROJECT_NAME}' => $projectName,
            '{PROJECT_ADDRESS}' => $deal->project?->address ?? '',
            '{CUSTOMER_NAME}' => strtoupper($deal->first_name . ' ' . $deal->last_name),
            '{UNIT_NO}' => $inventory->plot_no ?: $inventory->flat_no,
            '{FORM_NO}' => 'RAJAWS-' . ($deal->created_at?->format('Y') ?: date('Y')) . '-' . substr($deal->id, 0, 8),
            '{BOOKING_DATE}' => $deal->booking_date ? \Carbon\Carbon::parse($deal->booking_date)->format('d-m-Y') : date('d-m-Y'),
            '{CONTACT_PHONE}' => $project_contact_phone,
        ];

        return view('emails.allotment-pdf', [
            'project' => $deal->project,
            'deal' => $deal,
            'inventory' => $inventory,
            'project_contact_phone' => $project_contact_phone,
            'allotment_subtitle' => strtr($allotment_subtitle, $replacements),
            'allotment_subject' => strtr($allotment_subject, $replacements),
            'allotment_body' => strtr($allotment_body, $replacements),
            'allotment_footer_note' => strtr($allotment_footer_note, $replacements),
        ]);
    }

    public function demandLetter(Deal $deal)
    {
        abort_unless(auth()->user()->can('leads.view'), 403);

        $deal->load(['project', 'allottedInventory']);
        $inventory = $deal->allottedInventory;

        if (!$inventory) {
            abort(404, 'No allotted unit found for this deal.');
        }

        ActivityLogger::logDeal($deal, 'demand_pdf_downloaded', 'Demand Letter Downloaded', "Downloaded Demand Letter PDF for {$deal->first_name} {$deal->last_name}");

        $project_contact_phone = FrontendSetting::getVal('mobile_number_1', '7374044044');
        $pid = $deal->project_id;
        $projectName = $deal->project?->name ?? 'Project';

        $demand_subtitle = FrontendSetting::getVal("project_{$pid}_demand_subtitle", 'जयपुर विकास प्राधिकरण द्वारा अनुमोदित');
        $demand_subject = FrontendSetting::getVal("project_{$pid}_demand_subject", 'विषय: भूखण्ड संख्या {UNIT_NO} की बकाया राशि जमा कराने बाबत।');
        $demand_body = FrontendSetting::getVal("project_{$pid}_demand_body", "{$projectName} में आवेदन पत्र संख्या {FORM_NO} के द्वारा आपने भूखण्ड आवंटन किये जाने हेतु बुकिंग कराई थी, आपको आवंटित भूखण्ड एवं उसके विक्रय प्रतिफल के पेटे जमा कराई जाने वाली राशि का विवरण निम्न प्रकार है:-");
        $demand_footer_para = FrontendSetting::getVal("project_{$pid}_demand_footer_para", "अतः आपसे अनुरोध है कि इस मांग पत्र के जारी होने की दिनांक से उक्तानुसार राशि जमा करावे अथवा लोन के लिए बैंक एवं फर्म द्वारा मांगे गए दस्तावेज, {PROJECT_ADDRESS} स्थित कार्यालय में स्वयं उपस्थित होकर जमा करावे। यदि किसी भी कारण से आप द्वारा उक्त राशि निर्धारित समयावधि में जमा नहीं कराई गयी तो बकाया राशि पर 18 प्रतिशत वार्षिक ब्याज की दर से ब्याज जमा कराना होगा。\n\nराशि के चेक / आरटीजीएस / एनईएफटी / आईएमपीएस / ऑनलाइन {$projectName} के नाम से देय होंगे।");
        $demand_footer_note = FrontendSetting::getVal("project_{$pid}_demand_footer_note", 'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।');

        $replacements = [
            '{PROJECT_NAME}' => $projectName,
            '{PROJECT_ADDRESS}' => $deal->project?->address ?? '',
            '{CUSTOMER_NAME}' => strtoupper($deal->first_name . ' ' . $deal->last_name),
            '{UNIT_NO}' => $inventory->plot_no ?: $inventory->flat_no,
            '{FORM_NO}' => 'RAJAWS-' . ($deal->created_at?->format('Y') ?: date('Y')) . '-' . substr($deal->id, 0, 8),
            '{BOOKING_DATE}' => $deal->booking_date ? \Carbon\Carbon::parse($deal->booking_date)->format('d-m-Y') : date('d-m-Y'),
            '{CONTACT_PHONE}' => $project_contact_phone,
        ];

        $bookingAmount = (float) FrontendSetting::getVal('booking_amount', 21100.00);
        $totalAmount = $deal->total_amount ?: ($inventory->price ?: 0.00);
        $balanceDue = max(0.00, $totalAmount - $bookingAmount);

        return view('emails.demand-pdf', [
            'project' => $deal->project,
            'deal' => $deal,
            'inventory' => $inventory,
            'bookingAmount' => $bookingAmount,
            'totalAmount' => $totalAmount,
            'balanceDue' => $balanceDue,
            'project_contact_phone' => $project_contact_phone,
            'demand_subtitle' => strtr($demand_subtitle, $replacements),
            'demand_subject' => strtr($demand_subject, $replacements),
            'demand_body' => strtr($demand_body, $replacements),
            'demand_footer_para' => strtr($demand_footer_para, $replacements),
            'demand_footer_note' => strtr($demand_footer_note, $replacements),
        ]);
    }

    public function dealPdf(Deal $deal)
    {
        abort_unless(auth()->user()->can('leads.view'), 403);

        $deal->load(['project', 'agent']);

        ActivityLogger::logDeal($deal, 'pdf_downloaded', 'Deal Summary PDF Downloaded', "Downloaded summary PDF for {$deal->first_name} {$deal->last_name}");

        $html = view('emails.deal-pdf', [
            'deal' => $deal,
        ])->render();

        $pdf = Pdf::loadHTML(reshapeDevanagari($html));

        return $pdf->download("deal-details-{$deal->id}.pdf");
    }

    public function leadPdf(\App\Models\Lead $lead)
    {
        abort_unless(auth()->user()->can('leads.view'), 403);

        $lead->load(['project', 'agent']);

        ActivityLogger::logLead($lead, 'pdf_downloaded', 'Lead Application PDF Downloaded', "Downloaded application PDF for {$lead->first_name} {$lead->last_name}");

        $html = view('emails.lead-pdf', [
            'lead' => $lead,
        ])->render();

        $pdf = Pdf::loadHTML(reshapeDevanagari($html));

        return $pdf->download("lead-details-{$lead->id}.pdf");
    }

    public function invoice(Deal $deal)
    {
        abort_unless(auth()->user()->can('leads.view'), 403);

        $deal->load(['project', 'allottedInventory']);

        ActivityLogger::logDeal($deal, 'invoice_generated', 'Invoice Generated', "Generated Payment Receipt / Invoice for {$deal->first_name} {$deal->last_name}");

        $bookingDate = $deal->booking_date ? $deal->booking_date->format('d-m-Y') : date('d-m-Y');
        $numericId = preg_replace('/[^0-9]/', '', $deal->id);
        $shortId = substr($numericId, -4) ?: rand(1000, 9999);
        $receiptYear = $deal->booking_date ? $deal->booking_date->format('Y') : date('Y');
        $receiptNo = "RAJAWAS-{$receiptYear}-15471-{$shortId}";

        $lead = \App\Models\Lead::where('pan_number', $deal->pan_number)
            ->orWhere('phone', $deal->phone)
            ->orWhere('email', $deal->email)
            ->first();

        $transactionId = $lead?->transaction_id ?: ('JDAAPP' . (substr($numericId, 0, 9) ?: '705410470'));

        $unitType = 'Flat';
        if ($deal->allottedInventory && $deal->allottedInventory->inventory_type === 'plot') {
            $unitType = 'Plot';
        }
        $descriptionText = "{$unitType}: {$deal->flat_size} Waver code->{$deal->waiver_code}";

        $bookingAmount = $deal->booking_amount ?: 21100;
        $amountInWords = numberToWords($bookingAmount);

        $data = [
            'deal' => $deal,
            'receipt_date' => $bookingDate,
            'receipt_no' => $receiptNo,
            'description_text' => $descriptionText,
            'amount_in_words' => $amountInWords,
            'transaction_id' => $transactionId,
            'print_id' => $shortId ?: '2128',
        ];

        if (request()->has('download')) {
            $html = view('emails.invoice-pdf', $data)->render();
            $pdf = Pdf::loadHTML(reshapeDevanagari($html));
            return $pdf->download("invoice-{$deal->id}.pdf");
        }

        return view('emails.invoice-pdf', $data);
    }
}