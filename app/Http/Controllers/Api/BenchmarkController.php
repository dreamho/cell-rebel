<?php

namespace Ranking\Http\Controllers\Api;

use Illuminate\Http\Request;
use Ranking\Http\Controllers\Controller;
use Ranking\Score\Repositories\EloquentMobileDataRepository;

use Jenssegers\Agent\Agent;

class BenchmarkController extends Controller
{
    public function benchmark()
    {
        $countries = $this->loadCountrySelectionData();
        $test_file_size = -1;

        $ch = curl_init($this->fileTestLink);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $data = curl_exec($ch);
        curl_close($ch);

        if (preg_match("/Content-Length: (\d+)/", $data, $matches)) {
            // Contains file size in bytes
            $test_file_size = (int)$matches[1];
        }

        $youtubeVideoId = $this->youtubeTestLink;
        $youtubeVideoId = str_replace("https://www.youtube.com/watch?v=", "", $youtubeVideoId);

        $siteTestLink = $this->siteTestLink;
        $siteTestLink = current(explode(",", $siteTestLink));

        return $this->sendResponse([
            "view"  => "ptypev2.content.benchmark",
            "data"  => [
                "test_file_link"    => $this->fileTestLink,
                "test_file_size"    => $test_file_size,
                "test_site_link"    => $siteTestLink,
                "youtube_video_id"  => $youtubeVideoId
            ]
        ]);
    }

    public function reportMobileDataTest()
    {
        EloquentMobileDataRepository::testIPData();
    }

    public function reportMobileData(Request $request)
    {
        header('Content-Type: application/json');
        $input = $request->all();

        $data = array();
        $inputKeysString = \Ranking\Models\MobileData::getStringRequestKeys();
        $inputKeysInt = \Ranking\Models\MobileData::getIntRequestKeys();

        if (empty($input)&&!empty($_POST)) {
            $input = $_POST;
        }
        if (!empty($input)) {
            $rawData = json_encode($input);
            $data['raw_data'] = $rawData;
        } else {
            return array('success'=>false);
        }
        if ($request->input('date')!=null) {
            $data['date'] = $request->input('date');
        } else {
            $data['date'] = date('Y-m-d H:i:s');
        }
        foreach ($inputKeysString as $k) {
            if ($request->input($k)!==null) {
                $data[$k] = $request->input($k);
            } else {
                $data[$k] = '';
            }
        }
        foreach ($inputKeysInt as $k) {
            if ($request->input($k)!==null) {
                $v = $request->input($k);
                if (is_numeric($v)) {
                    $data[$k] = intval($v);
                }
            } else {
                $data[$k] = -1;
            }
        }
        if ($data['signal_strength']==-1) {
            $data['signal_strength'] = '';
        }

        $result = EloquentMobileDataRepository::persistData($data);


        return $this->sendResponse([
            "data"  => [
                "result" => $result
            ]
        ]);
    }

	public function persistBenchmark(Request $request)
    {
        $input = $request->all();

        $data = array();

        $inputKeysString = \Ranking\Models\MobileData::getStringRequestKeys();
        $inputKeysInt = \Ranking\Models\MobileData::getIntRequestKeys();

        foreach ($inputKeysString as $k) {
            $data[$k] = '';
        }
        foreach ($inputKeysInt as $k) {
            $data[$k] = -1;
        }
        $requiredKeys = array(
            'file_speed','site_load','youtube_buffering_time','youtube_buffering_count','youtube_quality','file_fails','unique_id'
        );

        foreach ($requiredKeys as $k) {
            if (!isset($input[$k])) {
                return array('success'=>false);
            }
        }

        $data['os'] = 'site_benchmark';

        $data['file_download_speed'] = $input['file_speed'];
        $data['file_url'] = $this->fileTestLink;

        $data['page_load_time'] = $input['site_load'];
        $data['page_url'] = $this->siteTestLink;

        $data['youtube_rebuffering_time'] = $input['youtube_buffering_time'];
        $data['youtube_rebufferng_count'] = $input['youtube_buffering_count'];
        $data['youtube_quality_time'] = $data['youtube_extra'] = json_encode($input['youtube_quality']);

        $data['youtube_url'] = $this->youtubeTestLink;
        $data['unique_id'] = $input['unique_id'];
        $data['file_fails'] = $input['file_fails'];
        $data['file_download_time'] = $input['file_download_time'];

        $data['date'] = date('Y-m-dTH:i:s.uZ');

        $data['raw_data'] = json_encode($input);

        $result = EloquentMobileDataRepository::persistData($data);

        return $this->sendResponse([
            "data"  => [
                "result" => $result
            ]
        ]);
    }
}
