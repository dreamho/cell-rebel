<?php
namespace Ranking\Providers\Sypex;
include_once base_path('vendor/sypex/SxGeo.php');
use sypex;

class SypexGeoService
{
	private static $sxGeo;

	public function __construct($dbFile = null)
	{
		
        $dbFile = storage_path('app/SxGeoCity.dat');

		static::$sxGeo = new \SxGeo($dbFile);
	}

	public static function get($ip)
	{
		$data = static::$sxGeo->getCityFull($ip);

		if (!$data || !is_array($data)) {
			return false;
		}

		$geoData = new Wrappers\GeoDataWrapper($data);

		return $geoData;
	}
}
