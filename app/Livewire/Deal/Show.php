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
            $allotmentPdf = $this->generatePdfBinary('emails.allotment-pdf', [
                'project' => $this->deal->project,
                'deal' => $this->deal,
                'inventory' => $inventory,
                'project_contact_phone' => $project_contact_phone,
            ]);

            // 2. Generate Demand Letter PDF
            $bookingAmount = (float) \App\Models\FrontendSetting::getVal('booking_amount', 21100.00);
            $totalAmount = $this->deal->total_amount ?: ($inventory->price ?: 0.00);
            $balanceDue = max(0.00, $totalAmount - $bookingAmount);

            $demandPdf = $this->generatePdfBinary('emails.demand-pdf', [
                'project' => $this->deal->project,
                'deal' => $this->deal,
                'inventory' => $inventory,
                'bookingAmount' => $bookingAmount,
                'totalAmount' => $totalAmount,
                'balanceDue' => $balanceDue,
                'project_contact_phone' => $project_contact_phone,
            ]);

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

    private function generatePdfBinary(string $viewName, array $data): string
    {
        $html = view($viewName, $data)->render();

        // Prepare Base64 background image
        $bgImagePath = public_path('back_img.png');
        $bgBase64 = file_exists($bgImagePath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($bgImagePath)) : asset('back_img.png');

        $html = str_replace([
            asset('back_img.png'),
            'https://rajasthanawasyojana.com/admin/img/back_img.png',
            'https://www.rajasthanawasyojana.com/admin/img/back_img.png'
        ], $bgBase64, $html);

        // Add Chrome Print CSS for exact 1-page A4 printing with full Devanagari font rendering
        $chromePrintCss = '<style>
        @page {
            size: A4 portrait;
            margin: 0mm;
        }
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            margin: 0 !important;
        }
        .page-wrapper {
            margin: 0 auto !important;
            box-shadow: none !important;
        }
        </style>';
        $htmlForChrome = str_replace('</head>', $chromePrintCss . '</head>', $html);

        // 1. Try Chrome Headless (100% Perfect Chromium Devanagari font rendering)
        $chromePaths = [
            '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome',
            '/usr/bin/google-chrome',
            '/usr/bin/chromium-browser',
            '/usr/bin/chromium',
            'google-chrome',
            'chromium',
            'chrome'
        ];

        foreach ($chromePaths as $binary) {
            if (file_exists($binary) || ($binary !== '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome' && @shell_exec("which " . escapeshellarg($binary)))) {
                $tempHtml = tempnam(sys_get_temp_dir(), 'pdf_') . '.html';
                $tempPdf = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';

                file_put_contents($tempHtml, $htmlForChrome);

                $cmd = sprintf(
                    '%s --headless --disable-gpu --no-sandbox --print-to-pdf=%s --no-pdf-header-footer %s 2>&1',
                    escapeshellarg($binary),
                    escapeshellarg($tempPdf),
                    escapeshellarg($tempHtml)
                );

                exec($cmd, $output, $returnCode);
                @unlink($tempHtml);

                if ($returnCode === 0 && file_exists($tempPdf) && filesize($tempPdf) > 0) {
                    $pdfContent = file_get_contents($tempPdf);
                    @unlink($tempPdf);
                    return $pdfContent;
                }
                @unlink($tempPdf);
            }
        }

        // 2. Fallback to DomPDF if Chrome Headless is not available on server
        $htmlDompdf = str_replace('min-height: 297mm;', 'height: 297mm; max-height: 297mm;', $html);
        $htmlDompdf = str_replace('margin: 20px auto;', 'margin: 0 auto;', $htmlDompdf);
        $htmlDompdf = str_replace('background: #e0e0e0;', 'background: #ffffff;', $htmlDompdf);

        $regularFont = storage_path('fonts/Mukta-Regular.ttf');
        $boldFont = storage_path('fonts/Mukta-Bold.ttf');
        if (file_exists($regularFont) && file_exists($boldFont)) {
            $cssFont = '<style>
            @font-face {
                font-family: "Mukta"; font-style: normal; font-weight: 400;
                src: url("' . $regularFont . '") format("truetype");
            }
            @font-face {
                font-family: "Mukta"; font-style: normal; font-weight: 700;
                src: url("' . $boldFont . '") format("truetype");
            }
            body, table, td, th, div, span, p, *, html {
                font-family: "Mukta", sans-serif !important;
            }
            </style>';
            $htmlDompdf = str_replace('</head>', $cssFont . '</head>', $htmlDompdf);
        }

        $pdfObj = Pdf::loadHTML(reshapeDevanagari($htmlDompdf));
        $pdfObj->setPaper('a4', 'portrait');
        return $pdfObj->output();
    }

    public function render()
    {
        return view('livewire.deal.show');
    }
}
