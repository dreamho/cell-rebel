<?php

namespace Ranking\Providers\Sypex\Wrappers;

/**
 * Class GeoDataWrapper
 * @package Ranking\Providers\Sypex\Wrappers
 *
 * @property \Ranking\Providers\Sypex\Wrappers\CityWrapper $city
 * @property \Ranking\Providers\Sypex\Wrappers\RegionWrapper $region
 * @property \Ranking\Providers\Sypex\Wrappers $country
 */
class GeoDataWrapper extends BaseWrapper
{
    /**
     * @param array $data ['city' => array, 'region' => array, 'country' => array]
     */
    public function __construct(array $data)
    {
        $this->city = new CityWrapper(isset($data['city']) ? $data['city'] : []);
        $this->region = new RegionWrapper(isset($data['region']) ? $data['region'] : []);
        $this->country = new CountryWrapper(isset($data['country']) ? $data['country'] : []);
    }
}