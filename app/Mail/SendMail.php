<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function build() {
        return $this->view('emails.send-mail')
            ->subject('Test Email')
            ->from('noreply@parts.maccgarage.com')
            ->to('james.andrew.cocker@gmail.com');
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope() {
        return new Envelope(
            subject: 'Send Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content() {
        return new Content(
            view: 'test',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments() {
        return [];
    }
}
