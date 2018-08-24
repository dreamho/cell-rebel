@if($category['id'] === 'experience')
<div class=progress-graphs>
    <div class="small text-left">User Rating</div>
    <div class="m-t-xs m-b-xxs text-left">
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
</div>
@endif
