<?php

namespace App\Providers;

use Google\Client;
use App\CustomServices\GoogleOAuthApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleOAuthApiClient::class, function () {
            $client = app(GoogleOAuthApiClient::class);
            
            $config = config('services.google_drive');
            $client->setClientId($config['client_id']);
            $client->setClientSecret($config['client_secret']);
            $client->setRedirectUri($config['redirect_url']);
        
            return $client;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
