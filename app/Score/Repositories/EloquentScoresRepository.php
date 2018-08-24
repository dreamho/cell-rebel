<?php namespace Ranking\Score\Repositories;

use Illuminate\Support\Facades\Cache;
use Ranking\Models\MobileOperator;
use Ranking\Models\Ratings;
use Ranking\Models\Review;
use Ranking\Models\Scores;
use Ranking\Models\WorldCity;
use Ranking\Models\WorldCountry;
use Ranking\Score\Contracts\ScoresRepositoryContract;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class EloquentScoresRepository implements ScoresRepositoryContract
{

    const RED    = '#f56954';
    const ORANGE = '#f0ad4e';
    const GREEN  = '#00a65a';

    const UX            = 'ux';
    const PRICE            = 'price';
    const STREAMING     = 'video';
    const BROWSING      = 'web_browsing';
    const DATA_DOWNLOAD = 'data_dl';
    const DATA_UPLOAD   = 'data_ul';
    const OVERALL_SCORE = 'overall_score';

    const LEVEL_NATIONAL     = 'National';
    const LEVEL_CAPITAL      = 'Capital';
    const LEVEL_OTHER_CITIES = 'Cities';
    

//    const CAT_EXPERIENCE = 'experience';
//    const CAT_BROWSING = 'browsing';
//    const CAT_STREAMING = 'streaming';
//    const CAT_DOWNLOADS = 'downloads';
//    const CAT_UPLOADS = 'uploads';

    protected static $orderScoresBy = [
        'experience' => self::OVERALL_SCORE,
        
        'browsing'   => self::BROWSING,
        'streaming'  => self::STREAMING,
        'downloads'  => self::DATA_DOWNLOAD,
        'uploads'    => self::DATA_UPLOAD,
        
        'quality' => self::UX,
        'rating' => self::UX,
        'price' => self::PRICE,
    ];

    public static function getNationalStats( $code, $order = self::OVERALL_SCORE )
    {
        
        $country = self::getCountryByCode( $code );
        if($country==null){
            return null;
        }
//      dd($country);
//      dd(Score::class);

        return Scores::whereCountryId( $country->id )
            ->whereScoreFor( 'N' )
            ->orderBy( $order, 'desc' )
            ->get();
    }

    protected static function getCapitalStats( $code, $order = self::UX )
    {
        $country = self::getCountryByCode( $code );

        if ( is_null( $country->capital_city_id ) ) return [ ];

        return Scores::whereCountryId( $country->id )
            ->whereCityId( $country->capital_city_id )
            ->whereScoreFor( 'C' )
            ->orderBy( $order, 'desc' )
            ->get();
    }

    protected static function getCitiesStats( $code, $order = self::UX )
    {
        $country = self::getCountryByCode( $code );

        if ( is_null( $country->capital_city_id ) ) return [ ];

        return Scores::whereCountryId( $country->id )
            ->where( 'city_id', '!=', $country->capital_city_id )
            ->whereScoreFor( 'C' )
            ->orderBy( $order, 'desc' )
            ->get();
    }
   
    protected static function formatStats( $stats, $category )
    {
        
        $methodName = 'format' . ucfirst( $category ) . 'Stat';
        $score      = [ ];
        $location   = null;
     // dd($methodName;
        if ($stats instanceof \Illuminate\Database\Eloquent\Collection || is_array($stats)) {
            foreach ( $stats as $stat ) {
                $country  = self::getCountryById( $stat->country_id );
                $city     = self::getCityById( $stat->city_id );
                $operator = self::getMobileOperatorById( $stat->mobile_operator_id );

                $location = [
                    'countryName' => $country->name,
                    'countryCode' => $country->code,
                    'cityId'      => !is_null( $city ) ? $city->id : '',
                    'cityName'    => !is_null( $city ) ? $city->name : ''
                ];
                
                
                 
                $scoreEl = [
                    'mobileOperatorId' => $operator->id,
                    'mobileOperator'   => $operator->name,
                    'operatorRating'   => (int) floor( $operator->rating()->avg( 'ux_rating' ) ),
                    'operatorRatingFloat'   => (float) $operator->rating()->avg( 'ux_rating' ), 
                    'halfStar' => 0,               
                    'scores'           => self::$methodName( $stat )['stats']
                    /* Add Other Matrix here */
                ];      
                if(($scoreEl['operatorRatingFloat']-$scoreEl['operatorRating'])>0.2){
                    $scoreEl['halfStar'] = 1;
                }
                $score[]=$scoreEl;      
            }
            if(($category=='rating')&&!empty($score)){
                //usort by operatorRatingFloat            
                  usort($score, function ($a, $b) {
                       if ($a['operatorRatingFloat'] == $b['operatorRatingFloat']) {
                           return 0;
                       }        
                       return ($a['operatorRatingFloat'] < $b['operatorRatingFloat']) ? 1 : -1;
                  });
            }
        }
        //dd($score);
        return [
            'location'  => $location,
            'operators' => $score
        ];
    }

    protected static function formatExperienceStat( $stat, $base = 10 )
    {
        return [
            'stats' => [
                [ 'name' => 'Network Quality', 'value' => $stat->ux, 'color' => self::getColor( $stat->ux, $base ) ],
                [ 'name' => 'Price', 'value' => $stat->price, 'color' => self::getColor( $stat->price, $base ) ],
                [ 'name' => 'Overall Score', 'value' => $stat->overall_score, 'color' => self::getColor( $stat->overall_score, $base ) ],
                [ 'name' => 'Browsing', 'value' => $stat->web_browsing, 'color' => self::getColor( $stat->web_browsing, $base ) ],
                [ 'name' => 'Streaming', 'value' => $stat->video, 'color' => self::getColor( $stat->video, $base ) ],
                [ 'name' => 'Downloads', 'value' => $stat->data_dl, 'color' => self::getColor( $stat->data_dl, $base ) ],
                [ 'name' => 'Uploads', 'value' => $stat->data_ul, 'color' => self::getColor( $stat->data_ul, $base )],                
            ]
        ];

    }
    
    protected static function formatPriceStat( $stat, $base = 10 )
    {
        return [
            'stats' => [
                [ 'name' => 'Overall Price', 'value' => $stat->price, 'color' => self::getColor( $stat->price, $base ) ],
                [ 'name' => 'Light User Price Score', 'type' => 'PRE-PAID', 'value' => $stat->pre_paid_light_score, 'color' => self::getColor( $stat->pre_paid_light_score, 10 ),'displayValue'=>$stat->pre_paid_light_score ],
                [ 'name' => 'Medium User Price Score', 'type' => 'PRE-PAID', 'value' => $stat->pre_paid_medium_score, 'color' => self::getColor( $stat->pre_paid_medium_score, 10 ),'displayValue'=>$stat->pre_paid_medium_score ],
                [ 'name' => 'Heavy User Price Score', 'type' => 'PRE-PAID', 'value' => $stat->pre_paid_heavy_score, 'color' => self::getColor( $stat->pre_paid_heavy_score, 10 ),'displayValue'=>$stat->pre_paid_heavy_score ],
                [ 'name' => 'Light User Price Score', 'type' => 'POST-PAID', 'value' => $stat->post_paid_light_score, 'color' => self::getColor( $stat->post_paid_light_score, 10 ),'displayValue'=>$stat->post_paid_light_score ],
                [ 'name' => 'Medium User Price Score', 'type' => 'POST-PAID', 'value' => $stat->post_paid_medium_score, 'color' => self::getColor( $stat->post_paid_medium_score, 10 ),'displayValue'=>$stat->post_paid_medium_score ],
                [ 'name' => 'Heavy User Price Score', 'type' => 'POST-PAID', 'value' => $stat->post_paid_heavy_score, 'color' => self::getColor( $stat->post_paid_heavy_score, 10 ),'displayValue'=>$stat->post_paid_heavy_score ]
            ]
        ];
    }
    

    protected static function formatBrowsingStat( $stat, $base = 10 )
    {
        
        // @todo remove
//        return [
//            'stats' => [
//                [ 'name' => 'Web Browsing', 'value' => $stat->web_browsing, 'color' => self::getColor( $stat->web_browsing, $base ) ],
//                [ 'name' => 'Avg Load Time', 'value' => $stat->wb_avg_pgldtime, 'color' => self::getColor( $stat->wb_avg_pgldtime, $base ) ],
//                [ 'name' => 'Worst Load Time', 'value' => $stat->wb_wrst10p_pgldtime, 'color' => self::getColor( $stat->wb_wrst10p_pgldtime, 100 ) ],
//                [ 'name' => 'Avg Failure Rate', 'value' => $stat->wb_avg_failrate, 'color' => self::getColor( $stat->wb_avg_failrate, 100 ) ]
//            ]
//        ];
        return [
            'stats' => [
                [ 'name' => 'Web Browsing', 'value' => $stat->web_browsing, 'color' => self::getColor( $stat->web_browsing, $base ) ],
                [ 'name' => 'Page Load Speed Score', 'value' => $stat->wb_pgld_speed_score, 'color' => self::getColor( $stat->wb_pgld_speed_score, 10 ) ],
                [ 'name' => 'Page Load Success Score', 'value' => $stat->wb_pgld_sucess_score, 'color' => self::getColor( $stat->wb_pgld_sucess_score, 10 ) ]
            ]
        ];
    }
    
    protected static function formatQualityStat( $stat, $base = 10 )
    {
        
        $year = '';
        $month = '';
        $quater = '';
        $period = '';
        //mmYYYY expected
        if(!empty($stat->timeperiod)&&(strlen($stat->timeperiod)==6)&&preg_match('#^\d+$#i',$stat->timeperiod)){
            $year = intval(substr($stat->timeperiod,0,4));
            $month = intval(substr($stat->timeperiod,4,2));
            $quater = intval(floor(($month - 1) / 3) + 1);
            $period = sprintf('Q%d %d',$quater,$year);
        } else {
            $period = false;
        }
        $volume = $stat->ux_volume;
        if(!empty($volume)){
            $volume = number_format($volume,0,'.',' ');
        }
        //floor(($monthNumber - 1) / 3) + 1;
//        return [
//            'stats' => [
//                //browsing
//                [ 'name' => 'Web Browsing', 'value' => $stat->web_browsing, 'color' => self::getColor( $stat->web_browsing, $base ) ],
//                [ 'name' => 'Avg Load Time', 'value' => $stat->wb_avg_pgldtime, 'color' => self::getColor( $stat->wb_avg_pgldtime, $base ) ],
//                [ 'name' => 'Worst Load Time', 'value' => $stat->wb_wrst10p_pgldtime, 'color' => self::getColor( $stat->wb_wrst10p_pgldtime, 100 ) ],
//                [ 'name' => 'Avg Failure Rate', 'value' => $stat->wb_avg_failrate, 'color' => self::getColor( $stat->wb_avg_failrate, 100 ) ],
//                //streaming
//                [ 'name' => 'Video Streaming', 'value' => $stat->video, 'color' => self::getColor( $stat->video, $base ) ],
//                [ 'name' => 'Avg Start Time', 'value' => $stat->video_avg_starttime, 'color' => self::getColor( $stat->video_avg_starttime, $base ) ],
//                [ 'name' => 'Worst Start Time', 'value' => $stat->video_wrst10p_starttime, 'color' => self::getColor( $stat->video_wrst10p_starttime, 100 ) ],
//                [ 'name' => 'Avg Rebuffering', 'value' => $stat->video_avg_rebuffering, 'color' => self::getColor( $stat->video_avg_rebuffering, 100 ) ],
//                [ 'name' => 'Sample Size', 'value' => $volume, 'color' => self::getColor($base)],
//                [ 'name' => 'Time Period', 'value' => $period, 'color' => self::getColor($base)],
//            ]
//        ];


        return [
            'stats' => [
                //browsing
                [ 'name' => 'Web Browsing', 'value' => $stat->web_browsing, 'color' => self::getColor( $stat->web_browsing, $base ) ],
                [ 'name' => 'Page Load Speed Score', 'value' => $stat->wb_pgld_speed_score, 'color' => self::getColor( $stat->wb_pgld_speed_score, 10 ) ],
                [ 'name' => 'Page Load Success Score', 'value' => $stat->wb_pgld_success_score, 'color' => self::getColor( $stat->wb_pgld_success_score, 10 ) ],
                //streaming
                [ 'name' => 'Video Streaming', 'value' => $stat->video, 'color' => self::getColor( $stat->video, $base ) ],
                [ 'name' => 'Video Load Speed Score', 'value' => $stat->video_pgld_speed_score, 'color' => self::getColor( $stat->video_pgld_speed_score, 10 ) ],
                [ 'name' => 'Video Re-Buffering Score', 'value' => $stat->video_pgld_success_score, 'color' => self::getColor( $stat->video_pgld_success_score, 10 ) ],
                // Frame
                [ 'name' => 'Sample Size', 'value' => $volume, 'color' => self::getColor($base)],
                [ 'name' => 'Time Period', 'value' => $period, 'color' => self::getColor($base)],
            ]
        ];
    }
    
    protected static function formatRatingStat( $stat, $base = 10 )
    {
        $dataRaw = DB::table('ratings')
                 ->select('ux_rating', DB::raw('count(*) as ux_rating_count'))
                 ->where('mobile_operator_id',$stat->mobile_operator_id)
                 ->groupBy('ux_rating')
                 ->get();
        $data = array();
        foreach($dataRaw as $rec){
            $data[intval($rec->ux_rating)] = intval($rec->ux_rating_count);
        }
        $total = 0;
        $maxCount = 0;
        for($i=1;$i<=5;$i++){
            if(!isset($data[$i])){
                $data[$i] = 0;
            } else {
                $total+=$data[$i];
                if($data[$i]>$maxCount){
                    $maxCount = $data[$i];
                }
            }
        }
        
        
         for($i=1;$i<=5;$i++){
            $data[$i] = ($total>0)?100*$data[$i]/$total:0;
         }
        return [
            'stats' => [
                //ratings
                [ 'name' => 'Excellent', 'value' => $data[5]/10, 'color' => self::GREEN,'displayValue'=>str_replace('.0','',number_format($data[5],1,'.','')).'%'],
                [ 'name' => 'Very good', 'value' => $data[4]/10, 'color' => self::GREEN,'displayValue'=>str_replace('.0','',number_format($data[4],1,'.','')).'%' ],
                [ 'name' => 'Average', 'value' => $data[3]/10, 'color' => self::GREEN,'displayValue'=>str_replace('.0','',number_format($data[3],1,'.','')).'%' ],
                [ 'name' => 'Poor', 'value' => $data[2]/10, 'color' => self::GREEN,'displayValue'=>str_replace('.0','',number_format($data[2],1,'.','')).'%' ],
                [ 'name' => 'Terrible', 'value' => $data[1]/10, 'color' => self::GREEN,'displayValue'=>str_replace('.0','',number_format($data[1],1,'.','')).'%' ],
               
            ]
        ];
    }
    
    protected static function formatStreamingStat( $stat, $base = 10 )
    {
        return [
            'stats' => [
                [ 'name' => 'Video Streaming', 'value' => $stat->video, 'color' => self::getColor( $stat->video, $base ) ],
                [ 'name' => 'Avg Start Time', 'value' => $stat->video_avg_starttime, 'color' => self::getColor( $stat->video_avg_starttime, $base ) ],
                [ 'name' => 'Worst Start Time', 'value' => $stat->video_wrst10p_starttime, 'color' => self::getColor( $stat->video_wrst10p_starttime, 100 ) ],
                [ 'name' => 'Avg Rebuffering', 'value' => $stat->video_avg_rebuffering, 'color' => self::getColor( $stat->video_avg_rebuffering, 100 ) ]
            ]
        ];
    }

    protected static function formatDownloadsStat( $stat, $base = 10 )
    {
        return [
            'stats' => [
                [ 'name' => 'Data Download', 'value' => $stat->data_dl, 'color' => self::getColor( $stat->data_dl, $base ) ],
                [ 'name' => 'Avg Speed', 'value' => $stat->data_dl_avg_speed, 'color' => self::getColor( $stat->data_dl_avg_speed, $base ) ],
                [ 'name' => 'Worst Speed', 'value' => $stat->data_dl_wrst10p_speed, 'color' => self::getColor( $stat->data_dl_wrst10p_speed, $base ) ],
            ]
        ];
    }

    protected static function formatUploadsStat( $stat, $base = 10 )
    {
        return [
            'stats' => [
                [ 'name' => 'Data Upload', 'value' => $stat->data_ul, 'color' => self::getColor( $stat->data_ul, $base ) ],
                [ 'name' => 'Avg Speed', 'value' => $stat->data_ud_avg_speed, 'color' => self::getColor( $stat->data_ud_avg_speed, $base ) ],
                [ 'name' => 'Worst Speed', 'value' => $stat->data_ud_wrst10p_speed, 'color' => self::getColor( $stat->data_ud_wrst10p_speed, $base ) ],
            ]
        ];
    }

    protected static function getCountryByCode( $code )
    {
        return WorldCountry::whereCode( strtoupper( $code ) )->first();
    }

    protected static function getCountryById( $id )
    {
        return WorldCountry::whereId( $id )->first();
    }

    protected static function getCityById( $id )
    {
        return WorldCity::whereId( $id )->first();
    }

    protected static function getMobileOperatorById( $id )
    {
        return MobileOperator::whereId( $id )->first();
    }

    protected static function formatScoreColor( $score, $name, $base )
    {
        return [
            'name'  => $name,
            'value' => $score,
            'color' => self::getColor( $score, $base )
        ];
    }

    protected static function getColor( $value, $base = 100 )
    {
        $low = $base / 3;
        $mid = $low * 2;

        if ( $value <= $low ) return self::RED;
        if ( $value > $low && $value <= $mid ) return self::ORANGE;

        return self::GREEN;
    }

    protected static function hasCapitalCity( $code )
    {
        $country = WorldCountry::whereCode( strtoupper( $code ) )->first();

        return !is_null( $country->capital_city_id );
    }

    protected static function hasOtherCity( $code )
    {
        $countryCode = strtoupper( $code );

        return WorldCity::whereCode( $countryCode )->count() > 0;
    }

    public static function orderScoresBy( $key )
    {
        return self::$orderScoresBy[ $key ];
    }

    public static function getStats( $code )
    {
        $code = strtoupper( $code );

//        $result = Cache::tags(
//            'scores'
//        )->remember( 'score_' . $code, 60 * 24, function () use ( $code ) {
////          $capitalScores = [ ];
////          $citiesScores = [];
//
//            $nationalScores = self::formatResultFor( self::LEVEL_NATIONAL, $code );
////          dd($nationalScores);
////          if ( self::hasCapitalCity( $code ) ) $capitalScores = self::formatResultFor( self::LEVEL_CAPITAL, $code );
//
////          if(self::hasOtherCity($code)) $citiesScores = self::formatResultFor(self::LEVEL_OTHER_CITIES, $code);
//
//            return [
//                'national' => $nationalScores,
////              'capital'  => $capitalScores
////              'cities'        => $citiesScores
//            ];
//        } );

        $result = [
            'national' => self::formatResultFor( self::LEVEL_NATIONAL, $code )
        ];

        return array_filter( $result );
    }

    public static function getAllStats(  )
    {
        $result = [];
        $countryCodes = WorldCountry::lists('code')->toArray();
        foreach ($countryCodes as $code) {
            $result[$code] = self::getStats( $code );
        }

        return $result;
    }

    public static function rateOperator( $command )
    {
        
        $maxReviewPerOperator = 3;
        $timeRange = 24;//hours
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $nowDate = date('Y-m-d H:i:s');
        $startDate = date('Y-m-d H:i:s',strtotime(sprintf('%d hours ago',$timeRange)));
        
        $countDataRaw = DB::table('ratings')
                 ->select(DB::raw('count(*) as tryouts_count'))
                 ->where('mobile_operator_id',$command->operator_id)
                 ->where('created_at','>=',$startDate)
                 ->where('created_at','<=',$nowDate)
                 ->where('ip',$ip)
                 ->first();
        $tryouts = $countDataRaw->tryouts_count;
        $tryoutsLeft = $maxReviewPerOperator-$tryouts;
        if($tryoutsLeft<=0){
            //ban
            header('HTTP/1.1 429 Too Many Requests', false, 429);
            exit;
        }
        
        
        
        $ipApi = app(\Ranking\Providers\IpApi\IpApiService::class);
        $ipdata = $ipApi->get($ip);
        $country = '';
        $isp = '';
        $city = '';
        $region = '';
        $organisation = '';
        $timezone = '';
        $zip = '';
        $lat = 0;
        $lon = 0;
        if(!empty($ipdata)&&!empty($ipdata['countryCode'])){
            $country = $ipdata['countryCode'];
            $isp = $ipdata['isp'];
            $city = $ipdata['city'];
            $region = $ipdata['region'];
            $organisation = $ipdata['org'];
            $timezone = $ipdata['timezone'];
            $zip = $ipdata['zip'];
            $lat = $ipdata['lat']*1;
            $lon = $ipdata['lon']*1;
        }
        $agent = new Agent();
        $browser = $agent->browser();
        $version = $agent->version($browser);
        $platform = $agent->platform();
        $platformversion = $agent->version($platform);
        if($platform=='Windows'){
            $platformversion = 'NT'.$platformversion;
        }
        
        $useragent = $_SERVER['HTTP_USER_AGENT'];	  
        
        
        
		
		
        $form_factor = '';
	    $is_wireless_device = '';	    
	    $pointing_method = '';
	    $brand_name = '';
	    $model_name = '';
		
		$deviceData = array();
        if(!empty($_POST['device_data'])){
        	try{
        		$deviceData = json_decode($_POST['device_data'],true);
        	} catch(Exception $e){
        		$deviceData = array();
        	}
        }
        
        if(!empty($deviceData)){
        	$form_factor = !empty($deviceData['form_factor'])?$deviceData['form_factor']:'';
		    $is_wireless_device = isset($deviceData['is_wireless_device'])?$deviceData['is_wireless_device']:'';	    
		    $pointing_method = !empty($deviceData['pointing_method'])?$deviceData['pointing_method']:'';
		    $brand_name = !empty($deviceData['brand_name'])?$deviceData['brand_name']:'';
		    $model_name = !empty($deviceData['model_name'])?$deviceData['model_name']:'';
        }
		    
        
        
        
        $priceRating = 0;
		if(isset($command->price_rating)&&($command->price_rating>0)){
			$priceRating = $command->price_rating;
		}
        
        
        $rating = new Ratings(
            [
                'mobile_operator_id' => $command->operator_id,
                'ux_rating'          => $command->ux_rating,
                'recommend_rating'   => $command->recommend_rating,
                'price_rating'     => $priceRating,
                'ip'               => $ip,
                'browser'          => $browser,
                'isp'              => $isp,
                'country_code'     => $country,
                'browser_version'  => $version,
				'os'			   => $platform,
				'os_version'	   => $platformversion,
				'city'			   => $city,
				'region'           => $region,
				'organisation'     => $organisation,
				'timezone'		   => $timezone,
				'zip'		       => $zip,
				'lat'		   	   => $lat,
				'lon'		   	   => $lon,	
				'form_factor'	   => $form_factor,
				'is_wireless_device' => $is_wireless_device,
				'pointing_method'	=> $pointing_method,
				'brand_name'		=> $brand_name,
				'model_name'		=> $model_name,
				'useragent'			=> $useragent
            ]
        );
        $rating->save();

//        Cache::tags( 'scores' )->flush();
        $tryoutsLeft--;
        return [
            'id'               => $rating->id,
            'operator_id'      => $rating->mobile_operator_id,
            'operator_name'    => ucwords( strtolower( $rating->operator->name ) ),
            'ux_rating'        => $rating->ux_rating,
            'recommend_rating' => $rating->recommend_rating,
            'price_rating'     => $priceRating,
            'tryouts_left'     => $tryoutsLeft
             
        ];
    }

    private static function formatResultFor( $level = self::LEVEL_NATIONAL, $code )
    {
        $methodName = 'get' . $level . 'Stats';
        $result     = [ ];
      
        foreach ( self::$orderScoresBy as $key => $value ) {
            $result[ $key ] = self::formatStats( self::$methodName( $code, self::orderScoresBy( $key ) ), $key );
        }

        return $result;
    }
}

/*
 * Operators By UX
 * Operators By WebBrowsing
 * Operators By Streaming(video)
 * Operators By Data Download
 * Operators By Data Upload
*/