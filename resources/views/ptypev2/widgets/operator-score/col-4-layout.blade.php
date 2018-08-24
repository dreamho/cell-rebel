@foreach($categoryScore['operators'] as $index => $operator)
    @if($index %4 === 0)
        {{--<div class="clearfix"></div>--}}
    @endif
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 p-xs">
        <div class="container-white-rounded">
        {{-- Operator Name & Rating --}}
            @include('ptypev2.widgets.operator-score.name-and-rating')

            {{-- Operator Scores --}}
            <div style="margin-top:10px; padding:5px 0;font-size:12px;">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{-- Load Knob Graph --}}
                        @include('ptypev2.widgets.operator-score.knob-graph')

                        {{-- Load Scores--}}
                        @include('ptypev2.widgets.operator-score.progress-graph')

                        {{-- Load Stars small --}}
                        @include('ptypev2.widgets.operator-score.name-and-rating-small')

                        {{-- Load Buttons --}}
                        @include('ptypev2.widgets.operator-score.buttons')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach