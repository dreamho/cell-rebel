@extends('admin.app')

@section('htmlheader_title')
	Users | Admin
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet"/>
@endsection

@section('contentheader_title')
    Users
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/users"><i class="fa fa-dashboard active"></i>Users</a></li>
    </ol>
@endsection

@section('main-content')
    <section class="content">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">List of all users</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="users-table" data-toggle="table"  data-sort-name="id" data-sort-order="desc" class="table table-bordered">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">id</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="email" data-sortable="true">Email</th>
                                <th data-field="created_at" data-sortable="true">Created At</th>
                                <th>Enabled</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>
                                    <td><input class="user-status"
                                               type="checkbox"
                                               @if(Auth::user()->id === $user->id) disabled  @endif
                                               @if($user->is_admin) checked @endif
                                               data-toggle="toggle"
                                               data-id="{{ $user['id'] }}"
                                        /></td>
                                    <td><button @if(Auth::user()->id === $user->id) disabled  @endif
                                                data-id="{{ $user['id'] }}"
                                                class="user-remove btn btn-primary"
                                        ><i class="fa fa-trash lg"> DELETE</i></button></td>
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
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.css" rel="stylesheet"/>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.min.js"></script>--}}
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user-remove').click(function(){
                if(confirm('Are you sure you want to remove file?')) {
                    $.post( "/admin/users/" + $(this).data('id'), { _token: "{{ csrf_token() }}" });
                    $(this).closest('tr').fadeOut();
                }
            });

            $('#users-table').on('change', '.user-status', function(){
                if(confirm('Are you sure you want to change users admin status?')) {
                    $.post( "/admin/users/" + $(this).data('id')+'/status', { _token: "{{ csrf_token() }}" });
                }
            });
        });
    </script>
@endsection