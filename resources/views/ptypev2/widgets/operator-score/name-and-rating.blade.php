<div class="sidebar-title" style="padding-bottom:5px; border-bottom:none; @if(in_array($category['id'], ['quality','price','experience'])) height: 50px; @else height: 80px; @endif">
    @if($index === 0)
        <h3 class="operator_title_{{$category['id']}} text-center"  style="font-size: 1.6em"><i class="fa fa-trophy text-gold"></i> {{$operator['mobileOperator']}}</h3>
    @elseif($index === 1)
        <h3 class="operator_title_{{$category['id']}} text-center" style="font-size: 1.6em"><i class="fa fa-trophy text-silver"></i> {{$operator['mobileOperator']}}</h3>
    @elseif($index === 2)
        <h3 class="operator_title_{{$category['id']}} text-center" style="font-size: 1.6em"><i class="fa fa-trophy text-bronze"></i> {{$operator['mobileOperator']}}</h3>
    @else
        <h3 class="operator_title_{{$category['id']}} text-center" style="font-size: 1.6em">{{$operator['mobileOperator']}}</h3>
    @endif
    
    @if(($category['id'] == 'experience'))
        {{--<div class="m-t-xs text-center">--}}
            {{--<span>--}}
            {{--@for($i=1; $i<=5; $i++)--}}
                {{--@if($i <= $operator['operatorRatingFloat'])--}}
                    {{--<span class="cr-star" ><i class="fa fa-star text-yellow"></i></span>--}}
                {{--@else--}}
                    {{--@if (($operator['halfStar']==1)&&($i==$operator['operatorRating']+1))--}}
                    {{--<span  class="cr-star">--}}
                        {{--<i class="fa fa-star-half-o text-yellow"></i>--}}
                    {{--</span>--}}
                    {{--@else--}}
                    {{--<span class="cr-star"><i class="fa fa-star-o" style="color:lightgrey"></i></span>--}}
                    {{--@endif--}}
                    {{----}}
                {{--@endif--}}
            {{--@endfor--}}
            {{--</span>--}}
        {{--</div>--}}
    @elseif(($category['id'] == 'price')||($category['id'] == 'rating_off')||($category['id'] == 'quality'))
    
    @else 
    <div class="m-t-xs text-center">
        @for($i=1; $i<=5; $i++)
            @if($i <= $operator['operatorRatingFloat'])
                <span class="cr-star" ><i class="fa fa-star text-yellow"></i></span>
            @else
                @if (($operator['halfStar']==1)&&($i==$operator['operatorRating']+1))
                <span  class="cr-star">
					<i class="fa fa-star-half-o text-yellow"></i>
		    	</span>
                @else
                <span class="cr-star"><i class="fa fa-star-o" style="color:lightgrey"></i></span>
                @endif
            @endif
        @endfor
    </div>
    @endif
</div>