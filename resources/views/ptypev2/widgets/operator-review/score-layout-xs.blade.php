@if($index %3 === 0)
    <div class="clearfix hidden-sm hidden-md hidden-lg"></div>
@endif
<div class="col-xs-4 text-center hidden-sm hidden-md hidden-lg">
    <input type="text" class="knob"
           data-readonly="true"
           data-thickness="0.2"
           data-angleArc="250"
           data-angleOffset="-125"
           value="{{$score['value']}}"
           data-max="10"
           data-width="40"
           data-height="40"
           data-fgColor="{{$score['color']}}">
    <div class="knob-label">{{$score['name']}}</div>
</div>