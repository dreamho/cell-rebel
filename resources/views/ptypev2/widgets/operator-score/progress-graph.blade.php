<div class="progress-graphs progress-graphs-{{$category['id']}}">
@foreach($operator['scores'] as $key=>$score)
    @if($category['id'] === 'quality')

            @if($key == 0)
            <div class="row">
            <div class="col-lg-6 text-center">
            @elseif($key == 3)
            </div>
            <div class="col-lg-6 text-center">
            @elseif(($key == 6)||($key == 7))
               @if(!empty($score['value']))
                   <div class="row">
                    <span>
                        <strong style="width: 100px;display: inline-block;">{{$score['name']}}:</strong>&nbsp;
                        <span style="width: 50px;display: inline-block;text-align: left;">{{$score['value']}}</span>
                    </span>
                   </div>
                @endif
            @else
            <span class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}" name="{{$level}}-{{strtolower($score['name'])}}">
                <div class="small text-left">{{$score['name']}}</div>
                <div class="progress progress-mini" style="margin-bottom: 10px;">
                    <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>
                </div>
            </span>
            @endif
            @if($key == 5)
            </div>
            </div>
            @endif
            
    
    @elseif($category['id'] === 'experience')
    {{--
        @if($key > 1)
            <span class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}" name="{{$level}}-{{strtolower($score['name'])}}">
                <div class="small text-left">{{$score['name']}}: {{$score['value']}}</div>
                <div class="progress progress-mini" style="margin-bottom: 10px;">
                    <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>
                </div>
            </span>
        @endif
    --}}
        @if($key < 2)
            <span class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}" name="{{$level}}-{{strtolower($score['name'])}}">
                <div class="small text-left">{{$score['name']}}: <span class="pull-right">{{$score['value']}}</span></div>
                <div class="progress progress-mini" style="margin-bottom: 10px;">
                    <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>
                </div>
            </span>
        @endif
    @elseif($category['id'] === 'rating')

        <span class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}"
              name="{{$level}}-{{strtolower($score['name'])}}" style="min-width: 200px;display: inline-block;">
            <div style="margin:0 auto;display: inline-block;">
                <div class="small text-left">{{$score['name']}} </div>
                    <div class="progress progress-mini" style="margin-bottom: 10px;">
                        <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};"
                             class="progress-bar"></div>
                    </div>
                    <div class="small text-left progress-value">&nbsp;&nbsp;{{$score['displayValue']}}</div>
                </div>
        </span>
            
        
    @elseif($category['id'] === 'price')
        @if($key > 0)
            @if($key == 1)
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <h5>PRE-PAID</h5>
            @endif
            @if($key == 4)
                </div>
                <div class="col-lg-6 text-center">
                    <h5>POST-PAID</h5>
            @endif
                    <span class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}" name="{{$level}}-{{strtolower($score['name'])}}">
                        <div class="small text-left">{{$score['name']}}</div>
                        <div class="progress progress-mini" style="margin-bottom: 10px;">
                            <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>
                        </div>
                    </span>
        @endif
        @if($key == 6)
                    </div>
                </div>
        @endif

        {{--@if($key > 0)--}}
          {{--<span class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}" name="{{$level}}-{{strtolower($score['name'])}}">--}}
                {{--<div class="small text-left">{{$score['name']}}: {{$score['displayValue']}}</div>--}}
                {{--<div class="progress progress-mini" style="margin-bottom: 10px;">--}}
                    {{--<div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>--}}
                {{--</div>--}}
            {{--</span>  --}}
        {{--@endif--}}
    @else
        @if($key > 0)
            {{--<a class="progress-link" data-toggle="tab" href="#tab-{{$level}}-{{strtolower($score['name'])}}" name="{{$level}}-{{strtolower($score['name'])}}">--}}
                <div class="small text-left">{{$score['name']}}: {{$score['value']}}</div>
                <div class="progress progress-mini" style="margin-bottom: 10px;">
                    <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>
                </div>
            {{--</a>--}}
        @endif
    @endif
@endforeach
</div>