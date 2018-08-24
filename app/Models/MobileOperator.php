<?php namespace Ranking\Models;

use Ranking\Base\BaseModel;

class MobileOperator extends BaseModel{

    public $timestamps = false;

    function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->table = 'mobile_operators';
    }

    public function rating()
    {
        return $this->hasMany(Ratings::class, 'mobile_operator_id');
    }

    
}