<?php namespace Ranking\Score\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Ranking\Models\Review;
use Ranking\Models\Ratings;
use Ranking\Score\Contracts\ReviewRepositoryContract;
use Jenssegers\Agent\Agent;


class EloquentReviewRepository implements ReviewRepositoryContract
{
    
   
    protected static function mobileOperatorByCountryCode( $code )
    {
//        $result = Cache::tags( 'mobile_operators' )
//            ->remember( $code . '_operators', 60 * 24, function () use ( $code ) {
                return DB::table( 'mobile_operators' )
                    ->select( 'mobile_operators.*' )
                    ->leftJoin( 'ratings', 'mobile_operators.id', '=', 'ratings.mobile_operator_id' )
                    //->addSelect( DB::raw( 'ROUND(AVG(ratings.ux_rating)::numeric,0) as rating' ) )
                    //->addSelect( DB::raw( 'ROUND(AVG(ratings.recommend_rating)::numeric,0) as recommend' ) )
                    ->addSelect( DB::raw( 'AVG(ratings.ux_rating)::float as rating_float' ) )
                    ->addSelect( DB::raw( 'AVG(ratings.recommend_rating)::float as recommend_float' ) )
                    ->groupBy( 'mobile_operators.id' )
                    ->where( 'mobile_operators.country_code', '=', $code )
                    ->get();
//            } );

//        return $result;
    }
    
    protected static function getOperatorUXRatingsCounters($id){
//    	$result = Cache::tags( 'scores' )
//            ->remember( $id . 'getOperatorUXRatingsCounters_operators', 60 * 24, function () use ( $id ) {
		    	$dataRaw = DB::table('ratings')
		                 ->select('ux_rating', DB::raw('count(*) as ux_rating_count'))
		                 ->where('mobile_operator_id',$id)
		                 ->where('ux_rating', '>', 0)
		                 ->groupBy('ux_rating')
		                 ->get();
		        $data = array();
		        foreach($dataRaw as $rec){
		            $data[intval($rec->ux_rating)] = intval($rec->ux_rating_count);
		        }
		        for($i=1;$i<=5;$i++){
		            if(!isset($data[$i])){
		                $data[$i] = 0;
		            }
		        }
		        ksort($data);
		        return $data;
//       });
//       return $result;
    }
    
    protected static function getOperatorRecommendRatingsCounters($id){
//    	$result = Cache::tags( 'scores' )
//            ->remember( $id . 'getOperatorRecommendRatingsCounters', 60 * 24, function () use ( $id ) {
	    	$dataRaw = DB::table('ratings')
	                 ->select('recommend_rating', DB::raw('count(*) as recommend_rating_count'))
	                 ->where('mobile_operator_id',$id)
	                 ->where('recommend_rating', '>', 0)
	                 ->groupBy('recommend_rating')
	                 ->get();
	        $data = array();
	        foreach($dataRaw as $rec){
	            $data[intval($rec->recommend_rating)] = intval($rec->recommend_rating_count);
	        }
	        for($i=1;$i<=11;$i++){
	            if(!isset($data[$i])){
	                $data[$i] = 0;
	            }
	        }
	        ksort($data);
	        return $data;
//       });
//       return $result;
    }
    

    protected static function reviewsByOperatorId( $id)
    {
        
        $perPage = 5;
        
        $collection = Review::whereMobileOperatorId( $id )
            ->select( 'title', 'details', 'author', 'created_at','ux_rating' )
            ->orderBy('created_at', 'desc')->paginate($perPage);
        //$reviews    = $collection->get();
        //dd($collection);
        
        
        
        
        $reviews = $collection->items();
        //dd($reviews);
        foreach ( $reviews as $review ) {
        	//$review['ux_rating'] = rand(0,5);
            $review = array_add( $review, 'diff', $review->created_at->diffForHumans() );
            $review = array_add( $review, 'added', date_format( $review->created_at, 'l jS F Y \a\t g:ia' ) );
        }
		//dd($reviews);
        return [
            'total' => $collection->total(),
            'links'=>$collection->links(),
            'data'  => $reviews//->toArray()
        ];
    }


    public static function getReviews( $code)
    {
        $code = strtoupper( $code );

        $operators = self::mobileOperatorByCountryCode( $code );

        $operator_reviews = [ ];

        foreach ( $operators as $operator ) {
        	        	
            $reviews = [ 'reviews' => self::reviewsByOperatorId( $operator->id ) ];
			$element = array_merge( json_decode( json_encode( $operator ), true ), $reviews );
			$element['uxRatings'] = self::getOperatorUXRatingsCounters( $operator->id );
			$element['uxRatingsStr'] = join(',',$element['uxRatings'] );
        	$element['recommendRatings'] = self::getOperatorRecommendRatingsCounters( $operator->id );
       		$element['recommendRatingsStr'] = join(',',$element['recommendRatings'] );
			$element['rating_float'] = $element['rating_float']*1;
			$element['recommend_float'] = $element['recommend_float']*1;
			$element['rating'] = floor($element['rating_float']);
			$element['recommend'] = floor($element['recommend_float']);
			if(($element['rating_float']-$element['rating'])>0.2){
                $element['rating_halfstar'] = 1;
            } else {
            	$element['rating_halfstar'] = 0;
            }
            if(($element['recommend_float']-$element['recommend'])>0.2){
                $element['recommend_halfstar'] = 1;
            } else {
            	$element['recommend_halfstar'] = 0;
            }
            
			//dd($element);
            $operator_reviews[] = $element; 
        }
		//dd($operator_reviews);
        return [
            'mobile_operators' => $operator_reviews
        ];
    }

    public static function reviewOperator( $command)
    {
        
        $maxReviewPerOperator = 3;
        $timeRange = 24;//hours
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $nowDate = date('Y-m-d H:i:s');
        $startDate = date('Y-m-d H:i:s',strtotime(sprintf('%d hours ago',$timeRange)));
        
        $countDataRaw = DB::table('reviews')
                 ->select(DB::raw('count(*) as tryouts_count'))
                 ->where('mobile_operator_id',$command->mobile_operator_id)
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
        
        
        $review = new Review(
            [
                'mobile_operator_id' => $command->mobile_operator_id,
                'title' => $command->title,
                'details' => $command->details,
                'author' => $command->author,
                'ux_rating' => $command->ux_rating,
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
        $review->save();
        $tryoutsLeft--;
        
        
        if(!empty($command->ux_rating)){
        	//if was rated also
        	$rating = new Ratings(
	            [
	                'mobile_operator_id' => $command->mobile_operator_id,
	                'ux_rating'          => $command->ux_rating,
	                'recommend_rating'   => 0,
	                'dataplan'   => 0,
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
        	Cache::tags( 'scores' )->flush();
        }
        
        
        
        return [
            'id' => $review->id,
            'operatorId' => $review->mobile_operator_id,
            'tryouts_left'     => $tryoutsLeft
        ];
    }
}