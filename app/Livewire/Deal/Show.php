<?php

namespace App\Livewire\Deal;

use App\Models\Deal;
use App\Models\Inventory;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\AllotmentMail;

#[Layout('layouts.app')]
#[Title('Deal Details')]
class Show extends Component
{
    public Deal $deal;

    public function mount(Deal $deal): void
    {
        abort_unless(
            auth()->user()->can('leads.view'),
            403
        );
        $this->deal = $deal->load([
            'project',
            'agent',
            'allottedInventory'
        ]);
    }

    public function cancelAllotment(): void
    {
        if (!$this->deal->allotted_inventory_id) {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'No allotted unit found to cancel.',
                'icon' => 'error'
            ]);
            return;
        }

        $inventory = $this->deal->allottedInventory;
        if ($inventory) {
            $inventory->update(['status' => 'Available']);
        }

        $this->deal->update(['allotted_inventory_id' => null]);

        $this->deal->load(['project', 'agent', 'allottedInventory']);

        $this->dispatch('swal:alert', [
            'title' => 'Allotment Cancelled!',
            'text' => 'Unit allotment has been successfully cancelled and the unit is now available.',
            'icon' => 'warning'
        ]);
    }

    public function downloadAllotment()
    {
        $project_contact_phone = \App\Models\FrontendSetting::getVal('mobile_number_1', '7374044044');
        $inventory = $this->deal->allottedInventory;

        $html = view('emails.allotment-pdf', [
            'project' => $this->deal->project,
            'deal' => $this->deal,
            'inventory' => $inventory,
            'project_contact_phone' => $project_contact_phone,
        ])->render();

        $pdf = Pdf::loadHTML(reshapeDevanagari($html));

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "allotment-letter-{$this->deal->id}.pdf"
        );
    }

    public function downloadDemand()
    {
        $project_contact_phone = \App\Models\FrontendSetting::getVal('mobile_number_1', '7374044044');
        $inventory = $this->deal->allottedInventory;

        $bookingAmount = 21100.00;
        $totalAmount = $this->deal->total_amount ?: ($inventory->price ?: 0.00);
        $balanceDue = max(0.00, $totalAmount - $bookingAmount);

        $html = view('emails.demand-pdf', [
            'project' => $this->deal->project,
            'deal' => $this->deal,
            'inventory' => $inventory,
            'bookingAmount' => $bookingAmount,
            'totalAmount' => $totalAmount,
            'balanceDue' => $balanceDue,
            'project_contact_phone' => $project_contact_phone,
        ])->render();

        $pdf = Pdf::loadHTML(reshapeDevanagari($html));

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "demand-letter-{$this->deal->id}.pdf"
        );
    }

    public function render()
    {
        return view('livewire.deal.show');
    }
}
