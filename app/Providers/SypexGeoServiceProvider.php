<?php
namespace Ranking\Providers;
use Illuminate\Support\ServiceProvider;

class SypexGeoServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->singleton('\Ranking\Providers\Sypex\SypexGeoService', function ($app) {
           
           return new \Ranking\Providers\Sypex\SypexGeoService();
        });
        
    }
}