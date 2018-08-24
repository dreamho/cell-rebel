<div class="sidebar-title">
    <h3><i class="fa fa-wifi"></i> Other Operators in {{ucwords($categoryScore['location']['countryName'])}}</h3>
    <small class="text-muted">Other Operators' scores in {{ucwords($categoryScore['location']['countryName'])}} in terms of network quality</small>
</div>
<!-- Other Operator Listing  -->
<div class="white-bg" style="margin-top:10px; padding:5px;font-size:12px;">
    <div>
        <div class="row">
            @foreach($categoryScore['operators'] as $key=>$operator)
                @if($key > 0)
                    <div class="col-sm-6 col-xs-12">
                        @include('ptypev1.partials.widgets.otheroperator-info', ['operator' => $operator])
                    </div>
                @endif
            @endforeach
            {{--<div class="col-sm-6 col-xs-12">--}}
                {{--@include('ptypev1.partials.widgets.otheroperator-info')--}}
            {{--</div>--}}
        </div>
    </div>

</div>
<!-- End Other Operator Listing -->