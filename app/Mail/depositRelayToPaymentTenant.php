<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class depositRelayToPaymentTenant extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $depositRelay, $property, $propertyTenant;
    public function __construct($depositRelay, $property, $propertyTenant)
    {
       $this->depositRelay = $depositRelay;
       $this->property = $property;
       $this->propertyTenant = $propertyTenant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.depositRelays.paymentToTenant')->subject(trans('tenant.payment_process'));
    }
}
