<?php namespace Ranking\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Ranking\Http\Controllers\Controller;

use Ranking\Models\MobileOperator;
use Ranking\Models\Ratings;
use Ranking\Models\Review;
use Ranking\Models\Scores;
use Ranking\Models\WorldCity;
use Ranking\Models\WorldCountry;

use Validator;
use Redirect;
use Session;


class ExcelController extends Controller
{
    
    /**
     * Model mappers
     */
    private $tables = 
        [
            'Cities' => 'WorldCity', 
            'Countries' => 'WorldCountry', 
            'Mobile operators' => 'MobileOperator', 
            'Reviews' => 'Review',
            'MobileData' => 'MobileData',
        ];
    
    private $activeMenu = 'export';
    
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    /**
     * Export form
     */
    public function export()
    {
        
        //get all exported files
        $files = Storage::disk('local')->files('exports');
        
        foreach($files as $i => $file) 
        {
            $fileDate = explode('-', $file);
            
            //format date
            $fileDate = $fileDate[1] . '-' . $fileDate[2] . '-' . $fileDate[3] . ' ' . $fileDate[4] . ':' . $fileDate[5] . ':' . explode('.', $fileDate[6])[0];
            $files[$i] = 
                [
                    'name' => explode('exports/', $file)[1], //cut folder title
                    'date' => $fileDate
                ];
        }
        
        return view('admin.content.export', ['files' => $files, 'activeMenu' => $this->activeMenu]);
    }
    
    /**
     * Create export file
     */    
    public function make(Request $request)
    {
        set_time_limit (60 * 5);
        
        $table = $request->input('exportTable');
        $filename = $table . '-' . date('Y-m-d-H-i-s');
        global $offset,$limit,$page;
        
        $limit = $request->input('limit');
    	
		$page = $request->input('page');
		
		
        $offset = false;
        
        
        if(!empty($limit)&&!empty($page)){
        	$offset = $limit*($page-1);
        }
        
        
        // Model class        
        $model = '\Ranking\Models\\' . ( key_exists($table, $this->tables) ? $this->tables[$table] : $table );
        
        $preparedModel = false;
        
        if($request->input('filter')) {
            $filer = $request->input('filter');
            if(!empty($filer['whereBetween'])) 
            {
                foreach($filer['whereBetween'] as $field => $value) 
                {
                    if($field == 'date') 
                    {
                        $date = explode(' - ', $value);                            
                        $model = $model::whereBetween($field, [new \DateTime($date[0]), new \DateTime($date[1])]);
                    }
                    
                }
            }
        }
        
        if(!is_object($model)) 
        {
            $model = new $model;
        }
        
        //create xls
        \Excel::create($filename, function($excel) use ($table, $model) 
        {
            //create sheet
            $excel->sheet('Export of ' . $table , function($sheet) use ($model) 
            {   
                global $isFirstRow,$offset,$limit,$page;
                
                $isFirstRow = true;
                
                //get all records chunked to 200 items
                if(!empty($model->orderFld)&&!empty($model->orderWay)){
					$model = $model->orderBy($model->orderFld, $model->orderWay);
				}
				$chunk = 200;
				if(($offset!==false)&&!empty($limit)){
					$model = $model->skip($offset)->take($limit);
					if($limit<$chunk){
						$chunk = $limit;
					}
				}
				
				global $counter;
				$counter = 0;
                
                $model->chunk($chunk, function ($items) use ($sheet) 
                {
                    global $isFirstRow,$counter,$page,$limit;
                    $counter++;
                    
                    $add = true;
                    
                    if(!empty($limit)){
                    	if($page==$counter){
                    		$add = true;
                    	}	else {
                    		$add = false;
                    		if($counter>$page){
                    			return false;
                    		}
                    	}
                    }
                    if($add){
	                    foreach ($items as $item) 
	                    {
	                        $data = $item->toExportArray();  
	                         
	                        //if isFirstRow add headers
	                        if($isFirstRow) 
	                        {
	                            $keys = array_keys($data);
	                            $sheet->rows(array($keys));
	                            
	                            //var_dump($res = \PHPExcel_Cell::stringFromColumnIndex(count($keys) - 1));
	                            //die();
	                            
	                            $sheet->cells('A1:' . (\PHPExcel_Cell::stringFromColumnIndex(count($keys) - 1)) . '1', function($cells) {
	
	                                // manipulate the range of cells
	                                $cells->setFontWeight('bold');
	                            
	                            });
	                            
	                            $isFirstRow = false;
	                        }
	                      
	                        $sheet->rows(array($data));
	                    }
                    }
                    
                });
                
            });

        })->store('xls')->export('xls');
        
        //return view('admin.content.export');
    }
    
