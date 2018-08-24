<?php

namespace Ranking\Http\Controllers\Api;

use Ranking\Http\Requests\RankRequest;
use Illuminate\Support\Facades\Input;
use Ranking\Commands\RateMobileOperatorCommand;
use Laracasts\Commander\CommanderTrait;
use Ranking\Http\Controllers\Controller;
use Ranking\Models\WorldCountry;
use Ranking\Score\Facades\Scores;
use Illuminate\Http\Request;
use Ranking\Score\Repositories\EloquentMobileDataRepository;

use Jenssegers\Agent\Agent;

class RanksController extends Controller
{
    use CommanderTrait;

    protected $countryCode;

    protected $levels = [
        [
            'id' => 'experience',  'caption' => 'Overall Score', 'icon' => 'fa fa-tachometer',
            'descr'=>'The overall score gives a combined view of the network quality,
                        the user satisfaction and the prices of the mobile operators.
                        Billions of samples  of  real web downloads and video plays have been analyzed in order to determine the quality  of service that the mobile operators are providing.
                        This, together with the user satisfaction as rated by real users and price information builds up the overall score for each operator.'
        ],
        [
            'id' => 'quality',     'caption' => 'Network Quality',    'icon' => 'fa fa-bar-chart',
            'descr'=>'This page shows a ranking of the mobile operators based on extensive data analysis of the quality of service that the mobile operators are providing. The data we analyze come from billions of real user transactions from content providers and mobile apps and reflect the true user experience for mobile users unlike many other methods that are based on user initiated tests or drive tests. It measures the main services that users are doing with their mobile phones, which is accessing web content and watching videos.'
        ],
        [
            'id' => 'rating',      'caption' => 'User Ratings',    'icon' => 'fa fa-star',
            'descr'=>'This page describes which mobile operator that the users are most happy with. Do you agree?
                    Take the opportunity to give your  rating of your mobile operator as well and contribute to give others a better understanding of the mobile services in your country!'
            ],
        [
            'id' => 'price',        'caption' => 'Price',    'icon' => 'fa fa-usd',
            'descr'=>'Find out which mobile operator that offers the best price in your country! The mobile operators typically set up price plans that make it difficult to compare them to other operators’ price plans. Cell Rebel is doing extensive analysis of the different price plans of all operators that help you as a subscriber to understand which operator that is cheaper. The overall price score gives an indication of which operator that offers the best prices across their whole offerings. We also present price scores for different levels of packages since some operators are more cost competitive for heavy users while other operators might have cheaper offers for light users.'
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        $this->initMobileSettings();
    }

    public function ranks()
    {
        $data = Scores::getStats($this->countryCode);

        return $this->sendResponse([

            "view"  => "ptypev2.content.ranks",
            "data"  => [
                "scoreCategories"   => $this->levels,
                "ranks"             => $data
            ]
        ]);
    }

    public function ranksAll()
    {
        $data = Scores::getAllStats();

        return $this->sendResponse([

            "view"  => "ptypev2.content.ranks",
            "data"  => [
                "scoreCategories"   => $this->levels,
                "ranks"             => $data
            ]
        ]);
    }

    public function nationalExperience()
    {
        $data = Scores::getStats($this->countryCode);

        return $this->sendResponse([

            "view"  => "ptypev2.content.ranks",
            "data"  => [
                "ranks" => $data['national']['experience']
            ]
        ]);
    }

    public function nationalQuality()
    {
        $data = Scores::getStats($this->countryCode);

        return $this->sendResponse([

            "view"  => "ptypev2.content.ranks",
            "data"  => [
                "ranks" => $data['national']['quality']
            ]
        ]);
    }

    public function nationalRanking()
    {
        $data = Scores::getStats($this->countryCode);

        return $this->sendResponse([

            "view"  => "ptypev2.content.ranks",
            "data"  => [
                "ranks" => $data['national']['rating']
            ]
        ]);
    }

    public function nationalPricing()
    {
        $data = Scores::getStats($this->countryCode);

        return $this->sendResponse([

            "view"  => "ptypev2.content.ranks",
            "data"  => [
                "ranks" => $data['national']['price']
            ]
        ]);
    }

    private function initMobileSettings()
    {
        $settings = [];
        $req = request();
        $dbPath = database_path();
        $jsonFilePath = $dbPath.DIRECTORY_SEPARATOR.'mobile_settings.json';

        if (file_exists($jsonFilePath)) {
            try {
                $settings = file_get_contents($jsonFilePath);
                $settings = json_decode($settings, true);
            } catch (Exception $e) {
                $settings = [];
            }
        }

        $this->fileTestLink = $settings['fileTestLink'];
        $this->siteTestLink = $settings['siteTestLink'];
        $this->youtubeTestLink = $settings['youtubeTestLink'];
        $this->background_measurements_every_hours = $settings['backgroundMeasurementsEveryHours'];
        $this->active_measurements_every_hours = $settings['activeMeasurementsEveryHours'];

        $this->timeout_file = intval($settings['timeout_file']);
        $this->timeout_site = intval($settings['timeout_site']);
        $this->timeout_youtube = intval($settings['timeout_youtube']);
    }

    public function rateOperator(RankRequest $request)
    {
        $rating = $this->execute(RateMobileOperatorCommand::class);

        return json_encode($rating);
    }

    public function tabstexts()
    {
        return $this->sendResponse([
            "data"  => [
                "texts" => $this->levels
            ]
        ]);
    }
}
