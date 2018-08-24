<!-- Content Header (Page header) -->
<section class="content-header" style="margin-top:-30px;padding-top:5px;padding-bottom:10px;">
    <div class="pull-right" style="margin-right:10px;">
        <select class="select_country form-control">
            @foreach($countries['data'] as $name=>$code)
                @if(strtolower($code) == $countries['default'])
                    <option value="{{strtolower($code)}}" selected="selected">{{$name}}</option>
                @else
                    <option value="{{strtolower($code)}}">{{$name}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <h3>
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h3>
</section>