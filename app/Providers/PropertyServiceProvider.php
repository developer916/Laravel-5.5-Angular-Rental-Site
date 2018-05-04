<?php

namespace App\Providers;

use App\Http\Services\PropertyService;
use Illuminate\Support\ServiceProvider;

class PropertyServiceProvider extends ServiceProvider
{
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
        $this->app->bind('App\Http\Services\PropertyService', function($app)
        {
            return new PropertyService(
                $app['Illuminate\Http\Request'],
                $app['App\Http\Services\UserService']
            );
        });
    }
}
