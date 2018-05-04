<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPasswordChange extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(\App::getLocale() == 'nl') {
            $emailTemplate  ="UserPasswordWasChanged_nl";
        }else {
            $emailTemplate  ="UserPasswordWasChanged_en";
        }
        return $this->view('emails.'.$emailTemplate)->subject(trans('passwords.reset'));
    }
}
