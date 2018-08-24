<?php
namespace Ranking\Providers\Wurfl;
class WurflService{
	function getDevice(){
		//https://packagist.org/packages/mimmi20/wurfl
		try{
			$wurflFile = storage_path('app/wurfl.zip');
			$persistenceDir = storage_path('app/wurfl');
			$cacheDir = storage_path('app/wurfl_cache');
			// Create WURFL Configuration
			$wurflConfig = new \Wurfl\Configuration\InMemoryConfig();
			// Set location of the WURFL File
			$wurflConfig->wurflFile($wurflFile);
		
			//$wurflConfig->matchMode(\Wurfl\Configuration\Config::MATCH_MODE_ACCURACY);
			$wurflConfig->matchMode(\Wurfl\Configuration\Config::MATCH_MODE_PERFORMANCE);
			// Setup WURFL Persistence
			$wurflConfig->persistence(
			    'file',
			    array(\Wurfl\Configuration\Config::DIR => $persistenceDir)
			);
			
			// Setup Caching
			$wurflConfig->cache(
			    'file',
			    array(
			        \Wurfl\Configuration\Config::DIR        => $cacheDir,
			        \Wurfl\Configuration\Config::EXPIRATION => 3600000
			    )
			);
			$wurflConfig->allowReload(true);
			$cacheStorage = \Wurfl\Storage\Factory::create($wurflConfig->cache);
			$persistenceStorage = \Wurfl\Storage\Factory::create($wurflConfig->persistence);
			$wurflManager = new \Wurfl\Manager($wurflConfig, $persistenceStorage, $cacheStorage);
			$device = $wurflManager->getDeviceForHttpRequest($_SERVER);
		} catch (Exception $e){
			$device = null;
		}
		
		return $device;
	}
}