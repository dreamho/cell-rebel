<div class="m-t-xs pull-right p-md">
    <i class="fa fa-star text-warning"></i>
    <i class="fa fa-star text-warning"></i>
    <i class="fa fa-star text-warning"></i>
    <i class="fa fa-star text-default"></i>
    <i class="fa fa-star text-default"></i>
</div>
<div class="sidebar-title">
    <h3><i class="fa fa-trophy text-warning"></i> {{$categoryScore['operators'][0]['mobileOperator']}}</h3>
    <small>Best Operator
        @if($level==='national' && isset($rankScore[$category['id']]['location']))
            in {{$rankScore[$category['id']]['location']['countryName']}}
        @elseif($level==='capital' && isset($rankScore[$category['id']]['location']))
            in {{$rankScore[$category['id']]['location']['cityName']}}
        @elseif(isset($rankScore[$category['id']]['location']))
            in {{ucwords($level)}} of {{$rankScore[$category['id']]['location']['countryName']}}
        @endif
        in terms of {{strtolower($category['caption'])}}
    </small>
</div>