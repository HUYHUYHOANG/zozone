
jQuery(document).ready(function(){
	$('#staff-list').selectpicker().change(function(){
		$loadTimeSlots();
	});
	$('#start-date').on('dp.change', function(e){		
		$loadTimeSlots();
	});	
	smartWizardInit();
});


function smartWizardInit(){
	if(zozoneNailParams.smartWizardInit) return;	

	$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection){			
		return $smartWizardLeaveStep(e, anchorObject, stepNumber, stepDirection);
	});

	$("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition){		
		$smartWizardShowStep(e, anchorObject, stepNumber, stepDirection, stepPosition);
		return 1;
	});

	$("#smartwizard").on("endReset", function(){
		$('.service-duration').html('');
	});
	
	var today = moment().format('MM/DD/YYYY');
	$('#start-date').datetimepicker({
		format: 'MM/DD/YYYY',
		minDate : new Date(),
		sideBySide: true,
		widgetPositioning: {
			horizontal: "right",
			vertical: "bottom"
		}
	});
	
	$('#start-date').val(today);
	$('#start-date').on('dp.change', function(e){		
	});
	$('#staff-list').change(function(){
		$('input[name="staff-id"]').val($(this).val());		
	});

	if(zozoneNailParams.bookingTemplateStyle==1){
		//load employee time-slot first
		$initTimeSlotsSlick();
		$loadTimeSlots();		
	}else{
		//load ther services first
		$getTheCartItems();
	}
	

	//grid / list view changed
	$('.the-selected-category-wrap>div>i').click(function(){
		var $this = $(this);
		if($this.hasClass('active')) return false;
		$('.the-selected-category-wrap>div>i').removeClass('active');
		zozoneNailParams.viewType = $this.addClass('active').hasClass('thumb-view') ? 'grid' : 'list';
		$showTheSelectedCategoryItems();
	});

	//a category selected
	$('a.the-cat-name').click(function(){
		$('a.the-cat-name').removeClass('active');
		var $this = $(this);		
		var $theSelectedCat = $('.the-selected-category-name');
		var imgpath = $theSelectedCat.data('imgpath');
		gaCategories.forEach(function(item, idx){
			if(item.id == $this.data('catid')){
				zozoneNailParams.theSelectedCategory = item;
			}
		});		
		
		$this.addClass('active');
		var imgsrc = imgpath + zozoneNailParams.theSelectedCategory.image;
		$theSelectedCat.find('.the-cat-img-wrap img').prop('src', imgsrc);
		$theSelectedCat.find('.the-cat-name').text($this.text());

		$showTheSelectedCategoryItems();		
	});//category clicked

	//let's choose the first category
	$('.services-wrap a.the-cat-name').first().trigger('click');

	//login option clicked
	$('.login-header').click(function(e){
		if($(e.target).prop('tagName').toLowerCase()=='a') $(e.target).children('i').trigger('click');
	});

	$('.login-header>i').click(function(){
		if($(this).hasClass('active')) return;

		$('.login-header>i').removeClass('active').removeClass('fa-check-circle').addClass('fa-circle');
		$(this).addClass('active').addClass('fa-check-circle').removeClass('fa-circle');

		//disabled the other form
		let cls = $('.login-header>i').not('.active').parent().data('ref-class');
		let thewrap = $('.' + cls);
		thewrap.find('input,button').prop('disabled', true).toggleClass('disabled');

		//enable the selected form
		cls = $(this).parent().data('ref-class');
		$('.' + cls).find('input,button').prop('disabled', false).toggleClass('disabled');
		//enable - disable newsletter option
		$('.newsletter-option').toggleClass('disabled');
		$('.forgot-password').toggleClass('hidden');

		//set the login type: login or signup
		$('input[name="login-type"]').val($(this).parent().data('login-type'));		
	});

	//disable sign-up controles
	$('.register-form-wrap').find('input').prop('disabled', true);
	$('.register-form-wrap').find('.control-label').addClass('disabled');

	//forgot pwd dialog
	$('#forgotpwddlg').on('shown.bs.modal', function(){
		$('#email-getpwd').focus();
		$('#btn-getpwd').closest('form').submit(function(){
			try{
				$sendForgotPwdRequest(this);
			}catch(e){ console.log(e.message); }
			return false;
		});
	}).on('hidden.bs.modal', function(){
		$('#btn-getpwd').unbind('click');
	});

	//payment mothod clicked
	$('.payment-method-item a.btn').click(function(){
		if(!$(this).hasClass('active')){
			var payment = $(this).data('value');
			$('.payment-method-item').find('a.active').removeClass('active').children().removeClass('fa-check-circle').addClass('fa-circle');
			$(this).addClass('active').children().removeClass('fa-circle').addClass('fa-check-circle');
			$('#payment-type').val(payment);			
		}
	});

	//register account option
	$('a.register-account').click(function(){
		$(this).children('span').toggleClass('fa-arrow-circle-up', 200).toggleClass('fa-arrow-circle-down', 200);
		$(this).next().slideToggle();
	});
	//newsletter option
	$('.newsletter-option').click(function(){
		if($(this).hasClass('disabled')) return;
		var value = $(this).data('value');
		value = (value + 1)%2;
		$(this).data('value', value).children().toggleClass('fa-square-o', 1200).toggleClass('fa-check-square-o', 1200);
		$('input[name="newsletter-option"]').val(value);
	});
	
	//apply voucher
	$('#voucher-code').keypress(function(evt){
		let key = evt.which;
		if((key>=48 && key<=57) || (key>=97 && key<=122) || (key>=65 && key<=90)) return true;
		return false;
	});
	$('#apply-voucher').click(function(){
		$checkAndApplyVoucher($(this));
		return false;
	});

	//disable next step button till user choose a time slot
	$enableNextBtn(0);

	zozoneNailParams.smartWizardInit = 1;

}//init smart wiz

