{{--<div class="modal inmodal" id="rateModal_{{str_replace(' ','_', $operator['mobileOperator'])}}" tabindex="-1" role="dialog" aria-hidden="true">--}}
<div class="modal inmodal" id="rateModal_operator" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            {{--{{ Form::open (array('url' => '/operator/rate')) }}--}}
            <form id="operator-rating">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-star modal-icon"></i>
                <h4 class="modal-title">Rate <span class="operator"></span> Now.</h4>
                <small class="font-bold">Lorem Ipsum is simply dummy text of the objective you wanted to accomplished here.</small>
            </div>
            <div class="modal-body">
                <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged.</p>

                    <div class="form-group">
                        <p>
                            <strong>How would you rate your experience with <span class="operator"></span></strong>
                        </p>
                        <small class="text-muted inline">POOR</small>
                        <div class="inline">
                            <input type="number"
                                   name="ux_rating"
                                   id="ux_rating"
                                   class="rating"
                                   data-icon-lib="fa"
                                   data-active-icon="fa-star text-warning fa-2x"
                                   data-inactive-icon="fa-star text-default fa-2x"
                            />
                        </div>
                        <small class="text-muted inline">EXCELLENT</small>
                        {{--<input id="range_ux_{{str_replace(' ','_', $operator['mobileOperator'])}}" type="text" name="range_ux_{{str_replace(' ','_', $operator['mobileOperator'])}}" value="">--}}
                        <hr/>
                        <p>
                            <strong>How likely is it that you would recommend <span class="operator"></span> to a friend
                                or your family?</strong>
                        </p>
                        <small class="text-muted inline">NOT LIKELY</small>
                        <div class="inline">
                            <input type="number"
                                   name="recommend_rating"
                                   id="recommend_rating"
                                   class="rating"
                                   data-min="1"
                                   data-max="10"
                                   data-icon-lib="fa"
                                   data-active-icon="fa-star text-warning fa-2x"
                                   data-inactive-icon="fa-star text-default fa-2x"
                            />
                        </div>
                        <small class="text-muted inline">VERY LIKELY</small>
                        {{--<input id="range_recommend_{{str_replace(' ','_', $operator['mobileOperator'])}}" type="text" name="range_recommend_{{str_replace(' ','_', $operator['mobileOperator'])}}" value="">--}}
                    </div>
                    {{ Form::hidden('operator_id') }}
                    {{ Form::hidden('operator_name') }}
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="rate_submit">Submit</button>
            </div>
            {{--{{ Form::close() }}--}}
            </form>
        </div>
    </div>
</div>