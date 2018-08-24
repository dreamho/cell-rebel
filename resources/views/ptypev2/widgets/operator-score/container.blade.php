<div class="row row-fix">
    {{--@if(count($categoryScore['operators']) === 2)--}}
        {{--@include('ptypev2.widgets.operator-score.col-2-layout')--}}
    @if(count($categoryScore['operators']) < 4)
        @include('ptypev2.widgets.operator-score.col-3-layout')
    @elseif(count($categoryScore['operators']) === 4 || count($categoryScore['operators']) === 5)
        @include('ptypev2.widgets.operator-score.col-4-layout')
    @elseif(count($categoryScore['operators']) >= 6)
        @include('ptypev2.widgets.operator-score.col-5-layout')
    @endif
</div>