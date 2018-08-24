@extends('admin.app')

@section('htmlheader_title')
	Setings | Cedexis
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Cedexis Setings
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cedexis/settings"><i class="fa fa-dashboard"></i>Cedexis</a></li>
        <li><a href="/cedexis/settings">Setings</a></li>
    </ol>
@endsection

@section('main-content')
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Settings</h3>
        </div>
        <!-- /.box-header -->
        {!! Form::open(array('url'=>'admin/cedexis/save','method'=>'POST', 'files'=>true)) !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Countries</label>
                        <select name="countries[]" class="form-control select2" style="width: 100%; min-height:300px" multiple="multiple">
                            @foreach($countries as $item)
                                <option @if($item['active']) selected="selected" @endif value="{{$item['code']}}">{{$item['name']}}</option>
                            @endforeach
                        </select>
                      </div>
                      <!-- /.form-group -->
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

@section('scripts')
<script>
        $(document).ready(function() {
            $('.export-remove').click(function(){
               if(confirm('Are you sure you want to remove file?')) {
                    $.post( "/admin/remove", { filename: $(this).data('filename'), _token: "{{ csrf_token() }}" });
                    $(this).closest('tr').fadeOut();
               } 
            });
        });
</script>
@endsection