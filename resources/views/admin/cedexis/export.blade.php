@extends('admin.app')

@section('htmlheader_title')
	Export | Cedexis
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Cedexis Export
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cedexis/settings"><i class="fa fa-dashboard"></i>Cedexis</a></li>
        <li><a href="/cedexis/settings">Export</a></li>
    </ol>
@endsection

@section('main-content')
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Export</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('url'=>'admin','method'=>'POST', 'files'=>true)) !!}
            <input type="hidden" name="exportTable" value="Cedexis" />
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                      <h5>Export Cedexis database</h5>
                      <div class="form-group">
                        <label>Date range:</label>
        
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="filter[whereBetween][date]" id="reservation" class="form-control pull-right" value="{{ $datestart }} - {{ $dateend }}">
                        </div>
                        <!-- /.input group -->
                      </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Download</button>
            </div>
        {!! Form::close() !!}
      </div>
        
    </section>
@endsection

@section('scripts')
<script>
        $(document).ready(function() {
            $('.export-remove').click(function(){
               if(confirm('Are you sure you want to remove file?')) {
                    $.post( "/admin/remove", { filename: $(this).data('filename'), _token: "{{ csrf_token() }}" });
                    $(this).closest('tr').fadeOut();
               } 
            });
            
            $('#reservation').daterangepicker({
                "startDate": "{{ $datestart }}",
                "endDate": "{{ $dateend }}",
                format: 'YYYY-MM-DD'
                
            });
        });
</script>
@endsection