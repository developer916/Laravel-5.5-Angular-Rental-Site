<?php

namespace App\Providers;

use App\Events\TenantWasCreated;
use App\Events\TenantWasAssigned;
use App\Events\UserPasswordWasReset;
use App\Handlers\Events\SendTenantAssignEmailHandler;
use App\Handlers\Events\SendTenantInviteEmailHandler;
use App\Handlers\Events\PasswordResetHandler;

use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        TenantWasCreated::class         => [
            SendTenantInviteEmailHandler::class
        ],
        TenantWasAssigned::class        => [
            SendTenantAssignEmailHandler::class
        ],
        FirstInvoiceWasGenerated::class => [
            SendInvoiceEmailHandler::class
        ],
        UserPasswordWasReset::class     => [
            PasswordResetHandler::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
