@extends('admin.app')

@section('htmlheader_title')
	Done | Admin
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Done
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/import"><i class="fa fa-dashboard active"></i>Import</a></li>
    </ol>
@endsection

@section('main-content')
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">The file has been successfully imported</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('url'=>'admin/import/process','method'=>'POST', 'files'=>true)) !!}
            <input type="hidden" name="filename" value="{{ $filename }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                      @if(Session::has('error') || !empty($errors))
                        @if(!empty($errors))
                    	   <pre>{!! $errors !!}</pre>
                        @else
                           <h4>{!! Session::get('error') !!}</h4>
                        @endif
                      @else
                        @if(Session::has('success'))
                          <div class="alert-box success">
                            <h4>{!! Session::get('success') !!}</h4>
                            @if(!empty($result))
                                Type: {!! $result['model'] !!}<br />
                                Total Rows: {!! $result['rows'] !!}<br />
                                New rows: {!! $result['new'] !!}<br />
                                Update rows: {!! $result['update'] !!}<br />
                            @endif 
                          </div>
                        @endif  
                   	  @endif
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
      </div>
      
    </section>
@endsection