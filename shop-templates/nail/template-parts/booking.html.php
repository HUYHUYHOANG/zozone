<!-- service booking modal -->
<div class="modal fade " id="serviceBookingModal" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header" style="background-color:var(--classic-color-1) !important;">
        <h4 class="modal-title" style="color:#FFF"></h4>
        <a class="site-buton close" data-dismiss="modal"><i class="ti-close" style="color:#FFF"></i></a>
      </div>      
      <!--begin modal body-->
	  <div class="modal-body">
		<div id="smartwizard">
			<ul class="d-flex">
				<li class="flex-fill"><a href="#time"><span><strong>1</strong><i class="fa fa-check"></i></span> {LANG_SERVICES}</a></li>
				<li class="flex-fill"><a href="#service"><span><strong>2</strong><i class="fa fa-check"></i></span> {LANG_TIME}</a></li>
				<li class="flex-fill"><a href="#details"><span><strong>3</strong><i class="fa fa-check"></i></span> {LANG_DETAILS}</a></li>
				<li class="flex-fill"><a href="#payment"><span><strong>4</strong><i class="fa fa-check"></i></span> {LANG_PAYMENT}</a></li>
				<li class="flex-fill"><a href="#done"><span><strong>5</strong><i class="fa fa-check"></i></span> {LANG_DONE}</a></li>
			</ul>
			<div>
				<div id="time" class="wizard-box">
					<h6 class="m-b30">{LANG_PLZ_SELECT_SERVICE}</h6>						
					<form class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 form-group">
							<label>Service <span class="service-duration" style="color:var(--classic-color-1);"></span></label>
							<select id="bk-services" class="selectpicker" data-live-search="true" data-show-subtext="true" multiple data-max-options="5">
								{SERVICES_BY_CATEGORY}
							</select>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 form-group" style="position:relative;">
							<label>{LANG_AVAILABLE_TIME_MSG}</label>
							<input name="dzOther[date]" class="form-control" placeholder="" id="datetimepicker" type="text" onkeydown="return false" onpaste="return false">
						</div>						
						<div class="col-lg-12 col-md-12 col-sm-12 form-group">
							<div class="row col-lg-12"><label>{LANG_STAFF}</label></div>
							<div class="container row btn-group" data-toggle="buttons" id="bk-staffs-list" data-staff-id="" data-staff-name="" style="margin:0;padding:0;"></div>							
						</div>
					</form>
				</div>
				
				<div id="service" class="">
					<h6 class="m-b5">{LANG_BOOKING} {LANG_TIME}</h6>
					<div class="" id="time-slots-content">
					</div>
				</div>
				
				<div id="details" class="">
					<h6 class="m-b5">{LANG_DETAILS}</h6>
					{LANG_RESERVATION_STEP3_MSG}
					<form class="row">
						<div class="col-lg-4 col-md-4 form-group">
							<label>{LANG_EMAIL_ADDRESS}</label>
							<input class="form-control" placeholder="support@email.com" type="email" id="bk-cemail">
						</div>
						<div class="col-lg-4 col-md-4 form-group">
							<label>{LANG_NAME}</label>
							<input class="form-control" placeholder="Your Name" type="text" id="bk-cname">
						</div>	
						<div class="col-lg-4 col-md-4 form-group">
							<label>{LANG_PHONE}</label>
							<input class="form-control" placeholder="Phone No." type="text" id="bk-cphone">
						</div>							
					</form>
				</div>
				<div id="payment" class="">
					<h6>{LANG_RESERVATION_STEP3_PAYMENT_MSG}</h6>
					<form>						
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="pay_local" name="bk_payments" value="0" checked="true">
							<label class="custom-control-label" for="pay_local">{LANG_PAYMENT_LOCALLY}</label>
						</div>
						<!--{LOOP: SHOP_PAYMENT_METHODS}
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" id="payment-type-{SHOP_PAYMENT_METHODS.id}" name="bk_payments" value="{SHOP_PAYMENT_METHODS.id}">
							<label class="custom-control-label" for="payment-type-{SHOP_PAYMENT_METHODS.id}">{SHOP_PAYMENT_METHODS.title}</label>
						</div>						
						{/LOOP: SHOP_PAYMENT_METHODS}-->
					</form>
				</div>
				<div id="done" class="">
					<div class="successful-box text-center">
						<div class="successful-check"><i class="ti-check"></i></div>
						<h2>
							<span class="successfull">{LANG_SUCCESSFUL}</span>
							<span class="error" style="display:none;">{LANG_RESERVATION_ERROR_MSG}</span>
						</h2>
					</div>
				</div>
			</div>
		</div>	<!--smartwizard-->	
	  </div>
	  <!--end modal body-->
    </div>
  </div>
</div>
<!-- end booking modal-->