<?php namespace Ranking\Models;

use Ranking\Base\BaseModel;

class WorldCity extends BaseModel{

    public $timestamps = false;

    function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->table = 'cities';
    }
}