<?php

namespace App\Mail;

use App\Models\PersekotRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PersekotApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $persekotRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(PersekotRequest $persekotRequest)
    {
        $this->persekotRequest = $persekotRequest;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Persekot Request Approved')
                    ->view('emails.persekot_approved');
    }
}
