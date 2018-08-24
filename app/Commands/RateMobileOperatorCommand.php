<?php namespace Ranking\Commands;

class RateMobileOperatorCommand {

    /**
     * @var string
     */
    public $operator_id;

    /**
     * @var string
     */
    public $ux_rating;

    /**
     * @var string
     */
    public $recommend_rating;
    
    /**
     * @var int
     */
    public $price_rating;

    /**
     * @param string $operator_id
     * @param string $ux_rating
     * @param string $recommend_rating
     */
    public function __construct($operator_id, $ux_rating, $recommend_rating, $price_rating = 0)
    {
        //var_dump($operator_id);exit;
        $this->operator_id = $operator_id;
        $this->ux_rating = $ux_rating;
        $this->recommend_rating = $recommend_rating;
        $this->price_rating = $price_rating;
    }

}