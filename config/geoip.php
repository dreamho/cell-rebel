<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Service
	|--------------------------------------------------------------------------
	|
	| Current only supports 'maxmind'.
	|
	*/

	'service' => 'maxmind',

    'cache_tags' => null,

	/*
	|--------------------------------------------------------------------------
	| Services settings
	|--------------------------------------------------------------------------
	|
	| Service specific settings.
	|
	*/

	'maxmind' => array(
		'type'          => env('GEOIP_DRIVER', 'database'), // database or web_service
		'user_id'       => 10,//env('GEOIP_USER_ID'),
		'license_key'   => 123,//env('GEOIP_LICENSE_KEY'),
		'database_path' => storage_path('app/maxmind/GeoLite2-City.mmdb'),
		'update_url'    => 'https://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz',
	),

	/*
	|--------------------------------------------------------------------------
	| Default Location
	|--------------------------------------------------------------------------
	|
	| Return when a location is not found.
	|
	*/

	'default_location' => array (
		"ip"           => "127.0.0.0",
		"isoCode"      => "PH",
		"country"      => "Philippines",
		"city"         => "Manila",
		"state"        => "NA",
		"postal_code"  => "",
		"lat"          => 0,
		"lon"          => 0,
		"timezone"     => "Hongkong",
		"continent"    => "NA",
	),

);