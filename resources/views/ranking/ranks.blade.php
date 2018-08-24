@extends('ranking.layouts.app')

@section('htmlheader_title')
    Home
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{asset('css/content.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Ranks
@endsection

@section('content_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-line-chart active"></i>Home</a></li>
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
            <div class="nav-tabs-custom">
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
                            <h3 class="m-b-xs"><a href="/{{$score['countryCode']}}/operator/{{str_replace(' ', '-',$score['mobileOperator'])}}">{{$score['mobileOperator']}}</a></h3>
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="knob"
                                           data-readonly="true"
                                           data-thickness="0.15"
                                           data-skin="tron"
                                           data-angleArc="250"
                                           data-angleOffset="-125"
                                           value="{{$score['ux_score']}}"
                                           data-max="10"
                                           data-width="120"
                                           data-height="120"
                                           data-fgColor="{{$score['color']}}"/>
                                    <div class="knob-label">Network Quality</div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="row">
                                        @foreach($score['stats'] as $stat)
                                            <div class="col-xs-6">
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
                                </div>
                            </div>
                            <div class="box-footer no-border">
                                <div class="row" style="margin-top:5px">
                                    <div class="col-xs-12 col-lg-12">
                                        <button class="btn btn-xs btn-primary" type="button" data-toggle="modal", data-target="#rateModal_{{$score['mobileOperator']}}">
                                            <i class="fa fa-star"></i> Rate
                                        </button>
                                        <button class="btn btn-xs btn-success" type="button" data-toggle="modal", data-target="#reviewModal_{{$score['mobileOperator']}}">
                                            <i class="fa fa-edit"></i> Review
                                        </button>
                                        <button class="btn btn-xs btn-warning" type="button">
                                            <i class="fa fa-copy"></i> Compare
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane" id="capital-stats">
                    @if(empty($capitalScores))
                        <div class="col-xs-12 col-sm-4 text-center">
                            <h3 class="m-b-xs">city</h3>
                        </div>
                    @else
                        @foreach($capitalScores as $score)
                            <div style="display:none;">{{$i++}}</div>
                            <div class="col-xs-12 col-sm-4 text-center">
                                <h3 class="m-b-xs"><a href="/{{$score['countryCode']}}/operator/{{str_replace(' ', '-',$score['mobileOperator'])}}">{{$score['mobileOperator']}}</a></h3>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="text" class="knob"
                                               data-readonly="true"
                                               data-thickness="0.15"
                                               data-skin="tron"
                                               data-angleArc="250"
                                               data-angleOffset="-125"
                                               value="{{$score['ux_score']}}"
                                               data-max="10"
                                               data-width="120"
                                               data-height="120"
                                               data-fgColor="{{$score['color']}}"/>
                                        <div class="knob-label">Network Quality</div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="row">
                                            @foreach($score['stats'] as $stat)
                                                <div class="col-xs-6">
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
                                    </div>
                                </div>
                                <div class="box-footer no-border">
                                    <div class="row" style="margin-top:5px">
                                        <div class="col-xs-12 col-lg-12">
                                            <button class="btn btn-xs btn-primary" type="button" data-toggle="modal", data-target="#rateModal_{{$score['mobileOperator']}}">
                                                <i class="fa fa-star"></i> Rate
                                            </button>
                                            <button class="btn btn-xs btn-success" type="button" data-toggle="modal", data-target="#reviewModal_{{$score['mobileOperator']}}">
                                                <i class="fa fa-edit"></i> Review
                                            </button>
                                            <button class="btn btn-xs btn-warning" type="button">
                                                <i class="fa fa-copy"></i> Compare
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                        @endforeach
                    @endif
                </div>
        </div>
    </div>
    </div>
    @foreach($nationalScores as $score)
    <div class="modal inmodal" id="rateModal_{{$score['mobileOperator']}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-star modal-icon"></i>
                    <h4 class="modal-title">Title will go here</h4>
                    <small class="font-bold">Lorem Ipsum is simply dummy text of the objective you wanted to accomplished here.</small>
                </div>
                <div class="modal-body">
                    <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged.</p>
                    <div class="form-group">
                        <p>How would you rate your experience with <strong>{{$score['mobileOperator']}}</strong></p>
                        <div>
                            <div class="radio radio-inline">
                                <span>Poor</span>
                            </div>
                            @for($i=1;$i<=5;$i++)
                            <div class="radio radio-inline">
                                <input type="radio" name="radioExperience" id="radio{{$i}}" value="option{{$i}}">
                                <label></label><br/>
                                <span style="margin-left:-17px">{{$i}}</span>
                            </div>
                            @endfor
                            <div class="radio radio-inline" style="margin-left: -30px;">
                                <span>Excellent</span>
                            </div>
                        </div>
                        <hr/>
                        <p>How likely is it that you would recommend <strong>{{$score['mobileOperator']}}</strong> to a friend or your family</p>
                        <div>
                            <div class="radio radio-inline">
                                <span>Not Likely</span>
                            </div>
                            @for($i=1;$i<=10;$i++)
                            <div class="radio radio-inline">
                                <input type="radio" name="radioRecommend" id="radio{{$i}}" value="option{{$i}}">
                                <label></label><br/>
                                <span style="margin-left: -17px;">{{$i}}</span>
                            </div>
                            @endfor
                            <div class="radio radio-inline" style="margin-left: -30px;">
                                <span>Very Unlikely</span>
                            </div>
                        </div>

                        {{--<label>Sample Input</label> <input type="email" placeholder="Enter your email" class="form-control">--}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="reviewModal_{{$score['mobileOperator']}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-edit modal-icon"></i>
                    <h4 class="modal-title">Title will go here</h4>
                    <small class="font-bold">Lorem Ipsum is simply dummy text of the objective you wanted to accomplished here.</small>
                </div>
                <div class="modal-body">
                    <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged.</p>
                    <div class="form-group">
                        <p>Publish your view of your experience with <strong>{{$score['mobileOperator']}}!</strong></p>
                        <textarea name="reviewData" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Publish Anonymous</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Publish with Facebook</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
   @endforeach
@endsection

@section('scripts')
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.modal').appendTo("body");

            var countryList = $(".select_country").select2({
                placeholder: "Select a country",
                allowClear: false
            });

            $('b[role="presentation"]').hide();
            $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');

            countryList.change(function()
            {
                var code = countryList.select2('data')[0].id;
                window.location = '/ranks/' + code;
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