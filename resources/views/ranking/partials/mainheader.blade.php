<!-- Main Header -->
<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-brand"><b>wireless</b>Ranking</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Reviews</a></li>
                    <li><a href="#">Data Description</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    {{--<li class="dropdown">--}}
                        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>--}}
                        {{--<ul class="dropdown-menu" role="menu">--}}
                            {{--<li><a href="#">Action</a></li>--}}
                            {{--<li><a href="#">Another action</a></li>--}}
                            {{--<li><a href="#">Something else here</a></li>--}}
                            {{--<li class="divider"></li>--}}
                            {{--<li><a href="#">Separated link</a></li>--}}
                            {{--<li class="divider"></li>--}}
                            {{--<li><a href="#">One more separated link</a></li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <div style="margin-top:14px;margin-right:20px;">
                            <select class="select_country form-control">
                                @foreach($countries['data'] as $code=>$name)
                                    @if($code == $countries['default'])
                                        <option value="{{$code}}" selected="selected">{{$name}}</option>
                                    @else
                                        <option value="{{$code}}">{{$name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </li>
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Sign In</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="/img/default.png" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="/img/default.png" class="img-circle" alt="User Image" />
                                    <p>
                                        {{ Auth::user()->name }}
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>