//show the selected category
$showTheSelectedCategoryItems = function(){
	if(!zozoneNailParams.theSelectedCategory) return;	
	let theWrap = $('.selected-category-service-items');
	let aserivces = $.parseJSON(zozoneNailParams.theSelectedCategory.service_items)[0];	
	try{
		theWrap.fadeOut('fast', function() { 
			theWrap.html(''); 
			let colClass = zozoneNailParams.viewType === 'grid' ? 'col-sm-4 col-6' : 'col-sm-6 col-12';
			aserivces.forEach(function(item, idx){
				item.id = parseInt(item.id);
				let shtml = '<div class="' + colClass + ' "><a class="btn no-click bg-white">' + $showItemDetails( item, zozoneNailParams.viewType) + '</a></div>';
				theWrap.append(shtml);
			});
			theWrap.fadeIn();
		} );		
	}catch(e){
		console.log(e.message);
	}	
	$('.sw-container .tab-content').data('height', $('#service').height()).css('min-height','');
}

//show the item 
$showItemDetails = function(item, view){		
	let shtml = '';		
	let hiddenClass = (zozoneNailParams.cartItems.includes(item.id) ? "hidden" : "");
	if(view=='list'){		
		shtml 	+= "<div class='row service-item-list-view'>"
				+ 	"<div class='col-md-3 col-3 item-image' style=\"background:url('" + zozoneNailParams.serviceImgPath + item.image + "');\"></div>"
				+ 	"<div class='col-md-9 col-9 text-left item-name'>" + item.name + "<br/>" + $formatPrice(item.price, item.discount_amount) + "</div>"
				+		"<span class='card-item list-view booking-btn " + hiddenClass + "'><i class='fa fa-plus-circle btn-add2cart'  onclick='$addCartItem(this)' "
				+ 			"data-id='" + item.id + "' data-name='" + item.name + "' data-price='" + item.price + "' data-discount='" + item.discount_amount + "' data-duration='" + item.duration + "'></i></span>"
				+ "</div>";		
	}else{		
		shtml 	+= "<div class='card-item thumb-view' style=\"background:url('" + zozoneNailParams.serviceImgPath + item.image + "');\">"
				+		"<div class='" + hiddenClass + "'><i class='fa fa-plus-circle btn-add2cart'  onclick='$addCartItem(this)' " 
				+ 			"data-id='" + item.id + "' data-name='" + item.name + "' data-price='" + item.price + "' data-discount='" + item.discount_amount + "' data-duration='" + item.duration + "'></i></div>"					
				+	"</div>"
				+ "<div class='item-name'>" + item.name + "</div>"
				+ "<div class='service-item-price' style='position:relative;'>" + $formatPrice(item.price, item.discount_amount) + "</div>";
	}	
	$('#smartwizard').smartWizard('fixHeight',1);
	return shtml;
}

