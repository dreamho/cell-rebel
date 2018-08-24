<?php

namespace Ranking\Http\Controllers;

use Illuminate\Support\Facades\Request;
use InvalidArgumentException;
use Ranking\Models\WorldCountry;
use Ranking\Score\Facades\Scores;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Torann\GeoIP\GeoIPFacade;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $sypex;
    protected $isWebview = false;
    protected $isApi = false;
    protected $defaultCountry = 'us';
    protected $countryCode = 'us';

    protected $background_measurements_every_hours = 4;
    protected $active_measurements_every_hours = 4;
    protected $timeout_file = 60;
    protected $timeout_site = 60;
    protected $timeout_youtube = 60;

    protected $youtubeTestLink = "https://www.youtube.com/watch?v=yQHmlV5uo1U";
    protected $siteTestLink = "http://www.bbc.co.uk/";

    //protected $fileTestLink = "http://www.kenrockwell.com/contax/images/g2/examples/31120037-5mb.jpg";
    protected $fileTestLink = "https://c1.staticflickr.com/3/2915/33788798302_aa0d3af79c_k.jpg";

    public function __construct()
    {
        $this->countryCode = $this->getCountryCode();
        $this->countries = $this->loadCountrySelectionData();

        if (request()->segment(1) != "api" && request()->cookie('showed_intro') !== 'shown') {
            redirect('intro')->withCookie(cookie()->forever('showed_intro', 'shown'))->send();
        }
    }

    public function sendResponse($response)
    {
    	$segment = request()->segment(1);

    	if (!is_null($segment) && $segment == "api") {
    		return $this->sendApiResponse($response);
    	}

    	return $this->sendWebResponse($response);
    }

    public function sendApiResponse($response)
    {
    	if (!isset($response['data']) || !is_array($response['data'])) {
    		return response()->json([
    			"message"	=> "No response.",
    			"code"		=> 200
    		]);
    	}

    	return response()->json($response['data']);
    }

    public function sendWebResponse($response)
    {
    	$data = ((isset($response['data'])) ? ($response['data']) : ([]));
        $data['countries'] = $this->loadCountrySelectionData();

    	if (!isset($response['view']) || !is_string($response['view']) || !is_array($data)) {
    		throw new InvalidArgumentException("View file not supplied.");
    	}

    	return view($response['view'], $data);
    }

    protected function loadCountrySelectionData()
    {
        $countryCode = $this->countryCode;
        $countries =  WorldCountry::lists('code', 'name')->toArray();

        return [
            'data'      => $countries,
            'default'   => $countryCode
        ];
    }

    protected function getCountryCode($skipRequest = false)
    {
        $defCountry = $this->defaultCountry;
        $ipCountry = $this->getIpCountry();

        if (!empty($ipCountry)) {
            $dbCountry = WorldCountry::whereCode($ipCountry)->first();

            if (!empty($dbCountry)) {
                $defCountry = strtolower($dbCountry->code);
            }
        }

        if (!$skipRequest) {
            if ($this->isWebview) {
                $result = \Illuminate\Support\Facades\Request::segment(3, $defCountry);
            } else {
                if (\Illuminate\Support\Facades\Request::segment(1, '') === 'api') {
                    $result = \Illuminate\Support\Facades\Request::segment(3, $defCountry);
                } else {
                    $result = \Illuminate\Support\Facades\Request::segment(2, $defCountry);
                }
            }
        } else {
            $result = $defCountry;
        }

        $stats = Scores::getNationalStats($result);

        if (($stats==null)||($stats->count()==0)) {
            $result = $this->defaultCountry;
        }

        return $result;
    }

    protected function IPIsPrivate($ip)
    {
        $pri_addrs = [
			'10.0.0.0|10.255.255.255', // single class A network
			'172.16.0.0|172.31.255.255', // 16 contiguous class B network
			'192.168.0.0|192.168.255.255', // 256 contiguous class C network
			'169.254.0.0|169.254.255.255', // Link-local address also refered to as Automatic Private IP Addressing
			'127.0.0.0|127.255.255.255' // localhost
		];

        $long_ip = ip2long($ip);

        if ($long_ip != -1) {
            foreach ($pri_addrs as $pri_addr) {
                list($start, $end) = explode('|', $pri_addr);

                // IF IS PRIVATE
                if ($long_ip >= ip2long($start) && $long_ip <= ip2long($end)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function getIpCountry()
    {
//        if ($this->sypex==null) {
//            $this->sypex = \App(\Ranking\Providers\Sypex\SypexGeoService::class);
//        }

        $ip = ((isset($_SERVER['REMOTE_ADDR'])) ? ($_SERVER['REMOTE_ADDR']) : (""));

        if ($this->IPIsPrivate($ip)) {
            return false;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            return false;
        }

        $ipdata = GeoIPFacade::getLocation($ip);
        /*
            array:11 [▼
              "ip" => "52.50.184.38"
              "isoCode" => "IE"
              "country" => "Ireland"
              "city" => "Dublin"
              "state" => "L"
              "postal_code" => "D02"
              "lat" => 53.3331
              "lon" => -6.2489
              "timezone" => "Europe/Dublin"
              "continent" => "EU"
              "default" => false
            ]
         */

        if (empty($ipdata)) {
            return false;
        }

        $ipCountry = $ipdata['isoCode'];

        return $ipCountry;
    }

    public function getApiCountries()
    {
        $countries = $this->loadCountrySelectionData();
        $countriesList = [];

        foreach ($countries['data'] as $name=>$code) {
            $countriesList[] = array(
                'name'=>$name,
                'code'=>$code,
            );
        }


        $data['list'] = $countriesList;
        $data['default'] = $this->defaultCountry;
        $data['detected'] = $this->getCountryCode(true);

        return $data;
    }
}
