<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class registerLandlordToTenant extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $url , $deposit_relay, $tenantExist, $tenantUrl;
    public function __construct($url, $deposit_relay, $tenantExist, $tenantUrl)
    {
        $this->url = $url;
        $this->deposit_relay = $deposit_relay;
        $this->tenantExist = $tenantExist;
        $this->tenantUrl = $tenantUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registerLandlordToTenant')->subject(trans('register.rentling_reposit_realy_next_steps'));
    }
}
