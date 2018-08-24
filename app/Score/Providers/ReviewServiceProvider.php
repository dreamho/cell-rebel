<?php namespace Ranking\Score\Providers;

use Illuminate\foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Ranking\Score\Contracts\ReviewRepositoryContract;
use Ranking\Score\Facades\Reviews;
use Ranking\Score\Repositories\EloquentReviewRepository;

class ReviewServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->registerProvider();
        $this->registerFacade();
    }

    protected function registerProvider()
    {
        $contract   = ReviewRepositoryContract::class;
        $repository = EloquentReviewRepository::class;
        $this->app->bind( $contract, $repository );
    }

    protected function registerFacade()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            /* Aliases */
            $modelFacade = Reviews::class;
            $loader->alias('Reviews', $modelFacade);
        });
    }
}