<?php

namespace App\Mail;

use App\Models\Deal;
use App\Models\Project;
use App\Models\Inventory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class AllotmentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Deal $deal,
        public Project $project,
        public Inventory $inventory,
        public string $project_contact_phone,
        protected $allotmentPdfData,
        protected $demandPdfData = null
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Allotment Letter & Demand Letter - ' . $this->project->name
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.allotment-mail',
        );
    }

    public function attachments(): array
    {
        $attachments = [
            Attachment::fromData(fn () => $this->allotmentPdfData, 'Allotment-Letter-' . $this->deal->id . '.pdf')
                ->withMime('application/pdf'),
        ];

        if ($this->demandPdfData) {
            $attachments[] = Attachment::fromData(fn () => $this->demandPdfData, 'Demand-Letter-' . $this->deal->id . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
