@extends('admin.app')

@section('htmlheader_title')
	Export | Admin
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Export
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard active"></i>Export</a></li>
    </ol>
@endsection

@section('main-content')
    <section class="content">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Export to Excel</h3>
        </div>
        <!-- /.box-header -->
        <form role="form" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Content</label>
                        <select name="exportTable" class="form-control select2" style="width: 100%;">
                          <option>Cities</option>
                          <option>Countries</option>
                          <option>Mobile operators</option>
                          <option>Ratings</option>
                          <option>Reviews</option>
                          <option>Scores</option>
                          <option>MobileData</option>
                        </select>
                      </div>
                      <!-- /.form-group -->
                    </div>
                    
                </div>
				<div class="row">
					<div class="col-md-6">
                      <div class="form-group">
                        
                        <label><input type="checkbox" name="limit" value="50"/> &nbsp;Limit result</label><br />
                        <label>Page</label>
                        {{ Form::selectRange('page', 1, 15) }}
                      </div>
                      <!-- /.form-group -->
                    </div>
				</div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Download</button>
            </div>
        </form>
      </div>
      
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Recent export files</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                              <th>File</th>
                              <th>Date</th>
                              <th>Remove</th>
                            </tr>
                            @foreach($files as $file)
                            <tr>
                              <td><a href="/admin/download/{{$file['name']}}">{{$file['name']}}</a></td>
                              <td>{{$file['date']}}</td>
                              <th><a href="javascript:void(0);" data-filename="{{$file['name']}}" class="export-remove"><i class="fa fa-trash"></i></a></th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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