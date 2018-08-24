<div class="modal inmodal" id="rateModal_operator" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <form id="operator-rating">
              {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    
                    <h4 class="modal-title"><i class="fa fa-star modal-icon"></i> Rate <span class="operator"></span> Now.</h4>
                    <!--<small class="font-bold">Lorem Ipsum is simply dummy text of the objective you wanted to accomplished here.</small>-->
                </div>
                <div class="modal-body p-sm">
                    <!--<p class="hidden-xs"><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting
                        industry. It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged.</p>-->
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
                                   data-active-icon="fa-star text-warning p-xxs"
                                   data-inactive-icon="fa-star text-default p-xxs"
                            />
                        </div>
                        <small class="text-muted inline">EXCELLENT</small>
                        <hr/>
                        <p>
                            <strong>How likely is it that you would recommend <span class="operator"></span> to a friend
                                or your family?</strong>
                        </p>
                        <div class="hidden-xs">
                            <small class="text-muted inline">NOT LIKELY</small>
                            <div class="inline">
                                <input type="number"
                                       name="recommend_rating"
                                       id="recommend_rating"
                                       class="rating"
                                       data-min="1"
                                       data-max="11"
                                       data-icon-lib="fa"
                                       data-active-icon="fa-thumbs-up text-warning p-xxs"
                                       data-inactive-icon="fa-thumbs-up text-default p-xxs"
                                />
                            </div>
                            <small class="text-muted inline">VERY LIKELY</small>
                        </div>
                        
                        <!-- Mobile Only -->
                        <div class="hidden-lg hidden-md hidden-sm">
                            <small class="text-muted inline">NOT LIKELY</small>
                            <div class="inline">
                                <input type="number"
                                       name="recommend_rating2"
                                       id="recommend_rating2"
                                       class="rating"
                                       data-min="1"
                                       data-max="11"
                                       data-icon-lib="fa"
                                       data-active-icon="fa-thumbs-up text-warning p-xxxs text-small"
                                       data-inactive-icon="fa-thumbs-up text-default p-xxxs text-small"
                                />
                            </div>
                            <small class="text-muted inline">VERY LIKELY</small>
                        </div>
                        <!-- End Mobile Only -->
                        <hr/>
                        <p>
                            <strong>How do you perceive the prices of <span class="operator"></span> services?</strong>
                        </p>
                        <small class="text-muted inline">CHEAP</small>
                        <div class="inline">
                            <input type="number"
                                   name="price_rating"
                                   id="price_rating"
                                   class="rating"
                                   data-icon-lib="fa"
                                   data-active-icon="fa-usd text-warning p-xxs"
                                   data-inactive-icon="fa-usd text-default p-xxs"
                            />
                        </div>
                        <small class="text-muted inline">EXPENSIVE</small>
                    </div>
                    {{ Form::hidden('operator_id') }}
                    {{ Form::hidden('operator_name') }}
                    <textarea style="display: none;" name="device_data"></textarea>
                </div>
                <div class="modal-footer">
                    <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_V2_SITE_KEY')}}"></div>
                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="rate_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>