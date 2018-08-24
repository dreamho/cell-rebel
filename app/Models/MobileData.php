<?php

namespace Ranking\Models;

use Ranking\Base\BaseModel;

class MobileData extends BaseModel
{
    
    
    public $orderFld = 'id';
    
    public $orderWay = 'desc';
    
	protected $fillable = [
		'ip','country_code','city','region','isp',
		'date','os','os_version',
		'file_download_time','file_download_speed','file_ping','file_url',
		'page_load_time','page_url',
        'youtube_load_time','youtube_rebufferng_count','youtube_url',
       	'lat','lon',
       	'cell_id','mnc','mcc','cell_timestamp','connection_type','carrier','signal_strength',
 		'call_drops','call_blocks','total_calls',
  		'raw_data',		
  		'device_model', 'internet_type', 'page_load_fails', 'youtube_fails',
   		'youtube_rebuffering_time', 'youtube_quality_time', 'unique_id','file_fails',
   		'connection_durations'
    ];
    
    
    public static function getStringRequestKeys(){
    	return array('date','os','os_version',
			'file_download_time','file_download_speed','file_ping','file_url',
			'page_load_time','page_url',
	        'youtube_load_time','youtube_rebufferng_count','youtube_url',
	       	'lat','lon',
	       	'cell_id','mnc','mcc','connection_type','carrier','signal_strength',
	 		'call_drops','call_blocks','total_calls',
	 		'device_model', 'internet_type', 
   			'youtube_rebuffering_time', 'youtube_quality_time', 'unique_id',
   			'connection_durations'
		 );
    }
    
    public static function getIntRequestKeys(){
  		return array(
			'cell_id','mnc','mcc',
			'call_drops','call_blocks','total_calls',
			'page_load_fails', 'youtube_fails','file_fails'
	 	);
    }
    
    
    public function toExportArray(){
    	$array = $this->toArray();
    	$exportArray = array();
    	$exportFields = array(
			'id','date',
			'ip','country_code','city','region','isp',
			'os','os_version',
			'device_model','unique_id', 
			'lat','lon',
			'carrier','connection_type','internet_type',
			'signal_strength','cell_id',
			'mnc','mcc','cell_timestamp',
			//'call_drops','call_blocks','total_calls',
			'youtube_url', 'youtube_load_time','youtube_rebuffering_time','youtube_rebufferng_count', 'youtube_quality_time','youtube_fails',
			'file_url','file_download_time','file_download_speed','file_ping','file_fails',
			'page_url','page_load_time','page_load_fails',
			'raw_data'
			
		);
   		foreach($exportFields as $key){
   			if(key_exists($key,$array)){
   				if(($key=='signal_strength')||($key=='cell_id')){
   					$array[$key] = (strtolower($array['os'])=='android')?$array[$key]:'';
   				}
   				if(($key=='youtube_fails')||($key=='file_fails')||($key=='page_load_fails')){
   					if(!empty($array[$key])){
	   					$val = $array[$key]*1;
	   					if($val>0){
	   						$array[$key] = 1;
	   					}
   					}
   				}
   				$exportArray[$key] = $array[$key];
   			}
   		}    	
    	return $exportArray;
    }
	//
    public function __construct( array $attributes = [])
    {
        parent::__construct( $attributes );
        $this->table = 'mobile_data';
    }
}
