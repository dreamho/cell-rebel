@extends('ptypev2.app')

@section('title') Rankings @endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet"/>
@endsection

    @section('content_title')
        Mobile Operator Ranking
    @endsection
    @section('content_description')
        <br/>Find out which mobile operator that provides the best service in every country!
    @endsection

@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="sidebar-container">
                {{-- Load Ranking Groups [National, Capital, Cities]--}}
                <div class="tab-content">
                    @foreach($ranks as $key=>$value)
                        <div class="tab-pane {{($key === 'national') ? 'active' : ''}}" id="stats-{{$key}}">
                            <div class="container-white-rounded">
                                <div class="row">
                                    <div class="col-sm-8 col-xs-12 tab-best">

                                    </div>
                                    <div class="col-sm-4 col-xs-12 text-right view-by">
                                        <div class="dropdown">
                                            View: <button class="btn btn-default dropdown-toggle btn-view" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <span id="selected-sort">Overall Score</span>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                                @foreach($scoreCategories as $catkey=>$category)
                                                    <li name="{{$key}}-{{$category['id']}}"
                                                        class="catScores {{($catkey===0) ? 'active' : ''}}"><a data-caption="{{$category['caption']}} in {{$value[$category['id']]['location']['countryName']}}" data-toggle="tab" href="#tab-{{$key}}-{{$category['id']}}">
                                                            {{$category['caption']}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="clr"></div>
                                        <div class="tab-caption">
                                       </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Load Score Category Content --}}
                            <div class="tab-content ranks-tabs-wrapper">
                                @include('ptypev2.widgets.rank-category.container',['categories' => $scoreCategories, 'rankScore' => $ranks[$key], 'level' => $key])
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('ptypev2.content.rate-modal-form')
    @include('ptypev2.content.review-modal-form')
@endsection

