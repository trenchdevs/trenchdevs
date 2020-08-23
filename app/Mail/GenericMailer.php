<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMailer extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $body;

    /**
     * GenericMailer constructor.
     * @param string $name
     * @param string $body
     */
    public function __construct(string $body, string $name = null)
    {
        $this->name = $name;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.generic')
            ->with([
                'name' => $this->name,
                'email_body' => $this->body
            ]);
    }
}
