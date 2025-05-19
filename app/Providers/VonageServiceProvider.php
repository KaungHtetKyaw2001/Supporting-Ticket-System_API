<?php

namespace App\Providers;

use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;
use Illuminate\Support\ServiceProvider;

class VonageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client(new Basic(
                config('67507085'),
                config('xAAd8YDv9WkgAsqA')
            ));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