@section('scripts')
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
    <script src="{{ asset('plugins/ionslider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('plugins/rating-input/rating-input.min.js') }}"></script>
    <script>
        function doReadmore(){
           $('p.category-description-price').readmore('destroy');
           $('p.category-description-rating').readmore('destroy');
           $('p.category-description-quality').readmore('destroy');
           $('p.category-description-experience').readmore('destroy');

           $('p.category-description-price').readmore();
           $('p.category-description-rating').readmore();
           $('p.category-description-quality').readmore();
           $('p.category-description-experience').readmore();

        }
        var defaultCountry = "{{ $countries['default'] }}";
        function openTab(tab){
            if($('#stats-national ul.nav-tabs li.catScores a[href="#'+tab+'"]').length>0){
                $('a[href="#'+tab+'"]').tab('show');
                location.hash = tab;

            }
        }
        function handleTabCaption(){
            $('.tab-caption').html('');
            $('.tab-best').html('');
            if($('.ranks-tabs-wrapper div.tab-pane.active').length>0){
                // $('.tab-caption').html($('.ranks-tabs-wrapper div.tab-pane.active .tab-caption-src').html());
                $('.tab-best').html($('.ranks-tabs-wrapper div.tab-pane.active .tab-best-src').html());
            }

        }

        $(document).ready(function () {

            $(".dropdown-menu li a").click(function(){

                $(".btn #selected-sort").text($(this).text());
                $(".btn #selected-sort").val($(this).text());

            });

            $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                handleTabCaption();
                doReadmore();
            });
            $("#rateModal_operator").on("shown.bs.modal", function () {
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
                //     scrollTop: 200
                // }, 200);
            });
            $("#operator-review #reviewerName,#operator-review #reviewText").on('blur',function(){
                $("#reviewModal_operator .modal-dialog").css('height','auto');
            });

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

            $('#stats-national ul.nav-tabs li.catScores a').click(function(){
                var tab = $(this).attr('href').replace('#','');
                location.hash = tab;

            });
            handleTabCaption();
            var locHash = location.hash;
            if(locHash.length>0){
                openTab(locHash.replace('#',''));
            }

            // function formatCountry (country) {
            //     if (!country.id) { return country.text; }
            //     var $country = $(
            //         '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared flag-icon-rounded flag-icon-medium"></span>' +
            //         '<span class="flag-text">'+ '&nbsp;' + country.text+"</span>"
            //     );
            //     return $country;
            // };
            // function formatCountrySmallIcon (country) {
            //     if (!country.id) { return country.text; }
            //     var $country = $(
            //         '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared flag-icon-rounded flag-icon-small"></span>' +
            //         '<span class="flag-text">'+ '&nbsp;' + country.text+"</span>"
            //     );
            //     return $country;
            // };
            //
            // /* Setup Country Selections */
            // var countryList = $(".select_country").select2({
            //     placeholder: "Select a country",
            //     templateResult: formatCountrySmallIcon,
            //     templateSelection: formatCountry,
            //     allowClear: false
            // });

            // $('b[role="presentation"]').hide();
            // $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');
            //
            // countryList.change(function () {
            //     var code = countryList.select2('data')[0].id;
            //     window.location = '/ranks/' + code;
            // });
            //
            // var name = $(".select_country :selected").text();
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
//            toastr.success('Operator scores for ' + name + ' has been loaded.');

            $("ul.navbar-nav").children().removeClass('active');
            $("a#ranking").parent().addClass('active')

            /* Toggle button highlights */
            $('[data-toggle="btns"] .btn').on('click', function () {
                var $this = $(this);
                $this.parent().find('.active').removeClass('active');
                $this.addClass('active');
            });

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
            });

            /* Open Rate Modal Form */
            $('button[data-target="#rateModal_operator"]').on('click', function (e) {
                e.preventDefault();
                var selector = $(this).data('target'),
                        operatorName = $(this).data('operator'),
                        operatorId = $(this).attr('data-operatorId');

                $('div.rating-input').children().removeClass('text-warning').addClass('text-default');

                $('span.operator', selector).html(operatorName);
                $('input[name=operator_id]', selector).val(operatorId);
                $('input[name=operator_name]', selector).val(operatorName);
            });

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

            $('li.catScores').on('click', function (e) {
                $('li.catScores').removeClass('active');
            });

            /* Handle Rate Modal Form Submit */
            $('button#rate_submit').click(function (e) {
                e.preventDefault();

                var ux_rating = $('#ux_rating');
                var recommend_rating = $('#recommend_rating');
                var recommend_rating2 = $('#recommend_rating2');

                if (recommend_rating2.val() > 0) {
                    recommend_rating.val(recommend_rating2.val());
                }

                if (!ux_rating.val()) {
                    toastr["error"]("You need to highlight at least one star on your experience rating.")
                } else if (!recommend_rating.val()) {
                    toastr["error"]("You need to highlight at least one thumbs-up on your recommendation rating.")
                } else {
                    var ratingData = new FormData($('#operator-rating')[0]);
                    var operatorId = $('#operator-rating').find('input[name="operator_id"]').val();
                    var url = "{{ url('/operator/rate') }}";
                    url+='/'+operatorId;



                    $.ajax({
                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: ratingData,
                        error:function(err){
                            $('#operator-rating button[type="submit"]').removeClass('disabled');

                            if(err['status']==429){
                                toastr.error('You have reached the maximum number of allowed ratings per operator and day!');
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
                            $("#rateModal_operator").modal('hide');
                            grecaptcha.reset();
                        },
                        success:function(data){
                            $('#operator-rating button[type="submit"]').removeClass('disabled');
                            if (data['message'] == 'success') {

                                $("#rateModal_operator").modal('hide');
                                if(typeof(data['tryouts_left'])!='undefined'){
                                    if(data['tryouts_left']>0){
                                        //toastr.warning('Нou have '+data['tryouts_left']+' more attempts!');
                                    } else {
                                        toastr.warning('You have reached the maximum number of allowed ratings per operator and day!');
                                    }
                                }

                                setTimeout(function(){
                                    location.reload();
                                },2500);

                                toastr.success('Your rating for ' + data['operator_name'] + ' was successfully recorded');
                            } else {
                                toastr.error('The following error encountered: ' + data['message']);
                            }
                            grecaptcha.reset();
                        }
                    });
                    $('#operator-rating button[type="submit"]').addClass('disabled');
                }
            });

            /* Handle Review Modal Form Submit */
            $('button#review_submit').click(function (e) {
                e.preventDefault();

                var countryCode = defaultCountry;

                var reviewTitle = $('#reviewTitle');
                var reviewText = $('#reviewText');
                var reviewerName = $('#reviewerName');
                var operatorId = $('#operator_id');

                if (reviewerName.val() === '') {
                    reviewerName.val('Anonymous');
                }

                if (!reviewTitle.val()) {
                    toastr["error"]("You need to provide title for this rating.")
                } else if (!reviewText.val()) {
                    toastr["error"]("You need to provide comments/remarks for this rating.")
                } else {
                    var reviewData = new FormData($('#operator-review')[0]);
                    var operatorId = $('#operator-review').find('input[name="operator_id"]').val();
                    var url = "{{ url('/operator/review') }}";
                    url+='/'+operatorId;

                    $.ajax({
                        type: 'POST',
                        url: url,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: reviewData,
                        error:function(err){
                            $('#reviewModal_operator button#review_submit').removeClass('disabled');
                            $("#reviewModal_operator").modal('hide');

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
                            grecaptcha.reset();

                        },
                        success:function(data){
                            $('#reviewModal_operator button#review_submit').removeClass('disabled');
                            if (data['message'] == 'success') {
                                $("#reviewModal_operator").modal('hide');

                                if(typeof(data['tryouts_left'])!='undefined'){
                                    if(data['tryouts_left']>0){
                                        //toastr.warning('Нou have '+data['tryouts_left']+' more attempts!');
                                    } else {
                                        toastr.warning('You have reached the maximum number of allowed reviews per operator and day!');
                                    }
                                }

                                if($('body').hasClass('webview-body')){
                                    setTimeout(function(){
                                        location.reload();
                                    },2500);
                                } else {
                                    var redir = '/reviews/' + countryCode + '/#tab-' + data['operatorId'];
                                    setTimeout(function(){
                                        location.href = redir;
                                    },2500);
                                }
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


           doReadmore();


        });
    </script>
    <style>
            .category-description-rating,
            .category-description-quality,
            .category-description-experience,
            .category-description-price {
                display: inline-block;
                overflow: hidden;
            }
        @media only screen and (max-width: 768px) {
            .category-description-rating,
            .category-description-quality,
            .category-description-experience,
            .category-description-price {
                max-height: 42px;
                display: inline-block;
                overflow: hidden;
            }
        }
    </style>
@endsection