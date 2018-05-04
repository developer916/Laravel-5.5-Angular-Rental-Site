<?php

    namespace App\Handlers\Events;

    use Mail;

    use App\Events\UserPasswordWasReset;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Contracts\Queue\ShouldQueue;

    class PasswordResetHandler {
        /**
         * Create the event handler.
         *
         * @return void
         */
        public function __construct () {
            //
        }

        /**
         * Handle the event.
         *
         * @param  UserPasswordWasReset $event
         *
         * @return void
         */
        public function handle (UserPasswordWasReset $event) {

            Mail::send('emails.reset_password', [
                'email'    => $event->userData['email'],
                'name'     => $event->userData['name'],
                'password' => $event->userData['password'],
                'loginLink' => $event->userData['loginLink']
            ], function ($m) use ($event) {
                $m->to($event->userData['email'], $event->userData['name'])->subject(trans('passwords.reset'));
            });
        }
    }
