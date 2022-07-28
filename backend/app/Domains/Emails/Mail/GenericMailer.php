<?php

namespace App\Domains\Emails\Mail;

use App\Domains\Emails\Models\EmailQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Factory as Queue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GenericMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $viewData;

    /**
     * GenericMailer constructor.
     * @param string $to
     */
    public function __construct(string $to)
    {
        // todo: chris env local check here
        $this->to($to);
    }

    public function build() {
        return $this;
    }


}
