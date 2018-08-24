<?php namespace Ranking\Score\Repositories;

use Ranking\Score\Contracts\MobileDataRepositoryContract;
use Illuminate\Support\Facades\DB;
use Ranking\Models\MobileData;

class EloquentMobileDataRepository implements MobileDataRepositoryContract
{

    public static function testIPData(){
    	return false;
    	$ip = $_SERVER['REMOTE_ADDR'];
    	$data = array();
		$data['ip'] = $ip;
		
		$ipApi = app(\Ranking\Providers\IpApi\IpApiService::class);
        $ipdata = $ipApi->get($ip);
        
        
        if(!empty($ipdata)&&!empty($ipdata['countryCode'])){
            $data['country_code'] = $ipdata['countryCode'];
            $data['isp'] = $ipdata['isp'];
            $data['city'] = $ipdata['city'];
            $data['region'] = $ipdata['region'];            
        }
        dd($data);
        
    }
    public static function persistData($data = array())
    {
        
		
		$ip = $_SERVER['REMOTE_ADDR'];
		$data['ip'] = $ip;
		
		
		$ipApi = app(\Ranking\Providers\IpApi\IpApiService::class);
        $ipdata = $ipApi->get($ip);
       
        
        if(!empty($ipdata)&&!empty($ipdata['countryCode'])){
            $data['country_code'] = $ipdata['countryCode'];
            $data['isp'] = $ipdata['isp'];
            $data['city'] = $ipdata['city'];
            $data['region'] = $ipdata['region'];            
        } else {
        	$data['country_code'] = 'unknown';
            $data['isp'] = 'unknown';
            $data['city'] = 'unknown';
            $data['region'] = 'unknown';
        }
		
		if(isset($data['page_load_time'])){
			if($data['page_load_time']*1>0){
				$data['page_load_fails'] = 0;
			}
		}
		if(isset($data['date'])&&isset($data['unique_id'])){
			$mobileData = MobileData::where('unique_id',$data['unique_id'])->where('date',$data['date'])->orderBy('id', 'DESC')->first();			
		}
		if(empty($mobileData)){
			$mobileData = new MobileData($data);
		} else {
			$mobileData->fill($data);
		}
		$mobileData->save();
		$result = array(
			'success'=>true
		);
		$result['id'] = $mobileData->id;
		
		$result['data'] = $data;
		return $result;
    }

    
}

