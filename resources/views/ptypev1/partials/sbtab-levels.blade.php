<div id="tab-1" class="tab-pane active">
    <div class="sidebar-title">
        <h3> <i class="fa fa-globe"></i> Ranking Levels</h3>
        <small><i class="fa fa-tim"></i> Click below to view detailed scores.</small>
    </div>

    <div>
        @foreach($ranks as $key=>$value)
        <div class="sidebar-message">
            <a href="#stats-{{$key}}" data-toggle="tab">
                <div class="levels media-body">
                    <strong>{{ucwords($key)}}</strong>
                    <br>
                </div>
            </a>
        </div>
        @endforeach
        {{--<div class="sidebar-message">--}}
            {{--<a href="#">--}}
                {{--<div class="media-body">--}}
                    {{--<strong>Singapore</strong>--}}
                    {{--<br>--}}
                    {{--<small class="text-muted">No of Operators: 5</small>--}}
                    {{--<br>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<div class="sidebar-message">--}}
            {{--<a href="#">--}}
                {{--<div class="media-body">--}}
                    {{--<strong>Malaysia</strong>--}}
                    {{--<br>--}}
                    {{--<small class="text-muted">No of Operators: 5</small>--}}
                    {{--<br>--}}
                {{--</div>--}}
            {{--</a>--}}
        {{--</div>--}}
    </div>
</div>