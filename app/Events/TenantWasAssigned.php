<?php

	namespace App\Events;

	use App\Events\Event;
	use Illuminate\Queue\SerializesModels;
	use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

	class TenantWasAssigned extends Event {
		use SerializesModels;


		public $userData;
		public $templatePath;

		/**
		 * Create a new event instance.
		 *
		 * @return void
		 */
		public function __construct ($userData, $templatePath) {
			$this->userData     = $userData;
			$this->templatePath = $templatePath;
		}

		/**
		 * Get the channels the event should be broadcast on.
		 *
		 * @return array
		 */
		public function broadcastOn () {
			return [];
		}
	}
