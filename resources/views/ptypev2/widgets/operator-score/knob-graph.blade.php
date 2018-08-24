<div class="row  Knob-Graphs">
    {{-- Load Knob Graphs--}}
    @if($category['id'] === 'rating')
    @elseif($category['id'] === 'quality')
        <div class="col-xs-6">
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][0]['value']}}"
                   data-max="10"
                   data-width="80"
                   data-height="80"
                   data-fgColor="{{$operator['scores'][0]['color']}}">
            <div class="knob-label">{{$operator['scores'][0]['name']}}</div>
        </div>
        <div class="col-xs-6">
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][3]['value']}}"
                   data-max="10"
                   data-width="80"
                   data-height="80"
                   data-fgColor="{{$operator['scores'][3]['color']}}">
            <div class="knob-label">{{$operator['scores'][3]['name']}}</div>
        </div>
    @elseif($category['id'] === 'experience')
        <div class="col-xs-12">
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][2]['value']}}"
                   data-max="10"
                   data-width="90"
                   data-height="90"
                   data-fgColor="{{$operator['scores'][2]['color']}}">
            <div class="knob-label">{{$operator['scores'][2]['name']}}</div>
        </div>

        {{--<div class="col-xs-6">--}}
            {{--@if($operator['scores'][1]['value'] >= 0)--}}
            {{--<input type="text" class="knob"--}}
                   {{--data-readonly="true"--}}
                   {{--data-thickness="0.2"--}}
                   {{--data-angleArc="250"--}}
                   {{--data-angleOffset="-125"--}}
                   {{--value="{{$operator['scores'][1]['value']}}"--}}
                   {{--data-max="10"--}}
                   {{--data-width="80"--}}
                   {{--data-height="80"--}}
                   {{--data-fgColor="{{$operator['scores'][1]['color']}}">--}}
            {{--@else--}}
            {{--<div class="price-will-be-updated">Price will be updated</div>--}}
            {{--@endif--}}
            {{--<div class="knob-label">{{$operator['scores'][1]['name']}}</div>--}}
        {{--</div>--}}
    @elseif($category['id'] === 'price')
        <div class="col-xs-12">
            @if($operator['scores'][0]['value'] >= 0)
            <input type="text" class="knob"
                   data-readonly="true"
                   data-thickness="0.2"
                   data-angleArc="250"
                   data-angleOffset="-125"
                   value="{{$operator['scores'][0]['value']}}"
                   data-max="10"
                   data-width="90"
                   data-height="90"
                   data-fgColor="{{$operator['scores'][0]['color']}}">
            @else
            <div class="price-will-be-updated">Price will be updated</div>
            @endif
            <div class="knob-label">{{$operator['scores'][0]['name']}}</div>
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
                   data-width="90"
                   data-height="90"
                   data-fgColor="{{$operator['scores'][0]['color']}}">
            <div class="knob-label">{{$operator['scores'][0]['name']}}</div>
        </div>
    @endif
</div>