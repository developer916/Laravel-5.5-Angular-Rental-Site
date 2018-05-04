<?php

namespace App\Providers;

use App\Http\Services\TenantService;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Http\Services\TenantService', function($app)
        {
            return new TenantService(
                $app['Illuminate\Http\Request']
            );
        });
    }
}
