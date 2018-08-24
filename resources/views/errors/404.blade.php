@extends('ptypev2.app')

@section('title')
    Operator Rankings
@endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet"/>
@endsection

@section('content_title')
    {{--Mobile Operator Ranking--}}
@endsection
@section('content_description')
    {{--<br/>Find out which mobile operator that provides the best service in every country!--}}
@endsection

@section('main-content')

    <div class="error-page text-center">
        <h2 class="headline text-yellow">404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
            <p class="text-center">
                We could not find the page you were looking for.
            </p>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script>
        var defaultCountry = "{{ $countries['default'] }}";

        $(document).ready(function () {

            /* Setup Country Selections */
            var countryList = $(".select_country").select2({
                placeholder: "Select a country",
                allowClear: false
            });

            $('b[role="presentation"]').hide();
            $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');

            countryList.change(function () {
                var code = countryList.select2('data')[0].id;
                window.location = '/ranks/' + code;
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
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        });
    </script>
@endsection