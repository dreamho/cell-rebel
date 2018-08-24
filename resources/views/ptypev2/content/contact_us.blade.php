@extends('ptypev2.app')

@section('title') Contact Us @endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endsection


@section('content_title')
    Contact Us
@endsection

@section('content_description')
    <br/>If you have any questions or suggestions, please drop us a note.
@endsection

@section('main-content')

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel container-white-rounded">
                <div class="panel-body">

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    {!! Form::open(['url'=>'/contact']) !!}

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {!! Form::label('Name:') !!}
                        {!! Form::text('name', old('name'), ['class'=>'form-control', 'placeholder'=>'Enter Name']) !!}
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>

                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('Email:') !!}
                        {!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>'Enter Email']) !!}
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    </div>

                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        {!! Form::label('Message:') !!}
                        {!! Form::textarea('message', old('message'), ['class'=>'form-control', 'placeholder'=>'Enter Message']) !!}
                        <span class="text-danger">{{ $errors->first('message') }}</span>
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_V2_SITE_KEY')}}"></div>
                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success pull-right" style="width: 100px;">Send</button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection



@section('scripts')
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            /* Setup Country Selections */
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
//            toastr.success('wireless Ranking Contact Us has been loaded.');

            $("ul.navbar-nav").children().removeClass('active');
            $("a#contact").parent().addClass('active');
        });
    </script>
@endsection