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

        return view('emails.allotment-pdf', [
            'project' => $deal->project,
            'deal' => $deal,
            'inventory' => $inventory,
            'project_contact_phone' => $project_contact_phone,
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