@extends('admin.app')

@section('htmlheader_title')
	Mobile settings | Admin
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet"/>
@endsection

@section('contentheader_title')
    Mobile settings
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/mobile_settings"><i class="fa fa-dashboard active"></i>Mobile settings</a></li>
    </ol>
@endsection

@section('main-content')
    <section class="content">

      <div class="box box-default">
	      {!! Form::open(array('method'=>'POST', 'files'=>false)) !!}
	      	    <input type="hidden" name="_token" value="{{ csrf_token() }}">
	            
	            
	            <div class="box-body">
	                <div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="fileTestLink">File test link (should be image)</label><br />
	                          <input type="url" id="fileTestLink" name="fileTestLink" value="{{$mobile_settings['fileTestLink']}}"/>
	                      </div>
	       
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="siteTestLink">Site test link (comma separated)</label><br />
	                          <input type="text" id="siteTestLink" name="siteTestLink" value="{{$mobile_settings['siteTestLink']}}"/>
	                      </div>
	       
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="youtubeTestLink">Youtube test link</label><br />
	                          <input type="url" id="youtubeTestLink" name="youtubeTestLink" value="{{$mobile_settings['youtubeTestLink']}}"/>
	                      </div>	       
	                    </div>
	                </div>
	                
	                
       	 			<input type="hidden" id="activeMeasurementsEveryHours" name="activeMeasurementsEveryHours" value="{{$mobile_settings['activeMeasurementsEveryHours']}}"/>
	                    
	                
	                <div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="backgroundMeasurementsEveryHours">Background measurements every hours</label><br />
	                          <input type="number" id="backgroundMeasurementsEveryHours" name="backgroundMeasurementsEveryHours" value="{{$mobile_settings['backgroundMeasurementsEveryHours']}}"/>
	                      </div>	       
	                    </div>
	                </div>
	                
					<div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="timeout_file">Timeout for file (sec.)</label><br />
	                          <input type="number" id="timeout_file" name="timeout_file" value="{{$mobile_settings['timeout_file']}}"/>
	                      </div>	       
	                    </div>
	                </div>
	                
	                <div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="timeout_site">Timeout for site load (sec.)</label><br />
	                          <input type="number" id="timeout_site" name="timeout_site" value="{{$mobile_settings['timeout_site']}}"/>
	                      </div>	       
	                    </div>
	                </div>
	                
	                <div class="row">
	                    <div class="col-md-6">
	                      <div class="form-group">
	                          <label for="timeout_youtube">Timeout for youtube (sec.)</label><br />
	                          <input type="number" id="timeout_youtube" name="timeout_youtube" value="{{$mobile_settings['timeout_youtube']}}"/>
	                      </div>	       
	                    </div>
	                </div>
	            </div>
	            
	      		<div class="box-footer">
	                <button class="btn btn-primary" type="submit">Save</button>
	            </div>
	      {!! Form::close() !!}        	
      </div>
      
    </section>
@endsection