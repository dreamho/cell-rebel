@foreach($categoryScore['operators'][0]['scores'] as $key=>$score)
    @if($key > 0)
        <div class="small">{{$score['name']}}: {{$score['value']}}</div>
        <div class="progress progress-mini" style="margin-bottom: 10px;">
            <div style="width: {{((int)$score['value']/10)*100}}%;background-color: {{$score['color']}};" class="progress-bar"></div>
        </div>
    @endif
@endforeach
