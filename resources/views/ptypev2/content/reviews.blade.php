@extends('ptypev2.app')

@section('title') Reviews @endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endsection

@section('content_title')
    Mobile Operator Reviews
@endsection

@section('content_description')
    <br/>See what other users say about the operators
@endsection

@section('main-content')
	<div class="fh-column hidden-xs hidden-sm">
        <div class="full-height-scroll" id="tabs">
            <ul class="list-group elements-list no-padding" style="margin: 0;">
                @foreach($operators as $key => $operator)
                    <li class="list-group-item {{($key===0)? 'active': ''}} review-sidebar-box container-white-rounded" >
                        <a data-toggle="tab" data-href="{{strtok($_SERVER["REQUEST_URI"],'?').'?page=1'}}#tab-{{$operator['id']}}" href="#tab-{{$operator['id']}}" onclick="window.location.href=this.dataset.href" class="review-sidebar-box-link">
                            <div class="pull-left" style="padding-top: 18px; font-size: 16px;">
                                <div class="operator-logo">

                                </div>
                                <div class="operator-name">
                                    <strong>{{$operator['name']}}</strong>
                                </div>
                            </div>
                            <div class="m-t-xs m-b-xxs rating-stars pull-right">
                               	@for($i=1; $i<=5; $i++)
					                @if($i <= $operator['rating'])
					                    <span class="cr-star" ><i class="fa fa-star text-yellow"></i></span>
					                @else
					                    @if (($operator['rating_halfstar']==1)&&($i==$operator['rating']+1))
					                    <span class="cr-star">
                                            <i class="fa fa-star-half-o text-yellow"></i>
									    </span>
					                    @else
					                    <span class="cr-star"><i class="fa fa-star-o" style="color:lightgrey"></i></span>
					                    @endif

					                @endif
                                @endfor
                                <div class="text-center" style="margin-top: 10px;">
                                    Average {{ array_sum($operator['uxRatings']) }} reviews
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <!--<div class="small m-t-xs">
                                <p>
                                    Survived not only five centuries, but also the leap scrambled it to make.
                                </p>
                            </div>-->
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="hidden-lg hidden-md select_operator_wrap element-detail-box" id="operator-list">
        <select class="select_operator">
            @foreach($operators as $operator)
                <option value="{{$operator['id']}}">{{$operator['name']}}</option>
            @endforeach
        </select>
    </div>

    <div class="full-height">
        <div class="full-height-scroll white-bg border-left1">
            <div class="element-detail-box" style="padding-top: 0;">
                <div class="tab-content">
                    @foreach($operators as $key=>$operator)
                        <div id="tab-{{$operator['id']}}" class="tab-pane {{($key===0)? 'active': ''}}">
                            {{--<div class="row">
                                <div class="col-xs-12 col-sm-6 col-lg-9">
                                    <div class="m-b-md">
                                        <h2>{{ucwords($operator['name'])}}</h2>
                                    </div>
                                </div>
                            </div>--}}

                            <!-- Operator Summary -->
                            <div class="well review-well container-white-rounded">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h1>{{ $operator['name'] }}</h1>
                                    <br>
                                    <div class="m-b-md">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $operator['rating'])
                                                <span class="cr-star" ><i class="fa fa-star text-yellow"></i></span>
                                            @else
                                                @if (($operator['rating_halfstar']==1)&&($i==$operator['rating']+1))
                                                <span class="cr-star">
                                                    <i class="fa fa-star-half-o text-yellow"></i>
                                                </span>
                                                @else
                                                <span class="cr-star"><i class="fa fa-star-o" style="color:lightgrey"></i></span>
                                                @endif

                                            @endif
                                        @endfor

                                        &nbsp;&nbsp;&nbsp;Average {{ array_sum($operator['uxRatings']) }} reviews
                                    </div>
                                    <div class="m-b-md">
                                        <button class="btn btn-lg btn-success"
                                                type="button"
                                                data-toggle="modal"
                                                data-target="#reviewModal_operator"
                                                data-field="header"
                                                data-operator="{{str_replace(' ','_', $operator['name'])}}"
                                                data-operatorId="{{$operator['id']}}">
                                            <i class="fa fa-edit"></i> New Review
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-7 cluster_info" id="cluster_info">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="star-count row" style="margin: 0 10px">
                                            <div class="col-xs-2 col-lg-1 col-md-1 col-sm-2 no-padding">
                                                <span class="text-nowrap">{{ $i }} Star</span>
                                            </div>
                                            <div class="col-xs-8 col-lg-10 col-md-10 col-sm-8">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ ratingPercentage($operator['uxRatings'], $i) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ ratingPercentage($operator['uxRatings'], $i) }}%;">
                                                        {{ ratingPercentage($operator['uxRatings'], $i) }}%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-lg-1 col-md-1 col-sm-1">
                                                {{ $operator['uxRatings'][$i] }}
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            </div>

							<style>
								.review-well{
									background-color: white;

								}
								.element-detail-box {
									background-color: rgb(243,243,244);
								}
							</style>

                            <!-- Operator Reviews -->
                            <div class="row m-t-sm" style="margin-top: 0;">
                                <div class="feed-activity-list col-sm-12 col-xs-12 col-lg-12 col-md-12 pull-left">
                                    @foreach($operator['reviews']['data'] as $review)
                                        {{--
										<div class="feed-element">
                                            <div class="media-body ">
                                                <small class="pull-right">{{$review['diff']}}</small>
                                                <strong>{{$review['author']}}</strong><br/>
                                                <small class="text-muted">{{$review['added']}}</small>
                                                <h4>{{$review['title']}}</h4>
                                                <div>
                                                    {{$review['details']}}
                                                </div>
                                            </div>
                                        </div>
                                        --}}

                                        <div class="well review-well container-white-rounded">
											<div class="row">
												<div class="col-lg-5">
													<strong class="review-author">{{$review['author']}}</strong>
    												@if(!empty($review['ux_rating'])&&($review['ux_rating']>0))
    													<div class="m-b-md">


    															@for($i=1; $i<=5; $i++)
    			                                                    @if($i <= $review['ux_rating'] && !is_null($review['ux_rating']))
    			                                                        <span class="cr-star" ><i class="fa fa-star text-yellow"></i></span>
    			                                                    @else
    			                                                        <span class="cr-star" ><i class="fa fa-star-o" style="color:lightgrey"></i></span>
    			                                                    @endif
    			                                                @endfor


                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $review['ux_rating'] . " " . str_plural("star", $review['ux_rating']) }}
                                                        </div>
                                                    @endif
												</div>
												<div class="col-xs-12 col-lg-2 text-right pull-right">
													<small class="review-date">{{ $review['created_at']->format("d M Y") }}</small>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-10">
													<h4> {{$review['title']}}</h4><br />
													{{$review['details']}}
												</div>
											</div>
										</div>



                                    @endforeach
                                </div>

                            </div>

                            {{$operator['reviews']['links']}}

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('ptypev2.content.review-modal-form')
@endsection

