<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Htmlable;


class Email extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $subject;
    public $template;
    public $htmlContent;
    public function __construct($data = '', $subject = '', $template = '', $htmlContent = '')
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->template = $template;
        $this->htmlContent = $htmlContent;
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    public function content()
    {
        return new Content($this->template);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
    public function build()
    {
        return $this->view('emails.custom')
            ->with(['htmlContent' => $this->htmlContent]);
    }

}
