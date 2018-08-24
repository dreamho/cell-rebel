<?php namespace Ranking\Base;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Ranking\Models\MobileOperator;
use Ranking\Observers\ModelObserver;

class BaseModel extends Eloquent{

    const LIMIT_PER_PAGE = 25;

    protected $table;
    
    public $orderFld = false;
    
	public $orderWay = false;
	
    protected static function table()
    {
        $instance = new static;
        return $instance->getTable();
    }
    
    public function toExportArray(){
    	return $this->toArray();
    }

    protected static function boot()
    {
        parent::boot();

        $observer = new ModelObserver();

        MobileOperator::observe($observer);
    }
}