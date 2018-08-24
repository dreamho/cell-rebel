<?php
namespace Ranking\Providers;
use Illuminate\Support\ServiceProvider;

class WurflServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {   
        $this->app->singleton('\Ranking\Providers\Wurfl\WurflService', function ($app) {
        	return new \Ranking\Providers\Wurfl\WurflService();
        });
    }
}