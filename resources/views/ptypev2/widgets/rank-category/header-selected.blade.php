{{-- 
<div class="pull-right text-right" style="margin:20px;">
--}}
    <h4>{{$category['caption']}} in
        @if($level==='national')
            {{$rankScore[$category['id']]['location']['countryName']}}
        @elseif($level==='capital')
            {{$rankScore[$category['id']]['location']['cityName']}}
        @else
            {{ucwords($level)}} of {{$rankScore[$category['id']]['location']['countryName']}}
        @endif
	</h4>
    <strong>Best {{$category['caption']}}</strong>

    <p class="category-description-{{$category['id']}}">{{$category['descr']}}</p>
{{--  
</div>
--}}