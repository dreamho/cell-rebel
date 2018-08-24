@extends('ptypev2.app')

@section('title') About @endsection

@section('css')
    <link href="{{asset('plugins/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/toastr/toastr.min.css')}}" rel="stylesheet">
@endsection

@section('content_title')
    About CellRebel
@endsection

@section('content_description')
    <br/>short description goes here
@endsection



@section('main-content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel container-white-rounded">
                <div class="panel-body">
                    <h5>Subtitle 1</h5>
                    <p>
                    Spicy jalapeno deserunt officia ad alcatra, in rump exercitation meatloaf t-bone ribeye. Corned beef bresaola qui, dolore tail ham non. Jerky pork shank, voluptate short ribs incididunt sint ut dolor duis strip steak. Rump pork loin incididunt short loin duis meatloaf veniam est.
                    </p>
                    <p>
                    Eiusmod nostrud venison beef cupim proident deserunt do dolore sed pork belly eu porchetta andouille ad. Cillum turkey id drumstick chuck aute short loin eu brisket. Ullamco beef ribs consectetur tenderloin, shoulder ut sint picanha mollit ham ipsum cupidatat. Beef ribs occaecat t-bone meatloaf commodo pork chop tri-tip ut nostrud voluptate ipsum drumstick ullamco. Ex pork porchetta laborum laboris. Chuck ham hock magna tongue alcatra tenderloin ribeye sausage consectetur.
                    </p>
                    <h5>Subtitle 2</h5>
                    <p>
                    Ribeye pork belly sunt tail officia sed landjaeger enim chuck jerky do. Ut et pork belly, frankfurter magna ground round consequat cillum in picanha landjaeger sunt fugiat tempor. Ea ipsum leberkas shoulder tenderloin. Mollit drumstick duis, turducken elit pancetta ex cupidatat picanha est magna ham hock dolor beef ribs kielbasa. Drumstick aliqua irure shank burgdoggen est. Capicola picanha est dolore.
                    </p>
                    <h5>Subtitle 3</h5>
                    <p>
                    Ad kevin short ribs do bresaola bacon aute ipsum spare ribs turkey pork sirloin turducken sed. Ea t-bone boudin nulla excepteur, nisi veniam kevin eiusmod. Drumstick eiusmod beef leberkas ex, reprehenderit ea bacon in jowl prosciutto pig chicken magna. Voluptate leberkas chicken laborum nisi consectetur hamburger. Rump mollit kevin, fugiat reprehenderit hamburger do prosciutto.
                    </p>
                    <p>
                    Hamburger deserunt tenderloin id, turducken tail capicola flank anim pancetta meatball short ribs sausage tempor. Deserunt turducken sint, kielbasa id nostrud ham hock ground round. Picanha salami pork chop flank excepteur, qui enim et beef consectetur. Dolore voluptate short ribs mollit, meatloaf pastrami alcatra culpa magna nulla. Reprehenderit ea culpa dolor minim, pastrami id shank cow shoulder nulla dolore buffalo spare ribs strip steak. Sint rump cupim eu, tri-tip officia aliquip flank in non boudin turducken ullamco.
                    </p>
                    <p>
                    Does your lorem ipsum text long for something a little meatier? Give our generator a try… it’s tasty!
                    </p>
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
//            toastr.success('About Wireless Ranking has been loaded.');

            $("ul.navbar-nav").children().removeClass('active');
            $("a#about").parent().addClass('active')
        });
    </script>
@endsection