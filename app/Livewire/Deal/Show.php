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
    public $inventories = [];

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
        $this->loadInventories();
    }

    public function loadInventories(): void
    {
        $this->inventories = Inventory::where('project_id', $this->deal->project_id)
            ->orderBy('status')
            ->orderBy('flat_no')
            ->orderBy('plot_no')
            ->get();
    }

    public function allotInventory($inventoryId): void
    {
        $inventory = Inventory::findOrFail($inventoryId);

        if ($inventory->status !== 'Available') {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'This unit is not available for allotment.',
                'icon' => 'error'
            ]);
            return;
        }

        if ($this->deal->allotted_inventory_id) {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'This customer already has an allotted unit.',
                'icon' => 'error'
            ]);
            return;
        }

        // Lock unit status
        $inventory->update(['status' => 'Booked']);

        // Link unit to deal
        $this->deal->update(['allotted_inventory_id' => $inventory->id]);

        // Get contact phone from general settings
        $project_contact_phone = \App\Models\FrontendSetting::getVal('mobile_number_1', '7374044044');

        // Generate Allotment PDF
        $pdf = Pdf::loadView('emails.allotment-pdf', [
            'project' => $this->deal->project,
            'deal' => $this->deal,
            'inventory' => $inventory,
            'project_contact_phone' => $project_contact_phone,
        ]);
        $pdfData = $pdf->output();

        // Dispatch Email with PDF attachment
        Mail::to($this->deal->email)
            ->cc('suresh5313@gmail.com')
            ->send(new AllotmentMail($this->deal, $this->deal->project, $inventory, $project_contact_phone, $pdfData));

        $this->deal->load(['project', 'agent', 'allottedInventory']);
        $this->loadInventories();

        $this->dispatch('swal:alert', [
            'title' => 'Allotment Successful!',
            'text' => 'Unit has been allotted, and allotment mail with PDF has been successfully sent to the customer.',
            'icon' => 'success'
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
        $this->loadInventories();

        $this->dispatch('swal:alert', [
            'title' => 'Allotment Cancelled!',
            'text' => 'Unit allotment has been successfully cancelled and the unit is now available.',
            'icon' => 'warning'
        ]);
    }

    public function render()
    {
        return view('livewire.deal.show');
    }
}
