<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class tenantInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $url, $user, $tenantName , $property;
    public function __construct($url, $user, $tenantName, $property)
    {
        $this->url = $url;
        $this->user = $user;
        $this->tenantName = $tenantName;
        $this->property = $property;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invitations.TenantInvited_nl')->subject(trans('tenant.tenant_invitation'));
    }
}
