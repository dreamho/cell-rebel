@extends('admin.app')

@section('htmlheader_title')
	Import | Admin
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Import
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
          <h3 class="box-title">Import from Excel</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('method'=>'POST', 'files'=>true)) !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label for="importFile">Import file</label>
                          <input type="file" id="importFile" name="importFile">
        
                          {{--<p class="help-block">Example block-level help text here.</p>--}}
                      </div>
                      <!-- /.form-group -->
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Upload</button>
            </div>
        {!! Form::close() !!}
      </div>
      
    </section>
@endsection