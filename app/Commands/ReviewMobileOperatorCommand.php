<?php namespace Ranking\Commands;

class ReviewMobileOperatorCommand
{
    public $mobile_operator_id;
    public $title;
    public $details;
    public $author;

    public function __construct( $operator_id, $reviewTitle, $reviewText, $reviewerName,$ux_rating=0)
    {
        $this->mobile_operator_id = $operator_id;
        $this->title = $reviewTitle;
        $this->details = $reviewText;
        $this->author = $reviewerName;
        $this->ux_rating = $ux_rating;
    }
}