//format item price
$formatPrice = function(price, discount_amount){	
	let discountAmt = parseFloat(discount_amount);
	price = parseFloat(price);
	let sdiscount = "", sprice = "";
	if(discountAmt > 0){
		sdiscount = "<span class='discount-price'>" + (price + discountAmt).toFixed(2) + " &euro;</span>";
	}
	sprice = "<span class='item-price'>" + price.toFixed(2) + " &euro;</span>";
	return sdiscount + sprice;
}

//callback - called when sm tab loaded
$zozoneTabContentShownCallback = function(idx, stepDirection, page){	
	if(idx==0){
		setTimeout(function(){
			var tabHeight = $('#time').height();
			var smTabInitHeight = $('.tab-content').height();
			if(smTabInitHeight > tabHeight){
				//$('.tab-content').height(tabHeight).css('min-height', tabHeight+'px');
				$('#smartwizard').smartWizard('fixHeight', idx);
			}
		}, 200);
	}		
	$('html,body').animate({ scrollTop: 0 }, 'slow');	
}

function $loadTimeSlots(){
	$enableNextBtn(0);
	var data = {
			'md' : 'service-booking-v20', 'd0' : 'list-time-slots',
			'dt' : moment($('#start-date').val(), 'MM/DD/YYYY').format('YYYY-MM-DD'), 
			'staff' : $('#staff-list').val(),
			'secret' : zozoneNailParams.apiKey
		};
	$('#staffs-list-slider').slick('removeSlide', null, null, true);		
	request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: data,
		success : function(rp){			
			try{
				$('#staffs-list-slider').slick('slickAdd', rp);
				setTimeout(function(){
					$('#staffs-list-slider').slick('refresh');				
				}, 200);
				$('.btn.time-slot.toggle').click(function(){
					$('input[name="staff-id"]').val($(this).data('staff'));
					$('.btn.time-slot.toggle.active').removeClass('active');
					$(this).toggleClass('active');
					$('#selected-time-slot').val($(this).text());
					$enableNextBtn(1);
				});
			}catch(e){}
		}
	});
};

$addCartItem = function(_this){
	let $this = $(_this);
	let id = parseInt($this.data('id'));
	if(zozoneNailParams.cartItems.includes(id)) return;
	
	var data = {
		'md' : 'service-booking-v20', 'd0' : 'add2cart',
		'item' : id,
		'langCode': zozoneNailParams.langCode,
		'secret' : zozoneNailParams.apiKey
	};	
	let request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: data,
		success : function(rp){
			console.log(rp);
			let json = $.parseJSON(rp);
			zozoneNailParams.cartItems.push(id);
			$this.parent().addClass('hidden'); //hide add to cart button
			$addServiceItemToTheList(id, $this.data('name'), $this.data('price'), $this.data('discount'), $this.data('duration'), 1);
			$enableNextBtn(1);
			if($('.cartitems-tbl-wrap').find('.sub-total-amt').length==0){
				//add total row
				$addServiceItemToTheList(0, $('#lang-text-msg').val(), json.subAmt, 0, json.totalDuration);
				$('.total-amt').html(json.subAmt);
			}else{
				$('.sub-total-amt').children().html(json.subAmt);
				$('.sub-total-amt').prev().text(json.totalDuration)+'"';
				$('.total-amt').html(json.subAmt);
			}

		}
	});
	request.always(function(){		
	});
};/*addCartItem*/

