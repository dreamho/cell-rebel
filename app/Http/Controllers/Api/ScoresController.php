<?php

namespace Ranking\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Ranking\Http\Controllers\Controller;
use Ranking\Models\MobileOperator;
use Ranking\Models\Scores;
use Ranking\Models\WorldCity;
use Ranking\Models\WorldCountry;

//use Torann\GeoIP\GeoIPFacade;

class ScoresController extends Controller
{
    protected $sypex;

    public function nationalStat($code='ph')
    {
        $countryCode = Request::segment(2);
        //$location = GeoIPFacade::getLocation('92.10.63.179');
        //$location = GeoIPFacade::getLocation();

        //if(is_null($countryCode)) $code=$location['isoCode'];
        if (empty($countryCode)) {
            $code = $this->getIpCountry();
        }

        $code = strtoupper($code);
        $countries = WorldCountry::lists('name', 'code')->toArray();
        $country = WorldCountry::whereCode($code)->first();

        if (empty($country->id)) {
            $code = 'PH';
            $country = WorldCountry::whereCode($code)->first();
        }

        /* Get Country's National Scores */
        $nationStats = Scores::whereCountryId($country->id)
            ->whereScoreFor('N')
            ->orderBy('ux', 'desc')
            ->get();

        /* Get Country's Capital Scores */
        if (!is_null($country->capital_city_id)) {
            $capitalStats = Scores::whereCountryId($country->id)
                ->whereCityId($country->capital_city_id)
                ->whereScoreFor('C')
                ->orderBy('ux', 'desc')
                ->get();

            /* Get Country's Other Cities Scores */
            $cityStats = Scores::whereCountryId($country->id)
                ->where('city_id', '!=', $country->capital_city_id)
                ->whereScoreFor('C')
                ->orderBy('ux', 'desc')
                ->get();
        } else {
            $capitalStats = [];
            $cityStats = [];
        }

        $avgUXByCity = DB::table('scores')
                ->select('timeperiod', 'country_id', 'city_id', DB::raw('AVG(ux) as avg_ux'))
                ->groupBy('timeperiod', 'country_id', 'city_id', 'score_for')
                ->orderBy('avg_ux', 'desc')
                ->havingRaw('country_id = ?', [$country->id])
                ->havingRaw('city_id != ?', [$country->capital_city_id])
                ->havingRaw('score_for = ?', ['C'])
                ->get();

        $data = [
            'countries' => [
                'data'      => $countries,
                'default'   => $code
            ],
            'country'   => [
                'id'    => $country->id,
                'name'  => $country->name
            ],
            'nationalScores'    => $this->getScore($nationStats),
            'capitalScores'     => $this->getScore($capitalStats),
            'cityScores'        => $this->formatAvgScores($avgUXByCity)
            //'cityScores'        => $this->getScore($cityStats),
        ];

        return View::make("home", $data);
    }

    public function testPage()
    {
        return View::make("layouts.app2");
    }

    private function getScore($stats)
    {
        $scores = [];

        foreach ($stats as $stat) {
            $city = WorldCity::whereId($stat->city_id)->select('name')->first();
            $operator = MobileOperator::whereId($stat->mobile_operator_id)->select('name')->first();
            $score = [
                'cityId'            => $stat->city_id,
                'cityName'          => empty($city)? '': $city->name,
                'mobileOperator'    => $operator->name,
                'ux_score'          => $stat->ux,
                'color'             => $this->getColor($stat->ux, 10),
                'stats'             => [
                    ['name' => 'Browsing',  'value' => $stat->web_browsing, 'color' => $this->getColor($stat->web_browsing, 10)],
                    ['name' => 'Streaming', 'value' => $stat->video,        'color' => $this->getColor($stat->video, 10)],
                    ['name' => 'Download',  'value' => $stat->data_dl,      'color' => $this->getColor($stat->data_dl, 10)],
                    ['name' => 'Upload',    'value' => $stat->data_ul,      'color' => $this->getColor($stat->data_ul, 10)]
                ]
            ];

            array_push($scores, $score);
        }

        return $scores;
    }

    private function formatAvgScores($items)
    {
        $formattedResults = [];
        $operators = [];

        foreach ($items as $item) {
            $top3Operators = Scores::whereCountryId($item->country_id)
                ->whereCityId($item->city_id)
                ->whereTimeperiod($item->timeperiod)
                ->whereScoreFor('C')
                ->select('mobile_operator_id', 'ux')
                ->take(3)
                ->get();

            $operators = [];

            foreach ($top3Operators as $operator) {
                $topOperator = [
                    'id'    => $operator->mobile_operator_id,
                    'name'  => MobileOperator::whereId($operator->mobile_operator_id)->select('name')->first()->name,
                    'ux'    => $operator->ux
                ];
                array_push($operators, $topOperator);
            }

            $city = WorldCity::whereId($item->city_id)->select('name')->first();
            $value = [
                'cityName'      => $city->name,
                'avg_ux'        => $item->avg_ux,
                'top_operators' => $operators
            ];

            array_push($formattedResults, $value);
        }

        return $formattedResults;
    }

    private function getColor($value, $base=100)
    {
        $low = $base/3;
        $mid = $low * 2;

        if ($value <=$low) {
            return '#f56954';
        }

        if ($value >$low && $value <= $mid) {
            return '#f0ad4e';
        }

        return '#00a65a';
    }
}
