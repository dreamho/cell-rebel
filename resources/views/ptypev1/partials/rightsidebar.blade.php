<div id="right-sidebar" style="margin-top:-10px;">
    <div class="sidebar-container">
        <ul class="nav nav-tabs navs-3">
            <li class="active"><a data-toggle="tab" href="#tab-1">
                    Levels
                </a></li>
            <li><a data-toggle="tab" href="#tab-2">
                    Operators
                </a></li>
            <li class=""><a data-toggle="tab" href="#tab-3">
                    <i class="fa fa-gear"></i>
                </a></li>
        </ul>

        <div class="tab-content">
            @include('ptypev1.partials.sbtab-levels')
            @include('ptypev1.partials.sbtab-operators')
            @include('ptypev1.partials.sbtab-settings')
        </div>
    </div>
</div>