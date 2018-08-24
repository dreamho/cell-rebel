<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/default.png')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">CellRebel</li>
            <!-- Optionally, you can add icons to the links -->
            <li @if(!empty($activeMenu) && $activeMenu == 'export') class="active" @endif><a href="{{ url('admin') }}"><i class='fa fa-download'></i> <span>Export</span></a></li>
            <li @if(!empty($activeMenu) && $activeMenu == 'import') class="active" @endif><a href="{{ url('admin/import') }}"><i class='fa fa-upload'></i> <span>Import</span></a></li>
            <li @if(!empty($activeMenu) && $activeMenu == 'users') class="active" @endif><a href="{{ url('admin/users') }}"><i class='fa fa-users'></i> <span>Users</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
