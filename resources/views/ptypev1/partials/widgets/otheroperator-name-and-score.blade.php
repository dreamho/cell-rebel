<div class="m-t-xs pull-right p-md">
    <i class="fa fa-star text-warning"></i>
    <i class="fa fa-star text-warning"></i>
    <i class="fa fa-star text-warning"></i>
    <i class="fa fa-star text-default"></i>
    <i class="fa fa-star text-default"></i>
</div>
<div class="sidebar-title">
    <h4>{{$operator['mobileOperator']}}</h4>
</div>
<div style="padding:10px;">
    <div class="small">{{$operator['scores'][0]['name']}}: {{$operator['scores'][0]['value']}}</div>
    <div class="progress progress-mini" style="margin-bottom: 10px;">
        <div style="width: {{((int)$operator['scores'][0]['value']/10)*100}}%;color:{{$operator['scores'][0]['color']}};" class="progress-bar"></div>
    </div>
</div>