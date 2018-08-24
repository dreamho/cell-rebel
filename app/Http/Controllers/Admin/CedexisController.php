<?php namespace Ranking\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Ranking\Http\Controllers\Controller;

use Ranking\Models\WorldCountry;

use Setting;

class CedexisController extends Controller
{
    
    private $activeMenu = 'cedexisSettings';
    
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Cedexis settings
     */
    public function settings() 
    {
        
        $countries = Setting::get('CedexisCountries');
        
        if(!$countries) 
        {
            $countries = [];
            $countriesRecords = WorldCountry::orderBy('code')->get();
            
            
            foreach($countriesRecords as $item) 
            {
               $countries[] = ['name' => $item->name, 'code' => $item->code, 'active' => true];     
            }
            
            $countries[] = ['name' => "Australia", 'code' => 'AU', 'active' => true];
            $countries[] = ['name' => "Myanmar", 'code' => 'MM', 'active' => true];
            $countries[] = ['name' => "Danmark", 'code' => 'DK', 'active' => true];
            $countries[] = ['name' => "Macau", 'code' => 'MO', 'active' => true];
            $countries[] = ['name' => "Ukraine", 'code' => 'UA', 'active' => true];
            $countries[] = ['name' => "Netherlands", 'code' => 'NL', 'active' => true];
            $countries[] = ['name' => "Norway", 'code' => 'NO', 'active' => true];
            
            Setting::set('CedexisCountries', $countries);
            Setting::save();
        }
        
        
        return view('admin.cedexis.settings', ['countries' => $countries, 'activeMenu' => $this->activeMenu]);        
    }
    
    /**
     * Save settings
     */
    public function save(Request $request)
    {
        $selected = $request->input('countries');
        
        $countries = [];
        $countriesRecords = WorldCountry::orderBy('code')->get();
        
        $countriesRecords = $countriesRecords->toArray();
        
        $countriesRecords[] = ['name' => "Australia", 'code' => 'AU'];
        $countriesRecords[] = ['name' => "Myanmar", 'code' => 'MM'];
        $countriesRecords[] = ['name' => "Danmark", 'code' => 'DK'];
        $countriesRecords[] = ['name' => "Macau", 'code' => 'MO'];
        $countriesRecords[] = ['name' => "Ukraine", 'code' => 'UA'];
        $countriesRecords[] = ['name' => "Netherlands", 'code' => 'NL'];
        $countriesRecords[] = ['name' => "Norway", 'code' => 'NO'];
        
        
        foreach($countriesRecords as $item) 
        {
            $countries[] = ['name' => $item['name'], 'code' => $item['code'], 'active' => in_array($item['code'], $selected) ? true : false]; 
        }
        
        Setting::set('CedexisCountries', $countries);
        Setting::save();
        
        return view('admin.cedexis.saved', ['activeMenu' => $this->activeMenu]); 
    }
    
    /**
     * Cedexis export
     */
    public function export() 
    {   
        $this->activeMenu = 'cedexisExport';
        return view('admin.cedexis.export', ['datestart' => date('Y-m-d', strtotime('-1 day')) , 'dateend' => date('Y-m-d'), 'activeMenu' => $this->activeMenu]);        
    }
}