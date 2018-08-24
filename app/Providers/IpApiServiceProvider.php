<?php
namespace Ranking\Providers;
use Illuminate\Support\ServiceProvider;

class IpApiServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {   
        $this->app->singleton('\Ranking\Providers\IpApi\IpApiService', function ($app) {
           return new \Ranking\Providers\IpApi\IpApiService();
        });
    }
}