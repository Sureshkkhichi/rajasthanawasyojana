<?php

namespace App\Mail;

use App\Models\Lead;
use App\Models\Deal;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmationMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public Lead $lead,
        public Deal $deal
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Confirmation & Booking Confirmation - ' . ($this->lead->project->name ?? 'Rajasthan Awas Yojana')
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-confirmation'
        );
    }
}
