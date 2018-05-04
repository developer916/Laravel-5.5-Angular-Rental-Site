<?php

    namespace App\Commands;

    use App\Commands\Command;

    use App\Models\Notification;

//    use Illuminate\Contracts\Bus\SelfHandling;

    class CreateNotification extends Command  {
        public $notification;

        public function __construct ($notificationData) {
            $this->notification = $notificationData;
        }

        public function handle () {

            Notification::create([
                'action'      => $this->notification['action'],
                'creator_id'  => $this->notification['creator_id'],
                'receiver_id' => (isset($this->notification['receiver_id']) ? $this->notification['receiver_id'] : 0),
                'message'     => (isset($this->notification['message']) ? $this->notification['message'] : '')
            ]);
        }
    }
