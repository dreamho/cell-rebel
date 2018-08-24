<?php namespace Ranking\Providers;

use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\BasicCommandTranslator;
use Laracasts\Commander\CommandBus;
use Laracasts\Commander\CommandTranslator;
use Laracasts\Commander\DefaultCommandBus;

class CommanderServiceProvider extends ServiceProvider
{
    protected $defer = false;
    public function boot()
    {
        $this->commands([
            'Laracasts\Commander\Console\CommanderGenerateCommand'
        ]);
    }
    public function register()
    {
        $this->registerCommandTranslator();
        $this->registerCommandBus();
    }
    public function provides()
    {
        return ['commander'];
    }
    protected function registerCommandTranslator()
    {
        $this->app->bind(CommandTranslator::class, BasicCommandTranslator::class);
    }
    protected function registerCommandBus()
    {
        $this->app->bind(CommandBus::class, function($app)
        {
            return $app->make(DefaultCommandBus::class);
        });
    }
}