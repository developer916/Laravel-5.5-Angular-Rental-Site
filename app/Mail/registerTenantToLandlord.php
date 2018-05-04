<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class registerTenantToLandlord extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $url , $deposit_relay, $landlordExist, $landlordUrl;
    public function __construct($url , $deposit_relay, $landlordExist, $landlordUrl)
    {
        $this->url = $url;
        $this->deposit_relay = $deposit_relay;
        $this->landlordExist = $landlordExist;
        $this->landlordUrl = $landlordUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registerTenantToLandlord')->subject(trans('register.rentling_reposit_realy_next_steps'));
    }
}
