<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
@include('layouts.partials.htmlheader')

<body class="skin-blue layout-top-nav">
    <div class="wrapper">
        @include('ranking.partials.mainheader')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('layouts.partials.contentheader')
            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('main-content')
            </section><!-- /.content -->
        </div>

        @include('layouts.partials.footer')
    </div>

    @include('layouts.partials.scripts')
</body>
</html>
