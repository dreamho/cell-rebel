<?php namespace Ranking\Models;

use Ranking\Base\BaseModel;

class WorldCountry extends BaseModel {

    public $timestamps = false;

    function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->table = 'countries';
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @param bool $ordered
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQuery($ordered = true)
    {
        $query = parent::newQuery();

        if (empty($ordered)) {
            return $query;
        }

        return $query->orderBy('name', 'asc');
    }
}