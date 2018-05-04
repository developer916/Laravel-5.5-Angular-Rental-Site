<?php

    namespace App\Handlers\Events;

    use App\Events\InvoiceWasGenerated;
    use Mail;

    use App\Events\TenantWasCreated;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Contracts\Queue\ShouldQueue;

    class SendInvoiceEmailHandler {
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
         * @param  TenantWasCreated $event
         *
         * @return void
         */
        public function handle (InvoiceWasGenerated $event) {
            /* TEMPORARILY DEACTIVATE TENANT ASSIGNMENT EMAILS DURING APRIL-MAY PROMO
            Mail::send('emails.tenants.invite', ['event' => $event], function ($m) use ($event) {
                $m->to($event->userData['email'], $event->userData['name'])->subject(trans('invoice.invoice_issued'));
            });
            */
        }
    }