    /**
     * Import form
     */
    public function import()
    {
        $this->activeMenu = 'import';
        
        return view('admin.content.import', ['activeMenu' => $this->activeMenu]);
    }
    
    /**
     * Upload imported file
     */
    public function upload(Request $request)
    {
        $this->activeMenu = 'import';
        
        $errors = null;
        
        $file = $request->file('importFile');
        if($file) {
            $ext = $file->getClientOriginalExtension();
            $fileName = $request->input('importFile');
        }else {
            Session::flash('error', 'No file was selected');
        }
        
        // checking file is valid.
        if ($file && $request->file('importFile')->isValid() && $ext == 'xls') 
        {
              $fileName = time() . '.' . $ext; // renameing image
              $res = $request->file('importFile')->move(storage_path('app/imports'), $fileName); // uploading file to given path
              // sending back with message
              Session::flash('success', 'Upload successfully'); 
              //return Redirect::to('upload');
              
              $result = $this->importFile($fileName);
              
              if(!empty($result['errors'])) 
              {                
                $msg = '';
                
                foreach($result['errors'] as $row => $error) 
                {
                    $msg .= 'Row:' . $row . ' Error:' . $error . PHP_EOL;
                }
                $errors = 'Found errors in the following rows: ' . PHP_EOL . $msg;
              }
        }
        elseif($file) 
        {
              // sending back with error message.
              Session::flash('error', 'Uploaded file is not valid');
              //return Redirect::to('upload');
        }      
        
        return view('admin.content.upload', 
                        [
                            'filename' => isset($fileName) ? $fileName : null, 
                            'errors' => $errors, 
                            'result' => isset($result) ? $result : array(),
                            'activeMenu' => $this->activeMenu
                        ]
        );
    }
    
    /**
     * Process import
     */
    function process(Request $request) 
    {
        $this->activeMenu = 'import';
        
        $fileName = $request->input('filename');   
        
        if(!empty($fileName)) {
            $result = $this->importFile($fileName, true);
            
            if(!empty($result['errors'])) 
            {                
                $msg = '';
                
                foreach($result['errors'] as $row => $error) 
                {
                    $msg .= 'Row:' . $row . ' Error:' . $error . PHP_EOL;
                }
                $errors = 'Found errors in the following rows: ' . PHP_EOL . $msg;
            }
            
            Session::flash('success', 'Done');
            
            return view('admin.content.imported', 
                            [
                                'filename' => $fileName, 
                                'errors' => isset($errors) ? $errors : '', 
                                'result' => isset($result) ? $result : array(),
                                'activeMenu' => $this->activeMenu
                            ]
            );
        }     
    }
    
    /**
     * Download exported file
     */
    public function download($file = '')
    {
        if($file) 
        {
            return response()->download(storage_path('app/exports') . '/' . $file);
        }
    }
    
    /**
     * Remove exported file
     */
    public function remove(Request $request)
    {
        $file = $request->input('filename');
        
        if($file) 
        {
            Storage::disk('local')->delete('exports/' . $file);
        }
    }
    
