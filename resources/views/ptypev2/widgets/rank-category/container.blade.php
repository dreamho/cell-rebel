@foreach($categories as $key => $category)
    <div id="tab-{{$level}}-{{$category['id']}}" class="tab-pane {{($key === 0) ? 'active' : ''}}">
         <div class="tab-caption-src" style="display: none;">
       {{-- Load rank category header (Selected Category) --}}
            @include('ptypev2.widgets.rank-category.header-selected')
       </div>
       <div class="tab-best-src" style="display: none;">
       {{-- Load rank category header (Top Operator)--}}
          @include('ptypev2.widgets.rank-category.header-best-operator')
       </div>
        {{-- Load rank category scores--}}
        <div class="panel-body">
            <div class="m-l-n-sm m-r-n-sm scores-info-pc">
                <strong>Best {{$category['caption']}}</strong>

                <p class="category-description-{{$category['id']}}">{{$category['descr']}}</p>
            </div>

            @include('ptypev2.widgets.operator-score.container', ['categoryScore' => $rankScore[$category['id']]])
        </div>
    </div>
@endforeach