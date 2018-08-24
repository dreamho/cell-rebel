<?php namespace Ranking\Models;

use Ranking\Base\BaseModel;

class Ratings extends BaseModel
{
    protected $fillable = ['mobile_operator_id', 'ux_rating', 'recommend_rating', 'dataplan','price_rating','ip','isp','browser','country_code','browser_version','os','os_version',
							'city', 'region', 'organisation', 'timezone', 'zip', 'lat', 'lon',
							'form_factor','is_wireless_device','pointing_method','brand_name','model_name','useragent'
	];

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->table = 'ratings';
    }
    
    public function operator()
    {
        return $this->belongsTo(MobileOperator::class, 'mobile_operator_id');
    }
}