@section('scripts')
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('plugins/rating-input/rating-input.min.js') }}"></script>

    <script>
        if (location.hash) {
            setTimeout(function() {
                window.scrollTo(0, 0);
            }, 1);
        }

        $(document).ready(function () {
            $("#reviewModal_operator").on("shown.bs.modal", function () {
          		var me = this;
			    $.ajax({
			    	'url':'/stats/getDevice',
					'dataType':'text',
					'success':function(resp){
						$(me).find('textarea[name="device_data"]').val(resp);
					}
			    });
			});

			$("#operator-review #reviewerName,#operator-review #reviewText").on('focus',function(){
				$("#reviewModal_operator .modal-dialog").css('height','1000px');

			});
			$("#operator-review #reviewerName").on('focus',function(){
				$("#reviewModal_operator .modal-dialog").css('height','1000px');
                // $('#reviewModal_operator').animate({
					// scrollTop: 200
			    // }, 200);
			});
			$("#operator-review #reviewerName,#operator-review #reviewText").on('blur',function(){
				$("#reviewModal_operator .modal-dialog").css('height','auto');
			});

            /* Setup Country Selections */
            // var countryList = $(".select_country").select2({
            //     placeholder: "Select a country",
            //     allowClear: false
            // });

            // $('b[role="presentation"]').hide();


            // countryList.change(function () {
            //     var code = countryList.select2('data')[0].id;
            //     window.location = '/reviews/' + code;
            // });

            // var name = $(".select_country :selected").text();

            /* Setup Operator Selections */
            var operatorList = $(".select_operator").select2({
                placeholder: "Select a operator",
                allowClear: false
            });

            // var str = window.location.hash;
            // var selectedOperatorId = str.replace('#tab-', '');

            // $(".select_operator").select2().select2('val', selectedOperatorId);

            // $('b[role="presentation"]').hide();
            // $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');

            operatorList.change(function () {
                var operatorId = operatorList.select2('data')[0].id;
                $('.elements-list a[href="#tab-' + operatorId + '"]').tab('show')

                if(!$('#tab-'+operatorId+' .sparkline').hasClass('rendered')) {
                    $('#tab-'+operatorId).find('.sparkline').sparkline('html', {type: 'pie', height: '100px',sliceColors: ['#ffe0b5','#ffd184','#ffc000','#e2aa00','#c09000']}); //['#c09000','#e2aa00','#ffc000','#ffd184','#ffe0b5'];
                    $('#tab-'+operatorId).find('.sparkline').addClass('rendered')
                }
            });

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
//            toastr.success('Wireless Ranking reviews has been loaded.');

            $("ul.navbar-nav").children().removeClass('active');
            $("a#reviews").parent().addClass('active');

            // Add slimscroll to element
            $('.full-height-scroll').slimscroll({
                height: '100%'
            })

            /* Load knob score graphs */
            $(".knob").knob({
                val: function (v) {
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
            })


            function openTab(tab){
                if($('a[href="#'+tab+'"]').length>0){
                    $('a[href="#'+tab+'"]').tab('show');
                    location.hash = tab;
                    $('div#'+tab+' ul.pagination a').each(function(){
                       $(this).attr('href',$(this).attr('href')+'#'+tab);
                    });
                }
            }
            var hash = window.location.hash;
            if (hash) {
                openTab(hash.replace('#',''));
                //$('.elements-list a[href="' + window.location.hash + '"]').tab('show');
            }
            else {
                $('.tab-pane.active .sparkline').sparkline('html', {type: 'pie', height: '100px',sliceColors: ['#ffe0b5','#ffd184','#ffc000','#e2aa00','#c09000']}).addClass('rendered');

            }

            /* Open Review Modal Form */
            $('button[data-target="#reviewModal_operator"]').on('click', function (e) {
                e.preventDefault();
                var selector = $(this).data('target'),
                        operatorName = $(this).data('operator'),
                        operatorId = $(this).attr('data-operatorId');

                $('div.rating-input').children().removeClass('text-warning').addClass('text-default');

                $('span.operator', selector).html(operatorName);
                $('input[name=operator_id]', selector).val(operatorId);
                $('input[name=operator_name]', selector).val(operatorName);
                $('input[name=reviewerName]', selector).val('');
            });

            /* Handle Review Modal Form Submit */
            $('button#review_submit').click(function (e) {
                e.preventDefault();


                //var countryCode = countryList.select2('data')[0].id;



                var reviewTitle = $('#reviewTitle');
                var reviewText = $('#reviewText');
                var reviewerName = $('#reviewerName');

                if (reviewerName.val() === '') {
                    reviewerName.val('Anonymous');
                }

                if (!reviewTitle.val()) {
                    toastr["error"]("You need to provide title for this rating.")
                } else if (!reviewText.val()) {
                    toastr["error"]("You need to provide comments/remarks for this rating.")
                } else {
                    var reviewData = new FormData($('#operator-review')[0]);
                    var operatorId = $('#operator-review input[name="operator_id"]').val();
                    var action = "{{ url('/operator/review' ) }}";
                    action+='/'+operatorId;
                    $.ajax({
                        type: 'POST',
                        url: action,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: reviewData,
                        error:function(err){
                        	$('#reviewModal_operator button#review_submit').removeClass('disabled');
                            if(err['status']==429){
								toastr.error('You have reached the maximum number of allowed reviews per operator and day!');
							} else if(err['status']==422) {
                                var validation = err['responseText'];
                                if (validation) {
                                    validation = $.parseJSON(validation);
                                }
                                for (e in validation) {
                                    toastr.error(validation[e]);
                                }
                            } else {
                            	toastr.error('The following error encountered: ' + err['statusText']);
                            }
                            $("#reviewModal_operator").modal('hide');
                            grecaptcha.reset();
                        },
                        success:function (data) {
                        	$('#reviewModal_operator button#review_submit').removeClass('disabled');
                            if (data['message'] == 'success') {
                                if(typeof(data['tryouts_left'])!='undefined'){
                                    if(data['tryouts_left']>0){
                                        //toastr.warning('Нou have '+data['tryouts_left']+' more attempts!');
                                    } else {
                                        toastr.warning('You have reached the maximum number of allowed reviews per operator and day!');
                                    }
                                }
                                $("#reviewModal_operator").modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                },2500);
                                toastr.success('Your review was successfully recorded');
                            } else {
                                toastr.error('The following error encountered: ' + data['message']);
                            }
                            grecaptcha.reset();
                        }
                    });
                    $('#reviewModal_operator button#review_submit').addClass('disabled');
                }
            });
            //$('.tab-pane.active').find('.sparkline').sparkline('html', {type: 'pie', height: '100px',sliceColors: ['#ffe0b5','#ffd184','#ffc000','#e2aa00','#c09000']}).addClass('rendered'); //['#c09000','#e2aa00','#ffc000','#ffd184','#ffe0b5'];
        });

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            var cTabId = $(this).attr('href').replace('#tab-','');
            if(!$('#tab-'+cTabId+' .sparkline').hasClass('rendered')) {
                console.log(cTabId)
                $('#tab-'+cTabId).find('.sparkline').sparkline('html', {type: 'pie', height: '100px',sliceColors: ['#ffe0b5','#ffd184','#ffc000','#e2aa00','#c09000']}); //['#c09000','#e2aa00','#ffc000','#ffd184','#ffe0b5'];
                $('#tab-'+cTabId).find('.sparkline').addClass('rendered')
            }
        })

    </script>
@endsection