@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Analytics
@endsection

@section('contentheader_description')
@endsection


@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard active"></i>Home</a></li>
    </ol>
@endsection

@section('main-content')
    <div class="row">
        <div style="display:none;">{{$i=0}}</div>
        <div class="row>">
            <div class="col-md-4">

            </div>
        </div>
        <div class="col-xs-12 col-lg-12">
            <!-- Tabs -->
            <div class="nav-tabs-custom" style="background-color: #ecf0f5">
                <ul class="nav nav-tabs pull-right">
                    @if(!empty($capitalScores))
                    <li><a href="#capital-stats" data-toggle="tab">{{$nationalScores[0]['cityName']}}</a></li>
                    @endif
                    <li class="active"><a href="#national-stats" data-toggle="tab">{{$country['name']}}</a></li>
                    <li class="pull-left header"><i class="fa fa-area-chart"></i> Top Mobile Operators</li>
                </ul>
            </div>
            <div class="tab-content no-padding">
                <div class="tab-pane active" id="national-stats">
                    @foreach($nationalScores as $score)
                        <div style="display:none;">{{$i++}}</div>
                        <div class="col-xs-12 col-sm-4 text-center">
                            <h3 class="m-b-xs">{{$score['mobileOperator']}}</h3>
                            <input type="text" class="knob"
                                   data-readonly="true"
                                   data-thickness="0.1"
                                   data-skin="tron"
                                   data-angleArc="250"
                                   data-angleOffset="-125"
                                   value="{{$score['ux_score']}}"
                                   data-max="10"
                                   data-width="180"
                                   data-height="180"
                                   data-fgColor="{{$score['color']}}"/>
                            <div class="knob-label">Network Quality</div>
                            <div class="box-footer no-border bg-gray-light">
                                <div class="row">
                                    @foreach($score['stats'] as $stat)
                                    <div class="col-xs-6 col-lg-3">
                                        <input type="text" class="knob"
                                               data-readonly="true"
                                               data-thickness="0.2"
                                               data-angleArc="250"
                                               data-angleOffset="-125"
                                               value="{{$stat['value']}}"
                                               data-max="10"
                                               data-width="50"
                                               data-height="50"
                                               data-fgColor="{{$stat['color']}}">
                                        <div class="knob-label">{{$stat['name']}}</div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="row" style="margin-top:5px">
                                    <div class="col-xs-12 col-lg-12">
                                        <button class="btn btn-xs btn-primary" type="button">
                                            <i class="fa fa-star"></i> Rate
                                        </button>
                                        <button class="btn btn-xs btn-success" type="button">
                                            <i class="fa fa-edit"></i> Review
                                        </button>
                                        <button class="btn btn-xs btn-warning" type="button">
                                            <i class="fa fa-copy"></i> Compare
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane" id="capital-stats">
                    @if(empty($capitalScores))
                        <div class="col-xs-12 col-sm-4 text-center">
                            <h3 class="m-b-xs">asdasdasda</h3>
                        </div>
                    @else
                        @foreach($capitalScores as $score)
                            <div style="display:none;">{{$i++}}</div>
                            <div class="col-xs-12 col-sm-4 text-center">
                                <h3 class="m-b-xs">{{$score['mobileOperator']}}</h3>
                                <input type="text" class="knob"
                                       data-readonly="true"
                                       data-thickness="0.1"
                                       data-skin="tron"
                                       data-angleArc="250"
                                       data-angleOffset="-125"
                                       value="{{$score['ux_score']}}"
                                       data-max="10"
                                       data-width="180"
                                       data-height="180"
                                       data-fgColor="{{$score['color']}}"/>
                                <div class="knob-label">Network Quality</div>
                                <div class="box-footer no-border bg-gray-light">
                                    <div class="row">
                                        @foreach($score['stats'] as $stat)
                                            <div class="col-xs-6 col-lg-3">
                                                <input type="text" class="knob"
                                                       data-readonly="true"
                                                       data-thickness="0.2"
                                                       data-angleArc="250"
                                                       data-angleOffset="-125"
                                                       value="{{$stat['value']}}"
                                                       data-max="10"
                                                       data-width="50"
                                                       data-height="50"
                                                       data-fgColor="{{$stat['color']}}">
                                                <div class="knob-label">{{$stat['name']}}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row" style="margin-top:5px">
                                        <div class="col-xs-12 col-lg-12">
                                            <button class="btn btn-xs btn-primary" type="button">
                                                <i class="fa fa-star"></i> Rate
                                            </button>
                                            <button class="btn btn-xs btn-success" type="button">
                                                <i class="fa fa-edit"></i> Review
                                            </button>
                                            <button class="btn btn-xs btn-warning" type="button">
                                                <i class="fa fa-copy"></i> Compare
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
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

            $('b[role="presentation"]').hide();
            $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');

            countryList.change(function()
            {
                var code = countryList.select2('data')[0].id;
                window.location = '/analytics/' + code;
            });

            $(".knob").knob({
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