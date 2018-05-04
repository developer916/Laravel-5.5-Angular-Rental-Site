<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class depositRelayCancelTenant extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $depositRelay, $type, $property;
    public function __construct($depositRelay, $type,$property)
    {
        $this->depositRelay = $depositRelay;
        $this->type = $type;
        $this->property = $property;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.depositRelays.cancelTenant')->subject(trans('tenant.cancel_deposit'));
    }
}
