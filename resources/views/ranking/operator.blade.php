@extends('ranking.layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/content.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    {{$name}}
@endsection

@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/ranks/{{$countryCode}}"><i class="fa fa-line-chart active"></i>Home</a></li>
        <li>Operator</li>
        <li>
            <select class="select_operator form-control" style="margin-right: 100px;">
                @foreach($operators['data'] as $code=>$name)
                    @if($code == $operators['default'])
                        <option value="{{$code}}" selected="selected">{{$name}}</option>
                    @else
                        <option value="{{$code}}">{{$name}}</option>
                    @endif
                @endforeach
            </select>
        </li>
    </ol>
@endsection

@section('main-content')
    <div class="row" style="margin-top:10px;">
        @if(!empty($nationalScores))
        <div class="col-sm-4 text-center">
        <div class="row">
            <h3 class="m-b-xs">{{$country['name']}}</h3>
            <div class="col-xs-6 text-center">
                <input type="text" class="knob"
                       data-readonly="true"
                       data-thickness="0.15"
                       data-skin="tron"
                       data-angleArc="250"
                       data-angleOffset="-125"
                       value="{{$nationalScores[0]['ux_score']}}"
                       data-max="10"
                       data-width="120"
                       data-height="120"
                       data-fgColor="{{$nationalScores[0]['color']}}"/>
                <div class="knob-label">Network Quality</div>
            </div>
            <div class="col-xs-6">
                <div class="row">
                    @for($i=0;$i<2;$i++)
                            <div class="col-xs-6 text-center">
                            <input type="text" class="knob"
                                   data-readonly="true"
                                   data-thickness="0.2"
                                   data-angleArc="250"
                                   data-angleOffset="-125"
                                   value="{{$nationalScores[0]['stats'][$i]['value']}}"
                                   data-max="10"
                                   data-width="60"
                                   data-height="60"
                                   data-fgColor="{{$nationalScores[0]['stats'][$i]['color']}}">
                            <div class="knob-label">{{$nationalScores[0]['stats'][$i]['name']}}</div>
                        </div>
                    @endfor
                </div>
                <div class="row">
                    @for($i=2;$i<4;$i++)
                        <div class="col-xs-6 text-center">
                            <input type="text" class="knob"
                                   data-readonly="true"
                                   data-thickness="0.2"
                                   data-angleArc="250"
                                   data-angleOffset="-125"
                                   value="{{$nationalScores[0]['stats'][$i]['value']}}"
                                   data-max="10"
                                   data-width="60"
                                   data-height="60"
                                   data-fgColor="{{$nationalScores[0]['stats'][$i]['color']}}">
                            <div class="knob-label">{{$nationalScores[0]['stats'][$i]['name']}}</div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        </div>
        @endif

        @if(!empty($capitalScores))
        <div class="col-sm-4 text-center" style="border-left: 1pt solid #EEEEEE;border-right: 1pt solid #EEEEEE;">
            <div class="row">
                    <h3 class="m-b-xs">{{$nationalScores[0]['cityName']}}</h3>
                <div class="col-xs-6 text-center">
                    <input type="text" class="knob"
                           data-readonly="true"
                           data-thickness="0.15"
                           data-skin="tron"
                           data-angleArc="250"
                           data-angleOffset="-125"
                           value="{{$capitalScores[0]['ux_score']}}"
                           data-max="10"
                           data-width="120"
                           data-height="120"
                           data-fgColor="{{$capitalScores[0]['color']}}"/>
                    <div class="knob-label">Network Quality</div>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        @for($i=0;$i<2;$i++)
                            <div class="col-xs-6 text-center">
                                <input type="text" class="knob"
                                       data-readonly="true"
                                       data-thickness="0.2"
                                       data-angleArc="250"
                                       data-angleOffset="-125"
                                       value="{{$capitalScores[0]['stats'][$i]['value']}}"
                                       data-max="10"
                                       data-width="60"
                                       data-height="60"
                                       data-fgColor="{{$capitalScores[0]['stats'][$i]['color']}}">
                                <div class="knob-label">{{$capitalScores[0]['stats'][$i]['name']}}</div>
                            </div>
                        @endfor
                    </div>
                    <div class="row">
                        @for($i=2;$i<4;$i++)
                            <div class="col-xs-6 text-center">
                                <input type="text" class="knob"
                                       data-readonly="true"
                                       data-thickness="0.2"
                                       data-angleArc="250"
                                       data-angleOffset="-125"
                                       value="{{$capitalScores[0]['stats'][$i]['value']}}"
                                       data-max="10"
                                       data-width="60"
                                       data-height="60"
                                       data-fgColor="{{$capitalScores[0]['stats'][$i]['color']}}">
                                <div class="knob-label">{{$capitalScores[0]['stats'][$i]['name']}}</div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(!empty($cityScores))
        <div class="col-sm-4 text-center">
        <div class="row">
            <h3 class="m-b-xs">Network Quality in Other Cities</h3>
            @foreach($cityScores as $score)
            <div class="col-xs-4 text-center">
                <input type="text" class="knob"
                       data-readonly="true"
                       data-skin="tron"
                       data-thickness="0.15"
                       data-angleArc="250"
                       data-angleOffset="-125"
                       value="{{$score['avg_ux']}}"
                       data-max="10"
                       data-width="90"
                       data-height="90"
                       data-fgColor="{{$score['color']}}">
                <div class="knob-label">{{$score['cityName']}}</div>
            </div>
            @endforeach
        </div>
    </div>
        @endif
    </div>
    <hr/>
    <div class="row" style="padding: 0px 20px 0px 20px;">
        <h3 class="m-b-xs">Ratings</h3>
        <div class="col-sm-3"></div>
        <div class="col-sm-9"></div>
    </div>
    <hr/>
    <div class="row" style="padding: 0px 20px 0px 20px;">
        <h3 class="m-b-xs">Reviews</h3>
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <div class="feed-activity-list">
                <div class="feed-element">
                    <div class="media-body ">
                        <small class="pull-right">2h ago</small>
                        <strong>Mark Johnson</strong> posted a review<br>
                        <small class="text-muted">Today 2:10 pm - 12.06.2014</small>
                        <div class="well">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        </div>
                    </div>
                </div>
                <div class="feed-element">
                    <div class="media-body ">
                        <small class="pull-right">1h ago</small>
                        <strong>Kim Smith</strong> posted a review<br>
                        <small class="text-muted">Yesterday 5:20 pm - 12.06.2014</small>
                        <div class="well">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                            Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
    <script>
        $(document).ready(function() {
            var countryList = $(".select_country").select2({
                placeholder: "Select a country",
                allowClear: false
            });

            var operatorList = $(".select_operator").select2({
                placeholder: "Select a country",
                allowClear: false
            });

            $('b[role="presentation"]').hide();
            $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');

            countryList.prop("disabled", true);

            operatorList.change(function () {
                var code = operatorList.select2('data')[0].id;
                window.location = '/{{$countryCode}}/operator/' + code;
            });

            $(".knob").knob({
                val: function (v)
                {
                    return false;
                },
                draw: function () {
                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        var a = this.angle(this.cv)  // Angle
                                , sa = this.startAngle          // Previous start angle
                                , sat = this.startAngle         // Start angle
                                , ea                            // Previous end angle
                                , eat = sat + a                 // End angle
                                , r = true;

                        this.g.lineWidth = this.lineWidth;

                        this.o.cursor
                        && (sat = eat - 0.3)
                        && (eat = eat + 0.3);

                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value);
                            this.o.cursor
                            && (sa = ea - 0.3)
                            && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.previousColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });
        });
    </script>
@endsection