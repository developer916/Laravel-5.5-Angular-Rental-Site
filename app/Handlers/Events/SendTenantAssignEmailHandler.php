<?php

	namespace App\Handlers\Events;

	use App\Events\TenantWasAssigned;
	use Mail;

	use App\Events\TenantWasCreated;
	use Illuminate\Queue\InteractsWithQueue;
	use Illuminate\Contracts\Queue\ShouldQueue;

	class SendTenantAssignEmailHandler {
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
		public function handle (TenantWasAssigned $event) {
			/* TEMPORARILY DEACTIVATE TENANT ASSIGNMENT EMAILS DURING APRIL-MAY PROMO
			Mail::send('emails.tenants.assign', ['event' => $event], function ($m) use ($event) {
				$m->to($event->userData['email'], $event->userData['name'])->subject('Welcome to Rentling as a tenant');
			});
			*/
		}
	}
