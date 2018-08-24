<?php namespace Ranking\Score\Facades;

use Illuminate\Support\Facades\Facade;
use Ranking\Score\Contracts\ScoresRepositoryContract;

class Scores extends Facade{

    protected static function getFacadeAccessor()
    {
        return ScoresRepositoryContract::class;
    }
}