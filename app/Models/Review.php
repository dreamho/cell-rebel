<?php namespace Ranking\Models;

use Ranking\Base\BaseModel;

class Review extends BaseModel
{
    protected $fillable = ['mobile_operator_id', 'title', 'details', 'author','ip','isp','browser','country_code','ux_rating','browser_version','os','os_version',
							'city', 'region', 'organisation', 'timezone', 'zip', 'lat', 'lon',
							'form_factor','is_wireless_device','pointing_method','brand_name','model_name','useragent'
    ];

    public function __construct( array $attributes = [])
    {
        parent::__construct( $attributes );
        $this->table = 'reviews';
    }

    public function operator()
    {
        return $this->belongsTo(MobileOperator::class, 'mobile_operator_id');
    }
}