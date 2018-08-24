@if(count($rankScore[$category['id']]['operators']) > 0)
<div class="sidebar-title">
    <div style="float:left;width:30px;margin: -15px 25px 0 -10px;font-size:4em;">
        <i class="fa fa-trophy text-gold"></i>
    </div>
    <h3>{{$rankScore[$category['id']]['operators'][0]['mobileOperator']}}</h3>
    <div class="scores-info-mobile" data-toggle="tooltip" data-placement="bottom" title="{{$category['descr']}}" data-html="true">
        <small style="font-size: 14px;">Best Operator
            @if($level==='national' && isset($rankScore[$category['id']]['location']))
                in {{$rankScore[$category['id']]['location']['countryName']}}
            @elseif($level==='capital' && isset($rankScore[$category['id']]['location']))
                in {{$rankScore[$category['id']]['location']['cityName']}}
            @elseif(isset($rankScore[$category['id']]['location']))
                in {{ucwords($level)}} of {{$rankScore[$category['id']]['location']['countryName']}}
            @endif
            in terms of {{strtolower($category['caption'])}}</small>&nbsp;
        <i class="glyphicon glyphicon-info-sign text-light-blue"></i>
    </div>
    <div class="scores-info-pc">
        <small style="font-size: 14px;">Best Operator
            @if($level==='national' && isset($rankScore[$category['id']]['location']))
                in {{$rankScore[$category['id']]['location']['countryName']}}
            @elseif($level==='capital' && isset($rankScore[$category['id']]['location']))
                in {{$rankScore[$category['id']]['location']['cityName']}}
            @elseif(isset($rankScore[$category['id']]['location']))
                in {{ucwords($level)}} of {{$rankScore[$category['id']]['location']['countryName']}}
            @endif
            in terms of {{strtolower($category['caption'])}}</small>
    </div>
</div>
@endif