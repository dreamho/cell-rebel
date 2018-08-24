<?php namespace Ranking\Score\Facades;

use Illuminate\Support\Facades\Facade;
use Ranking\Score\Contracts\ReviewRepositoryContract;

class Reviews extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReviewRepositoryContract::class;
    }
}