    private function importFile($file, $doImport = false) 
    {
        
        $sheet = \Excel::load(storage_path('app/imports') . '/' . $file)->get();
        
        $title = trim(str_replace('Export of', '', $sheet->getTitle()));
        
        $model = key_exists($title, $this->tables) ? $this->tables[$title] : $title;
        
        $model = '\Ranking\Models\\' . $model;
            
        if(!class_exists($model)) 
        {
            throw new \Exception('Model not found');
        }
            
        $sample = $model::first();       
                 
        $key = $sample->getKeyName();            
        $columns = array_keys($sample->toArray());            
        $numRows = count($columns);
            
        $result = 
            [
                'rows' => 0, 
                'new' => 0, 
                'update' => 0,
                'model' => $title,
                'errors' => []
            ];
            
            
        $first = $sheet->get(1);
            
            
        foreach ($sheet->getIterator() as $i => $row) 
        {
               $row = $row->toArray();
               
               if(count($row) != $numRows) 
               {
                    $result['errors'][$i] = 'Row column count mismatch';
               }
               
               if(!empty($row[0]) && is_numeric($row[0])) 
               {               
                   $item = $model::find($row[0]);                
               }
               
               if(empty($row[0]) || empty($item)) 
               {
                   $result['new']++; 
                   
                   if($doImport) 
                   {
                      $item = new $model;
                      for($i = 1; $i < $numRows; $i++) 
                      {                        
                        $item->{$columns[$i]} = $row[$i]; 
                      }
                      
                      $item->save();
                   }
                   
               }
               elseif(!is_numeric($row[0])) 
               {
                    continue; 
               }
               else 
               {
                   
                   $doUpdate = false;
                   
                   for($i = 1; $i < $numRows; $i++) 
                   {                        
                        if($item->{$columns[$i]} != $row[$i]) 
                        {
                            $result['update']++;
                            $doUpdate = true;
                            break;
                        }
                   }  
                   
                   if($doImport && $doUpdate) 
                   {
                     for($i = 1; $i < $numRows; $i++) 
                     {                        
                        $item->{$columns[$i]} = $row[$i]; 
                     }
                     $item->save();
                   }
               }
               
               $result['rows']++;
               
               unset($item);
               
        }
            
        return $result;
    }
    
    
    public function saveMobileSettings(){
    	$req = request();
    	$dbPath = database_path();
    	$jsonFilePath = $dbPath.DIRECTORY_SEPARATOR.'mobile_settings.json';
    	if(!file_exists($jsonFilePath)){
    		touch($jsonFilePath);
    	}
    	$settings = array();
    	
    	
    	$settings['fileTestLink'] = $req->input('fileTestLink');
    	$settings['siteTestLink'] = $req->input('siteTestLink');
    	$settings['youtubeTestLink'] = $req->input('youtubeTestLink');
    	
    	$settings['backgroundMeasurementsEveryHours'] = $req->input('backgroundMeasurementsEveryHours');
    	$settings['activeMeasurementsEveryHours'] = $req->input('activeMeasurementsEveryHours');
    	
    	$settings['timeout_file'] = $req->input('timeout_file');
    	$settings['timeout_site'] = $req->input('timeout_site');
    	$settings['timeout_youtube'] = $req->input('timeout_youtube');
    	
    	file_put_contents($jsonFilePath,json_encode($settings));		
		return $this->mobileSettings();
    }
    
    
    private function getMobileSettings(){
    	$settings = array();
		$req = request();
    	$dbPath = database_path();
    	$jsonFilePath = $dbPath.DIRECTORY_SEPARATOR.'mobile_settings.json';
    	if(!file_exists($jsonFilePath)){
    		return $settings;
    	}
    	try{
    		$settings = file_get_contents($jsonFilePath);
    		$settings = json_decode($settings,true);
    	} catch(Exception $e){
    		return $settings;
    	}
    	
    	return $settings;
    }
    
    public function mobileSettings(){
    	$this->activeMenu = 'mobile_settings';
    	$settings = $this->getMobileSettings();
    	
    	if(!isset($settings['fileTestLink'])){
    		$settings['fileTestLink'] = '';
    	}
    	
    	if(!isset($settings['siteTestLink'])){
    		$settings['siteTestLink'] = '';
    	}
    	
    	if(!isset($settings['youtubeTestLink'])){
    		$settings['youtubeTestLink'] = '';
    	}
    	
    	if(!isset($settings['activeMeasurementsEveryHours'])){
    		$settings['activeMeasurementsEveryHours'] = 0;
    	}
    	
    	if(!isset($settings['backgroundMeasurementsEveryHours'])){
    		$settings['backgroundMeasurementsEveryHours'] = 0;
    	}
    	if(!isset($settings['timeout_file'])){
    		$settings['timeout_file'] = 60;
    	}
    	if(!isset($settings['timeout_site'])){
    		$settings['timeout_site'] = 60;
    	}
    	if(!isset($settings['timeout_youtube'])){
    		$settings['timeout_youtube'] = 60;
    	}
    	
		return view('admin.content.mobilesettings', 
                        [
                            //'filename' => isset($fileName) ? $fileName : null, 
                            //'errors' => $errors, 
                            //'result' => isset($result) ? $result : array(),
                            'activeMenu' => $this->activeMenu,
                            'mobile_settings'=>$settings
                        ]
        );
    }
}