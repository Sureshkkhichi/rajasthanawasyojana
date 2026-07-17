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
        protected $pdfData
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Flat/Plot Allotment Letter - ' . $this->project->name
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
        return [
            Attachment::fromData(fn () => $this->pdfData, 'allotment-letter.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
