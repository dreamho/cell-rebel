<?php

namespace Ranking\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use Setting;

class Cedexis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cedexis {customDate?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cedexis import';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
		$this->comment(PHP_EOL . 'Start import' . PHP_EOL);

        $countries = Setting::get('CedexisCountries');
        
        if (empty($countries))
        {
            $this->comment('Empty country list!' . PHP_EOL);
            return false;
        }
        
        
        $day = date('i');
        
        $day = 1;

        $date = date('Y-m-d', strtotime('-' . $day . ' day'));
        
        $customDate = $this->argument('customDate');
        
        if(!empty($customDate)){
        	$date = date('Y-m-d', strtotime($customDate));
        }
		
        foreach ($countries as $i => $country)
        {
            if(!$country['active']) continue;
            
            Log::info( $country['name'] );

            $this->comment('Country: ' . $country['name'] . PHP_EOL);
            $client = new \GuzzleHttp\Client();
            try {                
                $res = $client->request('GET', 'http://www.cedexis.com/countryreportsapi/countries/' . $country['code'] . '/reports/days?date=' . $date);
                $content = $res->getBody();
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                Log::info( $e->getMessage() );
            }
            
            if(!isset($res)) 
            {
                //$countries[$i]['active'] = false;
            }
            
            
            
            if(!empty($res) && $res->getStatusCode() != 200) continue;
            
                
            if (empty($content))
            {
                $this->comment('Empty cedexis content' . PHP_EOL);
            } 
            else
            {

                $data = [];

                $json = json_decode($content, true);

                foreach ($json['reports'] as $report)
                {
                    //skip non ISP records
                    if ($report['category'] != 'isp')
                        continue;

                    foreach ($report['data'] as $isp)
                    {
                        if (empty($data[$isp['label']]))
                        {
                            $data[$isp['label']] = ['date' => $date, 'country' => $country['code'],
                                'operator' => $isp['label']];
                        }

                        switch ($report['type'])
                        {
                            case 'unique_sessions':
                                $data[$isp['label']]['unique_sessions'] = $isp['value'];
                            case 'page_load':
                                $data[$isp['label']]['avg_load_time'] = $isp['value'];
                            case 'percentile_25_page_load':
                                $data[$isp['label']]['25th_percentile_load_time'] = $isp['value'];
                            case 'percentile_50_page_load':
                                $data[$isp['label']]['50th_percentile_load_time'] = $isp['value'];
                            case 'percentile_75_page_load':
                                $data[$isp['label']]['75th_percentile_load_time'] = $isp['value'];
                            case 'percentile_95_page_load':
                                $data[$isp['label']]['95th_percentile_load_time'] = $isp['value'];
                            case 'error_rate':
                                $data[$isp['label']]['avg_failure_rate'] = $isp['value'];
                        }

                    }

                }
                
                //Log::info($data);

                foreach ($data as $row)
                {
                    $record = \Ranking\Models\Cedexis::where('date', $date)->where('country', $country['code'])->where('operator', $row['operator'])->first();
                    if (empty($record))
                    {
                        $record = new \Ranking\Models\Cedexis;
                    }

                    foreach ($row as $field => $value)
                    {
                        $record->$field = $value;
                    }
                    $record->save();
                }

            }
            
            unset($content, $res);
        }
        
        Setting::set('CedexisCountries', $countries);
        Setting::save();

    }
}
