<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class depositRelayTenantLandlord extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public  $deposit_relay;
    public function __construct($deposit_relay)
    {
        $this->deposit_relay = $deposit_relay;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.depositRelays.tenant_landlord')->subject(trans('register.change_date_or_amount'));
    }
}
