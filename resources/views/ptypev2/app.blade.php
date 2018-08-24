<!DOCTYPE html>
<html lang="en">
    @include('ptypev2.partials.htmlheader')
    <body class="top-navigation @yield('body-cls')">
        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                @section('mainheader')
                    @include('ptypev2.partials.mainheader')
                @show
                <div class="wrapper wrapper-content animated fadeIn">
                    @section('contentheader')
                        @include('ptypev2.partials.contentheader')
                    @show
                    @yield('main-content')


                        @section('stores')
                            @include('ptypev2.partials.stores')
                        @show
                </div>
                @section('footer')
                    @include('ptypev2.partials.footer')
                @show
            </div>
        </div>
        <!-- Scripts -->
        @include('ptypev2.partials.scripts')
        <script type="text/javascript">

            $(function(){
                if((typeof(Android)!='undefined')&&(typeof(Android['Ready'])=='function')) {
                    Android.Ready();
                }
            });

            $(function(){
                function formatCountry (country) {
                    if (!country.id) { return country.text; }
                    var $country = $(
                        '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared flag-icon-rounded flag-icon-medium"></span>' +
                        '<span class="flag-text">'+ '&nbsp;' + country.text+"</span>"
                    );
                    return $country;
                };
                function formatCountrySmallIcon (country) {
                    if (!country.id) { return country.text; }
                    var $country = $(
                        '<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +' flag-icon-squared flag-icon-rounded flag-icon-small"></span>' +
                        '<span class="flag-text">'+ '&nbsp;' + country.text+"</span>"
                    );
                    return $country;
                };

                /* Setup Country Selections */
                var countryList = $(".select_country").select2({
                    placeholder: "Select a country",
                    templateResult: formatCountrySmallIcon,
                    templateSelection: formatCountry,
                    allowClear: false
                });

                $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');
                $('b[role="presentation"]').hide();

                countryList.change(function () {
                    var code = countryList.select2('data')[0].id;
                    var url = window.location.toString();
                    if (url.indexOf('ranks') > 0 || url === window.location.protocol + "//" + window.location.hostname + "/") {
                        window.location = '/ranks/' + code;
                    }
                    if (url.indexOf('reviews') > 0) {
                        window.location = '/reviews/' + code;
                    }
                });

                var name = $(".select_country :selected").text();
            });
        </script>
    </body>
</html>