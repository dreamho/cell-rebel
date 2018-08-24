<div class="row">
    {{-- Load Knob Graphs--}}
    @if($category['id'] === 'experience')
        <div class="col-xs-6">
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][0]['value']}}"
                   data-max="10"
                   data-width="60"
                   data-height="60"
                   data-fgColor="{{$operator['scores'][0]['color']}}">
            <div class="knob-label">{{$operator['scores'][0]['name']}}</div>
        </div>
        <div class="col-xs-6">
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][1]['value']}}"
                   data-max="10"
                   data-width="60"
                   data-height="60"
                   data-fgColor="{{$operator['scores'][1]['color']}}">
            <div class="knob-label">{{$operator['scores'][1]['name']}}</div>
        </div>
    @else
        <div class="col-xs-12">
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][0]['value']}}"
                   data-max="10"
                   data-width="70"
                   data-height="70"
                   data-fgColor="{{$operator['scores'][0]['color']}}">
            <div class="knob-label">{{$operator['scores'][0]['name']}}</div>
        </div>
    @endif
</div>