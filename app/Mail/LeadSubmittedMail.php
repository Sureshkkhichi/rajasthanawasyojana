<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeadSubmittedMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public Lead $lead
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Form Submitted Successfully'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.lead-submitted'
        );
    }
}