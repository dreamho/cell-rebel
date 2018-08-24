<div style="clear: both;"></div>
<div class="sidebar-title" style="padding:10px;margin-top:10px;">
    <div class="row">
        <div class="text-center">
    {{--        <button class="btn btn-xs btn-primary" type="button" data-toggle="modal", data-target="#rateModal_{{str_replace(' ','_', $operator['mobileOperator'])}}">--}}
            <div class="col-xs-6">
                <button class="btn btn-md btn-primary rate-button"
                        type="button"
                        data-toggle="modal"
                        data-target="#rateModal_operator"
                        data-field="header"
                        data-operator="{{str_replace(' ','_', $operator['mobileOperator'])}}"
                        data-operatorId="{{$operator['mobileOperatorId']}}">
                    <i class="fa fa-star"></i> Rate
                </button>
            </div>
            <div class="col-xs-6">
                <button class="btn btn-md btn-success review-button"
                        type="button"
                        data-toggle="modal",
                        data-target="#reviewModal_operator"
                        data-field="header"
                        data-operator="{{str_replace(' ','_', $operator['mobileOperator'])}}"
                        data-operatorId="{{$operator['mobileOperatorId']}}">
                    <i class="fa fa-edit"></i> Review
                </button>
            </div>
            {{--<div class="btn-group">--}}
                {{--<button data-toggle="dropdown" class="btn btn-xs btn-warning" type="button">--}}
                    {{--<i class="fa fa-copy"></i> Compare--}}
                    {{--<span class="caret"></span>--}}
                {{--</button>--}}
                {{--<ul class="dropdown-menu">--}}
                    {{--@foreach($categoryScore['operators'] as $m_operator)--}}
                        {{--@if($operator != $m_operator)--}}
                            {{--<li><a href="#">{{$m_operator['mobileOperator']}}</a></li>--}}
                        {{--@endif--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
</div>