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

use Livewire\WithFileUploads;

#[Layout('layouts.app')]
#[Title('Deal Details')]
class Show extends Component
{
    use WithFileUploads;

    public Deal $deal;
    public bool $showEmailModal = false;
    public $allotment_pdf_file;
    public $demand_pdf_file;
    public string $email_recipient = '';

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
        $this->email_recipient = $this->deal->email ?: '';
    }

    public function openEmailModal(): void
    {
        if (!$this->deal->allotted_inventory_id) {
            $this->dispatch('swal:alert', [
                'title' => 'Error!',
                'text' => 'No allotted unit found to send email.',
                'icon' => 'error'
            ]);
            return;
        }

        $this->reset(['allotment_pdf_file', 'demand_pdf_file']);
        $this->resetErrorBag();
        $this->email_recipient = $this->deal->email ?: '';
        $this->showEmailModal = true;
    }

    public function closeEmailModal(): void
    {
        $this->showEmailModal = false;
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

        $this->validate([
            'email_recipient' => 'required|email',
            'allotment_pdf_file' => 'required|file|mimes:pdf|max:10240',
            'demand_pdf_file' => 'required|file|mimes:pdf|max:10240',
        ], [
            'email_recipient.required' => 'Customer email address is required.',
            'email_recipient.email' => 'Please enter a valid email address.',
            'allotment_pdf_file.required' => 'Please select the Allotment Letter PDF file.',
            'allotment_pdf_file.mimes' => 'Allotment Letter file must be a PDF.',
            'demand_pdf_file.required' => 'Please select the Demand Letter PDF file.',
            'demand_pdf_file.mimes' => 'Demand Letter file must be a PDF.',
        ]);

        try {
            $project_contact_phone = \App\Models\FrontendSetting::getVal('mobile_number_1', '7374044044');
            $inventory = $this->deal->allottedInventory;

            $allotmentPdf = file_get_contents($this->allotment_pdf_file->getRealPath());
            $demandPdf = file_get_contents($this->demand_pdf_file->getRealPath());

            // Send Mail
            Mail::to($this->email_recipient)
                ->cc('suresh5313@gmail.com')
                ->send(new AllotmentMail(
                    $this->deal,
                    $this->deal->project,
                    $inventory,
                    $project_contact_phone,
                    $allotmentPdf,
                    $demandPdf
                ));

            $this->showEmailModal = false;

            $this->dispatch('swal:alert', [
                'title' => 'Email Sent Successfully!',
                'text' => 'Allotment and Demand letters have been sent to ' . $this->email_recipient,
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

        // 2. Fallback to DomPDF with GD FreeType Devanagari text rendering for Hostinger Shared Hosting
        $htmlDompdf = str_replace('min-height: 297mm;', 'height: 297mm; max-height: 297mm;', $html);
        $htmlDompdf = str_replace('margin: 20px auto;', 'margin: 0 auto;', $htmlDompdf);
        $htmlDompdf = str_replace('background: #e0e0e0;', 'background: #ffffff;', $htmlDompdf);

        // Replace title badges with crisp FreeType Devanagari images
        $badgeAllotmentDataUri = $this->renderDevanagariTextToPng('आवंटन पत्र', 18, '#ffffff', '#d32f2f', true);
        if ($badgeAllotmentDataUri) {
            $htmlDompdf = str_replace('<div class="badge-box">आवंटन पत्र</div>', '<div style="text-align:center; margin-bottom:14px;"><img src="' . $badgeAllotmentDataUri . '" style="height:36px; display:inline-block;" /></div>', $htmlDompdf);
        }

        $badgeDemandDataUri = $this->renderDevanagariTextToPng('मांग पत्र', 18, '#ffffff', '#d32f2f', true);
        if ($badgeDemandDataUri) {
            $htmlDompdf = str_replace('<div class="badge-box">मांग पत्र</div>', '<div style="text-align:center; margin-bottom:14px;"><img src="' . $badgeDemandDataUri . '" style="height:36px; display:inline-block;" /></div>', $htmlDompdf);
        }

        // Replace key unshaped text lines with FreeType rendered text images for 100% perfect Hostinger PDF rendering
        $phrases = [
            'जयपुर विकास प्राधिकरण द्वारा अनुमोदित' => $this->renderDevanagariTextToPng('जयपुर विकास प्राधिकरण द्वारा अनुमोदित', 16, '#333333', null, true),
            'विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !' => $this->renderDevanagariTextToPng('विषय:- आवासीय भूखण्ड \ फ्लैट \ व्यवसायिक भूखण्ड आवंटन की सूचना बाबत !', 13, '#333333', null, true),
            'क्षेत्रफल (वर्ग फीट में)' => $this->renderDevanagariTextToPng('क्षेत्रफल (वर्ग फीट में)', 12, '#333333', null, true),
            'नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।' => $this->renderDevanagariTextToPng('नोट - पट्टा एवं रजिस्ट्री शुल्क अतिरिक्त।', 11, '#333333', null, true),
        ];

        foreach ($phrases as $search => $uri) {
            if ($uri) {
                $htmlDompdf = str_replace($search, '<img src="' . $uri . '" style="vertical-align:middle; max-height:22px;" />', $htmlDompdf);
            }
        }

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

    private function renderDevanagariTextToPng(string $text, int $fontSize = 14, string $fontColor = '#333333', ?string $bgColor = null, bool $isBold = false): ?string
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        $fontFile = $isBold ? storage_path('fonts/Mukta-Bold.ttf') : storage_path('fonts/Mukta-Regular.ttf');
        if (!file_exists($fontFile)) {
            $fontFile = storage_path('fonts/Hind-Bold.ttf');
        }
        if (!file_exists($fontFile)) {
            return null;
        }

        $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $width = abs($bbox[4] - $bbox[0]) + 16;
        $height = abs($bbox[5] - $bbox[1]) + 14;

        $image = imagecreatetruecolor($width, $height);
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $hex = ltrim($fontColor, '#');
        $textColor = imagecolorallocate($image, hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));

        if ($bgColor) {
            $bgHex = ltrim($bgColor, '#');
            $background = imagecolorallocate($image, hexdec(substr($bgHex, 0, 2)), hexdec(substr($bgHex, 2, 2)), hexdec(substr($bgHex, 4, 2)));
            imagefilledrectangle($image, 0, 0, $width, $height, $background);
        } else {
            $transparent = imagecolorallocatealpha($image, 255, 255, 255, 127);
            imagefilledrectangle($image, 0, 0, $width, $height, $transparent);
        }

        imagettftext($image, $fontSize, 0, 8, $fontSize + 5, $textColor, $fontFile, $text);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    public function render()
    {
        return view('livewire.deal.show');
    }
}
