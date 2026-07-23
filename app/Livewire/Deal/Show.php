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
        \App\Livewire\Deal\Index::expireOldAllotments();
        $this->deal = $deal->fresh([
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

        $this->deal->update([
            'allotted_inventory_id' => null,
            'allotted_at' => null
        ]);

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

    public function sendEmail(): void
    {
        if (!$this->deal->allotted_inventory_id) {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'No allotted unit found to send email.',
                'icon' => 'error'
            ]);
            return;
        }

        if (empty($this->deal->email)) {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'Customer email address is missing.',
                'icon' => 'error'
            ]);
            return;
        }

        try {
            $project_contact_phone = \App\Models\FrontendSetting::getVal('mobile_number_1', '7374044044');
            $inventory = $this->deal->allottedInventory;

            // 1. Generate Allotment Letter PDF
            $allotmentHtml = $this->preparePdfHtmlForEmail('emails.allotment-pdf', [
                'project' => $this->deal->project,
                'deal' => $this->deal,
                'inventory' => $inventory,
                'project_contact_phone' => $project_contact_phone,
            ]);
            $allotmentPdfObj = Pdf::loadHTML($allotmentHtml);
            $allotmentPdfObj->setPaper('a4', 'portrait');
            $allotmentPdf = $allotmentPdfObj->output();

            // 2. Generate Demand Letter PDF
            $bookingAmount = (float) \App\Models\FrontendSetting::getVal('booking_amount', 21100.00);
            $totalAmount = $this->deal->total_amount ?: ($inventory->price ?: 0.00);
            $balanceDue = max(0.00, $totalAmount - $bookingAmount);

            $demandHtml = $this->preparePdfHtmlForEmail('emails.demand-pdf', [
                'project' => $this->deal->project,
                'deal' => $this->deal,
                'inventory' => $inventory,
                'bookingAmount' => $bookingAmount,
                'totalAmount' => $totalAmount,
                'balanceDue' => $balanceDue,
                'project_contact_phone' => $project_contact_phone,
            ]);
            $demandPdfObj = Pdf::loadHTML($demandHtml);
            $demandPdfObj->setPaper('a4', 'portrait');
            $demandPdf = $demandPdfObj->output();

            // Send Mail
            Mail::to($this->deal->email)
                ->cc('suresh5313@gmail.com')
                ->send(new AllotmentMail(
                    $this->deal,
                    $this->deal->project,
                    $inventory,
                    $project_contact_phone,
                    $allotmentPdf,
                    $demandPdf
                ));

            $this->dispatch('swal:alert', [
                'title' => 'Email Sent!',
                'text' => 'Allotment and Demand letters have been sent successfully to ' . $this->deal->email,
                'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send allotment & demand email: ' . $e->getMessage());
            $this->dispatch('swal:alert', [
                'title' => 'Email Error!',
                'text' => 'Failed to send email: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function sendSms(): void
    {
        $this->dispatch('swal:alert', [
            'title' => 'SMS Notification',
            'text' => 'SMS functionality is triggered (service integration pending).',
            'icon' => 'info'
        ]);
    }

    private function preparePdfHtmlForEmail(string $viewName, array $data): string
    {
        $html = view($viewName, $data)->render();

        // 1. Replace background image URL with base64 data URI for DomPDF
        $bgImagePath = public_path('back_img.png');
        $bgBase64 = file_exists($bgImagePath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($bgImagePath)) : asset('back_img.png');

        $html = str_replace([
            asset('back_img.png'),
            'https://rajasthanawasyojana.com/admin/img/back_img.png',
            'https://www.rajasthanawasyojana.com/admin/img/back_img.png'
        ], $bgBase64, $html);

        // 2. Fix A4 height & remove @media screen margins so DomPDF generates exactly 1 page
        $html = str_replace('min-height: 297mm;', 'height: 297mm; max-height: 297mm;', $html);
        $html = str_replace('margin: 20px auto;', 'margin: 0 auto;', $html);
        $html = str_replace('background: #e0e0e0;', 'background: #ffffff;', $html);

        // 3. Inject Noto Sans Devanagari font for DomPDF
        $fontPath = storage_path('fonts/NotoSansDevanagari.ttf');
        if (file_exists($fontPath)) {
            $cssFont = '<style>
            @font-face {
                font-family: "Noto Sans Devanagari";
                font-style: normal;
                font-weight: 400;
                src: url("' . $fontPath . '") format("truetype");
            }
            body, table, td, th, div, span, p, *, html {
                font-family: "Noto Sans Devanagari", sans-serif !important;
            }
            </style>';
            $html = str_replace('</head>', $cssFont . '</head>', $html);
        }

        // 4. Reorder short i matra for DomPDF rendering
        $html = preg_replace('/((?:[\x{0915}-\x{0939}]\x{094d})?[\x{0915}-\x{0939}])\x{093f}/u', 'ि$1', $html);

        return $html;
    }

    public function render()
    {
        return view('livewire.deal.show');
    }
}
