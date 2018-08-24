<?php namespace Ranking\Score\Providers;

use Illuminate\foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Ranking\Score\Contracts\ScoresRepositoryContract;
use Ranking\Score\Facades\Scores;
use Ranking\Score\Repositories\EloquentScoresRepository;

class ScoresServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function register()
    {
        $this->registerProvider();
        $this->registerFacade();
    }

    protected function registerProvider()
    {
        $contract = ScoresRepositoryContract::class;
        $repository = EloquentScoresRepository::class;
        $this->app->bind($contract, $repository);
    }

    protected function registerFacade()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            /* Aliases */
            $modelFacade = Scores::class;
            $loader->alias('Scores', $modelFacade);
        });
    }
}