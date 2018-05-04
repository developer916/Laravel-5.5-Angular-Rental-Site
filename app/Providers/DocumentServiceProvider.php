<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Http\Services\DocumentService', function($app)
        {
            return new DocumentService(
                $app['Illuminate\Http\Request'],
                $app['App\Http\Services\UserService']
            );
        });
    }
}
