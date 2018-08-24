<div class="modal inmodal" id="reviewModal_operator" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <form id="operator-review">
                {{ csrf_field() }}
            	<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    
                    <h4 class="modal-title"><i class="fa fa-edit modal-icon"></i> Review <span class="operator"></span></h4>
                    <!--<small class="font-bold">Lorem Ipsum is simply dummy text of the objective you wanted to accomplished here.</small>-->
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <div class="form-group">
                        <p>Publish your view of your experience with <span class="operator"></span></p>
                        <p><strong>Title</strong></p>
                        <input name="reviewTitle" id="reviewTitle" class="form-control" /><br/>
                        <p><strong>Comments / Remarks</strong></p>
                        <textarea name="reviewText" id="reviewText" rows="3" class="form-control"></textarea><br/>
                        <p><strong>Your Name</strong></p>
                        <input name="reviewerName" id="reviewerName" class="form-control" />
                    </div>
                    <div class="form-group">
						<p>
                            <strong>How would you rate your experience with <span class="operator"></span></strong>
                        </p>
                        <small class="text-muted inline">POOR</small>
                        <div class="inline">
   							<input name="ux_rating" value="0" id="ux_rating" class="rating" data-icon-lib="fa" data-active-icon="fa-star text-warning p-xxs" data-inactive-icon="fa-star text-default p-xxs" type="number"/>
                        </div>
                        <small class="text-muted inline">EXCELLENT</small>
                    </div>
                </div>
                {{ Form::hidden('operator_id') }}
                {{ Form::hidden('operator_name') }}
                <textarea style="display: none;" name="device_data"></textarea>
                <div class="modal-footer">
                    <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_V2_SITE_KEY')}}"></div>
                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="review_submit">Publish</button>
                    {{--<button type="button" class="btn btn-primary" data-dismiss="modal">Publish with Facebook</button>--}}
                </div>
            </form>
        </div>
    </div>
</div>