$removeCartItem = function(_this){
	let $this = $(_this);
	let id = $this.data('id');
	let index = zozoneNailParams.cartItems.indexOf(id);
	if(index == -1) return;

	let request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: { 'md' : 'service-booking-v20', 'd0' : 'remove-c2rt-items', 'item' : id, 'secret' : zozoneNailParams.apiKey },
		success : function(rp){
			try{
				let json = $.parseJSON(rp);			
				zozoneNailParams.cartItems.splice(index, 1);
				//show the add to cart button
				$('.btn-add2cart[data-id="' + id + '"]').parent().removeClass('hidden');	
				$this.closest('tr').remove();
				//remove item in the copy list
				$('.cartitems-tbl-wrap').find('i[data-id="' + id + '"]').closest('tr').remove();
				if(!zozoneNailParams.cartItems.length){
					$('.cartitems-tbl-wrap').next('p').show();
					$enableNextBtn(0);
					$('.cartitems-tbl-wrap').find('.sub-total-amt').closest('tr').remove();
				}else{
					$('.sub-total-amt').children().html(json.subAmt);
					$('.sub-total-amt').prev().text(json.totalDuration)+'"';
					$('.total-amt').html(json.subAmt);
				}
			}catch(e){}			
		}
	});
	request.always(function(){		
	});
};

$getTheCartItems = function(){
	let request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: { 'md' : 'service-booking-v20', 'd0' : 'get-c2rt-items', 'secret' : zozoneNailParams.apiKey },
		success : function(rp){			
			try{
				let json = $.parseJSON(rp);				
				if(json.count){
					//clear the old list
					$('.cartitems-tbl-wrap').children('tr').remove();

					let amt = 0, duration = 0;
					json.items.forEach(function(item, index){
						$addServiceItemToTheList(item.id, item.name, item.price, item.discount, item.duration);
						zozoneNailParams.cartItems.push(parseInt(item.id));
						amt += parseFloat(item.price);
						duration += parseFloat(item.duration);						
						//hide the addtocart button
						$('.btn-add2cart[data-id="' + item.id + '"]').parent().addClass('hidden');
					});
					//add total row
					$addServiceItemToTheList(0, $('#lang-text-msg').val(), amt, 0, duration);					
					$('.total-amt').html(amt.toFixed(2)+' &euro;');
					$enableNextBtn(1);
				}else{
					$enableNextBtn(0);
				}				
			}catch(e){}			
		}
	});
	request.always(function(){		
	});
};

$addServiceItemToTheList = function(id, name, price, discount, duration){
	let $thelist = $('.cartitems-tbl-wrap');
	let removeBtn = id > 0 ? "<i class='fa fa-minus-circle' data-id='" + id + "' onclick='$removeCartItem(this)'></i>" : "";
	let shtml = "<tr " + (id==0 ? "class='sub-total-row'" : "") + "><td class='col-md-10 item-name'>" + name + "</td><td class='col-md-2 item-name text-right'>" + duration + "\"</td><td class='col-md-2 text-right " + (id==0 ? "sub-total-amt":"") + "' style='white-space:nowrap;'>"
				+ $formatPrice(price, discount) + "</td><td class='col-md-2 text-right remove-item-btn-col'>" + removeBtn + "</td></tr>";
	if(id==0)
		$thelist.append(shtml);
	else
		$thelist.prepend(shtml);
	$('.cartitems-tbl-wrap').next('p').hide();
};

