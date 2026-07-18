<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\FrontendSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

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

        $project_contact_phone = FrontendSetting::getVal('mobile_number_1', '7374044044');

        $pdf = Pdf::loadView('emails.allotment-pdf', [
            'project' => $deal->project,
            'deal' => $deal,
            'inventory' => $inventory,
            'project_contact_phone' => $project_contact_phone,
        ]);

        return $pdf->download("allotment-letter-{$deal->id}.pdf");
    }

    public function demandLetter(Deal $deal)
    {
        abort_unless(auth()->user()->can('leads.view'), 403);

        $deal->load(['project', 'allottedInventory']);
        $inventory = $deal->allottedInventory;

        if (!$inventory) {
            abort(404, 'No allotted unit found for this deal.');
        }

        $project_contact_phone = FrontendSetting::getVal('mobile_number_1', '7374044044');

        $bookingAmount = 21100.00;
        $totalAmount = $deal->total_amount ?: ($inventory->price ?: 0.00);
        $balanceDue = max(0.00, $totalAmount - $bookingAmount);

        $pdf = Pdf::loadView('emails.demand-pdf', [
            'project' => $deal->project,
            'deal' => $deal,
            'inventory' => $inventory,
            'bookingAmount' => $bookingAmount,
            'totalAmount' => $totalAmount,
            'balanceDue' => $balanceDue,
            'project_contact_phone' => $project_contact_phone,
        ]);

        return $pdf->download("demand-letter-{$deal->id}.pdf");
    }
}
