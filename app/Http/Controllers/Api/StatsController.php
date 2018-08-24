<?php

namespace Ranking\Http\Controllers\Api;

use Ranking\Http\Controllers\Controller;

class StatsController extends Controller
{
    public function getDevice()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        //Detect special conditions devices
        $iPod    = stripos($useragent, "iPod");
        $iPhone  = stripos($useragent, "iPhone");
        $iPad    = stripos($useragent, "iPad");
        $Android = stripos($useragent, "Android");
        $webOS   = stripos($useragent, "webOS");

        $form_factor = '';
        $is_wireless_device = '';
        $pointing_method = '';
        $brand_name = '';
        $model_name = '';

        if (!$iPad && !$iPod && !$iPhone) {
            $device = null;

            try {
                $wu = app(\Ranking\Providers\Wurfl\WurflService::class);
                $device = $wu->getDevice();
            } catch (Exception $e) {
                $device = null;
            }

            if (!empty($device)) {
                try {
                    $vcaps = $device->getAllVirtualCapabilities();
                } catch (Exception $e) {
                    $vcaps = array();
                }
                try {
                    $caps = $device->getAllCapabilities();
                } catch (Exception $e) {
                    $caps = array();
                }
            }

            if (!empty($vcaps)) {
                $form_factor = $vcaps['form_factor'];
            }

            if (!empty($caps)) {
                $is_wireless_device = ($caps['is_wireless_device']=='true')?1:0;
                $pointing_method = $caps['pointing_method'];
                $brand_name = $caps['brand_name'];
                $model_name = $caps['brand_name'];
            }
        } else {
            $is_wireless_device = 1;
            $pointing_method = 'touchscreen';
            $brand_name = 'Apple';

            if ($iPod) {
                $form_factor = 'player';
                $model_name = 'ipod';
            } elseif ($iPhone) {
                $form_factor = 'smartphone';
                $model_name = 'iphone';
            } elseif ($iPad) {
                $form_factor = 'tablet';
                $model_name = 'ipad';
            }
        }

        $result = array(
            'form_factor'=>$form_factor,
            'model_name'=>$model_name,
            'brand_name'=>$brand_name,
            'pointing_method'=>$pointing_method,
            'is_wireless_device'=>$is_wireless_device
        );

        echo json_encode($result);
        exit;
    }
}
