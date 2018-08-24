<!--
        Will receive the following data :
        1. categories = score categories:
        2. rankScore = mobile operator's level ranking  scores
-->
@foreach($categories as $key => $category)
<div id="tab-{{$level}}-{{$category['id']}}" class="tab-pane {{($key === 0) ? 'active' : ''}}">
    <div class="pull-right text-right" style="margin:20px;">
        <h4>{{$category['caption']}} in
            @if($level==='national')
                {{$rankScore[$category['id']]['location']['countryName']}}
            @elseif($level==='capital')
                {{$rankScore[$category['id']]['location']['cityName']}}
            @else
                {{ucwords($level)}} of {{$rankScore[$category['id']]['location']['countryName']}}
            @endif
        </h4>
        <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing</small>
    </div>
    <div class="sidebar-title">
        <div style="float:left;width:30px;margin: -20px 25px 0 -10px;font-size:4em;">
            <i class="fa fa-trophy text-warning"></i>
        </div>
        <h3 style="color:#1ab394">{{$rankScore[$category['id']]['operators'][0]['mobileOperator']}}</h3>
        <small>Best Operator
            @if($level==='national' && isset($rankScore[$category['id']]['location']))
                in {{$rankScore[$category['id']]['location']['countryName']}}
            @elseif($level==='capital' && isset($rankScore[$category['id']]['location']))
                in {{$rankScore[$category['id']]['location']['cityName']}}
            @elseif(isset($rankScore[$category['id']]['location']))
                in {{ucwords($level)}} of {{$rankScore[$category['id']]['location']['countryName']}}
            @endif
            in terms of {{strtolower($category['caption'])}}</small>
    </div>
    <div class="panel-body">
        @include('ptypev1.partials.widgets.score-category-summary', ['category' => $category, 'categoryScore' => $rankScore[$category['id']]])
        <!--
            Apply the change of layout here (from comment item no. 1)

             1. top 5 operators on the same row
             2. the same format for all (use best operator template)
             3. trophy representation
                1st : Gold
                2nd : Silver
                3rd : Bronze
                oth : Dark Gray
        -->
        <div class="row">
            <div class="col-lg-5">
                @include('ptypev1.partials.widgets.bestoperator', ['categoryScore' => $rankScore[$category['id']]])
            </div>
            <!-- Other Operators -->
            <div class="col-lg-7">
                @include('ptypev1.partials.widgets.otheroperator', ['categoryScore' => $rankScore[$category['id']]])
            </div>
        </div>
    </div>
</div>
@endforeach