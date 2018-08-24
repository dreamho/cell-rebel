@extends('ptypev1.app')

@section('htmlheader_title')
    Mobile Operator Rankings
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/ionslider/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/ionslider/ion.rangeSlider.skinNice.css')}}" rel="stylesheet">
    <link href="{{asset('css/content.css')}}" rel="stylesheet">
@endsection

@section('contentheader_title')
    Mobile Operator Ranking
@endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="sidebar-container">
                <div class="btn-group pull-right btn-group-xs hidden-xs" data-toggle="btns">
                    @foreach($ranks as $key=>$value)
                        <a class="btn btn-default {{($key === 'national') ? 'active' : ''}}" href="#stats-{{$key}}" data-toggle="tab">{{ucwords($key)}}</a>
                    @endforeach
                </div>
                <div class="tab-content">
                    @foreach($ranks as $key=>$value)
                    <div class="tab-pane {{($key === 'national') ? 'active' : ''}}" id="stats-{{$key}}">
                        <ul class="nav nav-tabs">
                            @foreach($scoreCategories as $catkey=>$category)
                                <li class="{{($catkey===0) ? 'active' : ''}}"><a data-toggle="tab" href="#tab-{{$key}}-{{$category['id']}}"> <i class="{{$category['icon']}}"></i></a></li>
                            @endforeach
                        </ul>

                        <div class="tab-content white-bg">
                            <!-- TODO: create a tab content here -->
                            @include('ptypev1.partials.widgets.category-rank-content',['categories' => $scoreCategories, 'rankScore' => $ranks[$key], 'level' => $key])
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @foreach($ranks['national']['experience']['operators'] as $operator)
        @include('ptypev1.partials.widgets.operator-rate')
        @include('ptypev1.partials.widgets.operator-review')
    @endforeach
@endsection

@section('scripts')
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('plugins/ionslider/ion.rangeSlider.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.modal').appendTo("body");

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

            $('[data-toggle="btns"] .btn').on('click', function(){
                var $this = $(this);
                $this.parent().find('.active').removeClass('active');
                $this.addClass('active');
            });

            // Open close right sidebar
            $('.levels').click(function () {
                $('#right-sidebar').toggleClass('sidebar-open');
            });


            var name = $(".select_country :selected").text();
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "7000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.success('Operator scores for ' + name + ' has been loaded.');

            /* ION SLIDER */
            $("[id^=range_]").ionRangeSlider({
                hasGrid: false,
                type: "single",
                step: 0.1,
                min: 1,
                max: 5,
                from: 0,
                values: ['Poor', '2', '3', '4', 'Excellent']
            });

        });
    </script>
@endsection