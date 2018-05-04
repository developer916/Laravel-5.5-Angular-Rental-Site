<?php
namespace App\Events;


class UserPasswordWasChanged extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userData, $templatePath)
    {
        $this->userData = $userData;
        $this->templatePath = $templatePath;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}