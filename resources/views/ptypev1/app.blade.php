<!DOCTYPE html>
<html lang="en">
@include('ptypev1.partials.htmlheader')

<body class="top-navigation">
{{--<body>--}}
    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            @include('ptypev1.partials.mainheader')

            <div class="wrapper wrapper-content animated fadeIn">
                @include('ptypev1.partials.contentheader')
                <!-- Your Page Content Here -->
                @yield('main-content')
            </div>

            @include('ptypev1.partials.footer')
            @include('ptypev1.partials.rightsidebar')
        </div>
    </div>

    @include('ptypev1.partials.scripts')
</body>
</html>