$checkAndApplyVoucher = function($this){
	let code = $('#voucher-code').val();
	if(!code.length) return;
	
	let subAmt = $('.sub-total-amt').first().children().text();	
	
	if($this.data('action')=='apply'){
		let request = $.ajax({
			method  : 'POST',
			url     : zozoneNailParams.ajaxURL,
			data	: { 'md' : 'service-booking-v20', 'd0' : 'apply-vouch3r', 'code' : code, 'sub-amt': subAmt, 'secret' : zozoneNailParams.apiKey },
			success : function(rp){
				console.log(rp);
				try{
					let json = $.parseJSON(rp);
					
					if(json.error){
						$('.apply-voucher-result').text(json.message).slideDown();
						setTimeout(function(){ $('.apply-voucher-result').slideUp(); $('#voucher-code').val(''); }, 2000);
					}else{
						if(json.subAmt || json.recuded){
							$('.voucher-amt').children().html(json.recudeFormat);
							$('.total-amt').html(json.amtFormat);
							$this.data('action', 'remove').text($this.data('clear-text'));
						}
					}
				}catch(e){}			
			}
		});
		request.always(function(){		
		});
	}else{ 
		//remove voucher
		$('#voucher-code').val('');
		$('.voucher-amt').children().html('0.00 &euro;');
		let text = $('.total-amt').closest('.table').prev().find('.sub-total-amt').children().text();
		$('.total-amt').text(text);
		$this.data('action', 'apply').text($this.data('apply-text'));
	}
};/*apply voucher*/

$sendForgotPwdRequest = function(_form){
	$form = $(_form);
	let email = $('#email-getpwd').val();
	let themsg = $('.getpwd-msg');
	themsg.text(themsg.data('text'));
	if(!email.isEmail()){
		$('#email-getpwd').select();
		themsg.removeClass('text-success').addClass('text-danger').slideDown();
		setTimeout(function(){ themsg.slideUp(); }, 2000);
		return false;
	}

	let msgText = themsg.text();
	let sent = 0;
	$('#btn-getpwd').addClass('disabled').addClass('loading').prop('disabled',1).text('');
	let request = $.ajax({
		method  : 'POST',		
		url     : zozoneNailParams.ajaxURL,
		data	: { 'md' : 'customer-service', 'd0' : 'send-forgot-pwd-request', 'email' : email, 'secret' : zozoneNailParams.apiKey },
		success : function(rp){
			try{
				let json = $.parseJSON(rp);
				if(json.error){
					themsg.removeClass('text-success').addClass('text-danger');					
				}else{
					themsg.removeClass('text-danger').addClass('text-success');
					sent = 1;
				}
				themsg.text(json.message).slideDown();
			}catch(e){}			
		}
	});
	request.always(function(){				
		if(!sent){
			$('#btn-getpwd').removeClass('disabled').removeClass('loading').prop('disabled', 0).text($('#btn-getpwd').data('text'));
			setTimeout(function(){ themsg.slideUp().text(msgText); }, 3000);
		}else{
			$('#btn-getpwd').removeClass('loading').text($('#btn-getpwd').data('text'));
		}
	});
	return false;
};

