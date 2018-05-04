<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class landlordInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $url, $user, $landlordName, $property;
    public function __construct($url, $user, $landlordName,$property)
    {
        $this->url = $url;
        $this->user = $user;
        $this->landlordName = $landlordName;
        $this->property = $property;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invitations.LandlordInvited_nl')->subject(trans('tenant.landlord_invitation'));
    }
}
