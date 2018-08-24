<?php

namespace Ranking\Http\Controllers\Api;

use Illuminate\Http\Request;
use Ranking\Http\Requests\ReviewRequest;
use Ranking\Score\Facades\Scores;
use Ranking\Score\Facades\Reviews;
use Laracasts\Commander\CommanderTrait;
use Ranking\Http\Controllers\Controller;
use Ranking\Commands\ReviewMobileOperatorCommand;

use Jenssegers\Agent\Agent;

class ReviewsController extends Controller
{
    use CommanderTrait;

    public function reviews(Request $request)
    {
        $data = Reviews::getReviews($this->countryCode);
        $scores = Scores::getStats($this->countryCode);

        foreach ($data['mobile_operators'] as $key=>$operator) {
            $data['mobile_operators'][$key] = array_merge($operator, ['scores' => $scores['national']['experience']['operators'][$key]['scores']]);
        }

        return $this->sendResponse([
            "view"	=> "ptypev2.content.reviews",
            "data"	=> [
                "operators" => $data['mobile_operators'],
            ]
        ]);
    }


    public function reviewOperator(ReviewRequest $request)
    {
        $review = $this->execute(ReviewMobileOperatorCommand::class);

        return json_encode($review);
    }
}