$.frmConfirmSubmit = function(){
	let $thebtn = $('.btn-login');
	let $theform = $('#frmConfirm');
	let loginType = '';

	if(!zozoneNailParams.customerLoggedIn){
		loginType = $('input[name="login-type"]').val();
		let fnewsletter = $('input[name="newsletter-option"]').val();
		let email = '', pwd = '';
		if(loginType == 'login'){
			email = $('#login-email').val();
			pwd = $('#login-pwd').val();
			let $loginmsg = $('.login-return-msg');
			if(!email.isEmail()){
				$loginmsg.showStatusMsg('inv-email');
				return 0;
			}
			if(!pwd.isPwd()){
				$loginmsg.showStatusMsg('inv-pwd');
				return 0;
			}
			$('input[name="e"]').val(email.encode());
			$('input[name="p"]').val(pwd.encode());		
		}else{
			email = $('#signup-email').val();
			pwd = $('#signup-pwd').val();
			let pwd2 = $('#signup-pwd2').val();
			let $signupmsg = $('.signup-return-msg');
			let fname = $('#fname').val().trim();
			let lname = $('#surname').val().trim();
			let phone = $('#phone').val().trim();

			if(!fname.length || !lname.length){
				$('#fname').select();
				$signupmsg.showStatusMsg('inv-default');
				return 0;
			}

			if(!email.isEmail()){
				$('#signup-email').select();
				$signupmsg.showStatusMsg('inv-email');
				return 0;
			}		
			if(pwd.length){
				if(!pwd.isPwd()){
					$('#signup-pwd').select();
					$signupmsg.showStatusMsg('inv-pwd');
					return 0;
				}
				if(pwd != pwd2){
					$('#signup-pwd2').select();
					$signupmsg.showStatusMsg('pwd-notmatch');
					return 0;
				}
				$('input[name="p"]').val(pwd.encode());
			}		
			$('input[name="e"]').val(email.encode());
		}
	}

	$('input[name="date"]').val($('#start-date').val());
	$('input[name="time"]').val($('#selected-time-slot').val());
	
	$enableNextBtn(0);
	let request = $.ajax({
		method  : 'POST',		
		url     : zozoneNailParams.ajaxURL,
		data	: $theform.serialize(),
		success : function(rp){			
			try{
				let json = $.parseJSON(rp);
				var themsg;
				
				if(json.errorType=='login'){
					if(loginType == 'login') themsg = $('.login-return-msg');
					else themsg = $('.signup-return-msg');
				}else{
					themsg = $('.booking-return-msg');
				}

				if(json.error){
					themsg.removeClass('text-success').addClass('text-danger');
					setTimeout(function(){ themsg.slideUp() }, 3000);
				}else{
					themsg.removeClass('text-danger').addClass('text-success');
					let paymentType = $('#payment-type').val();
				
				
				

					if(paymentType == 'local'){

					
			
						$('#details').html($('#done').html());
						$('.sw-btn-prev, .sw-btn-next').addClass('disabled').prop('disabled',0);

						if(json.whatsApp_url != '')
						{
							document.location = json.whatsApp_url;
						}
						else
						{
							
						document.location = zozoneNailParams.shopHomeURL;
						}
						
					}else{
					
						//redirect to vendor api
						$enableNextBtn(0);	
						if(json.redirect!=null && json.redirect.length) document.location = json.redirect.decode();
						else document.location = zozoneNailParams.shopHomeURL;
					}
				}
				themsg.text(json.message).slideDown();
				
			}catch(e){
				console.log('Exception: ' + e.message);
			}
		}
	});
	request.always(function(){
		$enableNextBtn(1);
	});
	return 0;
};

$enableNextBtn = function(flag){
	let thebtn = $('#smartwizard').find('.sw-btn-next');
	if(!flag) thebtn.prop('disabled', true).addClass('disabled');
	else thebtn.prop('disabled', false).removeClass('disabled');
};

$initTimeSlotsSlick = function(){
	if($('#staffs-list-slider').data('slick-initialized') != 'y'){		
		$('#staffs-list-slider').slick({
			dots: false,
			infinite: false,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
			adaptiveHeight: true
		});
		$('#staffs-list-slider').data('slick-initialized', 'y');
	}
};

$smartWizardShowStep = function(e, anchorObject, stepNumber, stepDirection, stepPosition){
	if(stepNumber==1){
		if(zozoneNailParams.bookingTemplateStyle==1){
			//load employees first
			if(stepDirection=='forward' || zozoneNailParams.cartItems.length){
				$getTheCartItems();
			}
		}else{
			if(stepDirection=='forward'){
				$initTimeSlotsSlick();
				$loadTimeSlots();
				$enableNextBtn(0);
			}
		}
	}else if(stepNumber==0 && stepDirection=='backward'){		
		if(zozoneNailParams.bookingTemplateStyle==2){
			$getTheCartItems();		
		}		
	}
	return 1;
}//showstep

$smartWizardLeaveStep = function (e, anchorObject, stepNumber, stepDirection){
	let result = true;		
	switch(stepNumber){
		case 0:
			break;
		case 1:
			break;	
		case 2:	
			if(stepDirection=='backward') break;

			result = false;
			try{
				$.frmConfirmSubmit();
			}catch(e){
				console.log('$.frmConfirmSubmit: ' + e.message);
			}			
			break;
		case 3:			
			break;
	}	
	return result;
}//leave step