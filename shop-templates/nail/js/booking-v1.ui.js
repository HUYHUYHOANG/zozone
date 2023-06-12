
$('#serviceBookingModal').on('shown.bs.modal', function (e) {
    var serviceId = $(e.relatedTarget).data('id');
    var catId = $(e.relatedTarget).data('catid');	
	
    $('#serviceBookingModal').find('.modal-title').text($('#lang-settings > i.lang-online-booking').text());	

	$('#serviceBookingModal').find('a.close').click(function(){
		$('#smartwizard').smartWizard('reset');	
		/*if(!$('#btnFinish').hasClass('hidden')){
			$('#smartwizard').smartWizard('reset');	
		}*/
	});

	initBookingModal(catId, serviceId);	
}).on('hidden.bs.modal', function(){
	$('#serviceBookingModal').find('a.close').unbind('click');
});


function initBookingModal(catId, serviceId){	
	$('#bk-services').val(serviceId).selectpicker('refresh');	
	if(typeof(serviceId)!="undefined") {
		$changeServices($('#bk-services'));	
	}
	smartWizardInit();
	return;

    if(!zozoneNailParams.dataLoaded[0]){
        var rq = $.ajax({type:'GET', url:'./php?md=service-booking&d0=list-employees', data:''});
		rq.done(function(response){
			var js = JSON.parse(response);
			js.forEach(function(item){
				$('#bk-staffs').append('<option value="' + item.id + '">' + item.name + '</option>');
			});                
			$('#bk-staffs').selectpicker('refresh');
		});
    }
    zozoneNailParams.dataLoaded[0] = 1;
}//initBookingModal

function smartWizardInit(){
	if(!zozoneNailParams.smartWizardInit){
		/*$('#smartwizard').smartWizard({
			selected: 0,
			theme: 'default',
			transitionEffect:'fade',
			showStepURLhash: false,				
			toolbarSettings: {
				toolbarPosition: 'both',
				toolbarButtonPosition: 'end'
			}
		});*/

		$("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection){			
			return $smartWizardLeaveStep(e, anchorObject, stepNumber, stepDirection);
		});

		$("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition){
			return  $smartWizardShowStep(e, anchorObject, stepNumber, stepDirection, stepPosition);
		});

		$("#smartwizard").on("endReset", function(){
			$('.service-duration').html('');
		});

		$('#bk-cemail').change(function(){
			var cemail = $(this).val();
			if(!CStr.isEmail(cemail)){
				hilite('bk-cemail', 1);
				return false;
			}
			var data = {'md' 	: 'service-booking', 'd0'	: 'find-cli3nt-by-3mail', 'em' : cemail};
			$bkGet(data, function(res){				
				var cl = $.parseJSON(res);				
				if(cl.found){
					$('#bk-cname').val(cl.name);
					$('#bk-cphone').val(cl.phone);
				}
			});
		});	

		$('#datetimepicker').on('dp.change', function(e){
			///will load later - now just ignore
			//$reloadStaffs();
		});

		zozoneNailParams.smartWizardInit = 1;
	}

	setTimeout(function(){
		$('#smartwizard').find('li.nav-item>').each(function(){
			$(this).css({'cursor':''}).parent().addClass('flex-fill');			
		});
		//$('.sw-btn-prev').removeClass('disabled').prop('disabled',false);
		$('#done').find('span.error').hide().prev().show();
		$('.successful-check').show();
		$('.sw-btn-prev').text($('.lang-back-btn').text());
		$('.sw-btn-next').text($('.lang-next-btn').text());
		if(!$('#btnFinish').length){
			$('.sw-btn-next').parent().append('<button id="btnFinish" class="site-button sw-btn-finish hidden">' + $('i.lang-done').text() + '</button>');
			$('.sw-btn-finish').click(function(){
				$('#smartwizard').smartWizard('reset');
				$('#serviceBookingModal').find('a.close').trigger('click');
			});
		}else{
			$('.sw-btn-finish').addClass('hidden');
			$('.sw-btn-next').removeClass('hidden');			
		}
	}, 200);

	//services changed
	$(".selectpicker").selectpicker({title: '',}).selectpicker('render').on('change', function(){		
		$changeServices($(this));
	});	
	$reloadStaffs();
}//init smart wiz

$changeServices = function(obj){	
	var ntime = 0;
	zozoneNailParams.selectedServices = [];
	zozoneNailParams.selectedSpecIds = [];
	obj.find('option:selected').each(function(){		
		if(!zozoneNailParams.selectedSpecIds.includes($(this).data('spec-id'))){
			zozoneNailParams.selectedSpecIds.push($(this).data('spec-id'));	
		}
		ntime += parseInt($(this).data('duration'), 10);		
		zozoneNailParams.selectedServices.push($(this).val());		
	});	
	if(!ntime){
		$('#time').find('.service-duration').text('');
	}else{
		$('#time').find('.service-duration').html(ntime+'<sup>' + $('i.lang-minutes').text() + '</sup>');
		//reload staffs list
		$reloadStaffs();
	}
}

$reloadStaffs = function(){	
	//if(!$('#bk-services').val().length || $('#bk-services').val()==='0' || !$('#datetimepicker').val().length) return;
	if(zozoneNailParams.loadStaffsTimerId){
		clearTimeout(zozoneNailParams.loadStaffsTimerId);
		zozoneNailParams.loadStaffsTimerId = 0;	
	}
	zozoneNailParams.loadStaffsTimerId = setTimeout(loadStaffsCallback(), 500);	
}

function loadStaffsCallback(){	
	var data = { 'md' : 'service-booking', 'd0' : 'list-nail-st2ffs', 'shid' : $('#lang-settings').data('shop'),
				'specIds' : zozoneNailParams.selectedSpecIds.toString(),
				'sids' : zozoneNailParams.selectedServices.toString()};	
	var astaffs = [];	
	$('#bk-staffs-list').addClass('loading');
	request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: data,
		success : function(res){
			$('#bk-staffs-list').removeClass('loading');
			try{			
				$('#bk-staffs-list').html(res).find('input[name="staffs"]').each(function(){
					astaffs.push($(this).val());
				});
				
				$('#bk-staffs-list label.btn').click(function(){				
					var ip = $(this).children('input');
					$('#bk-staffs-list').data('staff-id', ip.val());
					$('#bk-staffs-list').data('staff-name', ip.data('name'));
				});
			}catch(e){			
			}
		}
	});
	 
	return false;
}

$smartWizardShowStep = function(e, anchorObject, stepNumber, stepDirection, stepPosition){
	switch(stepNumber){
		case 0:
			break;			
		case 1:
			if(stepDirection=="forward"){
				var sdata = {
					'md' 	: 'service-booking',
					'd0'	: 'list-time-slots',
					'dt'	: $('#datetimepicker').val(),
					'dr'	: $('.service-duration').text(),
					'sids'	: zozoneNailParams.selectedServices.toString(),					
					'staff'	: $('#bk-staffs-list').data('staff-id'),
					'shid'	: $('#lang-settings').data('shop'),
					'st2ffname' : $('#bk-staffs-list').data('staff-name')
				};				
				$('#time-slots-content').html('').addClass('loading');				
				$bkGet(sdata, function(res){					
					try{
						$('#time-slots-content').removeClass('loading').html(res);
						$('.book-time .btn').click(function(e){							
							e.preventDefault();
							if($(this).hasClass('disabled')) return false;
							$('.book-time .btn').removeClass('active'); $(this).addClass('active');
							$('.book-time').data('selected-time', $(this).children('input').val());
							$('.book-time').data('selected-date', $(this).data('selected-date'));								
							return false;
						});
					}catch(e){
					}
				});                        
			}//step 1
			break;
		case 2:
			if(stepDirection!="forward") break;				
			var data = { 
				'md' : 'service-booking', 
				'd0' : 'booking-d3tails-form',
				'rdat3' : $('.book-time').data('selected-date'),
				'rtim3' : $('.book-time').data('selected-time')
			};
			$bkGet(data, function(res){
				var data = $.parseJSON(res);
				$('b.service-name').text(data.serviceName);
				$('b.service-time').text(data.bookTimeDisplay);
				$('b.service-date').text(data.weekDate)+'. ';
				$('b.service-price').text(data.subAmt);
				if(data.staff_name.length)
					$('b.staff-name').text(data.staff_name).show().prev().show();
				else $('b.staff-name').text(data.staff_name).hide().prev().hide();
			});
			break;
		case 4:
			var selectedPayment = -1;
			$('input[name="bk_payments"]').each(function(){
				if($(this).prop('checked')) selectedPayment = $(this).val();
			});
			if(selectedPayment==-1){
				$('#payment>h6').addClass('error');
				return false;
			}
			zozoneNailParams.selectedPayment = selectedPayment;				
			var data = {md : 'service-booking', d0 : 'c0mpl3te-r3serv2tion', p2ym3nt : zozoneNailParams.selectedPayment};			
			$bkGet(data, function(res){
				try{					
					var ret = $.parseJSON(res);					
					if(ret.status){							
						$('#smartwizard').find('button.sw-btn-prev').addClass('disabled').prop('disabled',true);
						$('#smartwizard').find('ul.nav-tabs li.nav-item>').each(function(){
							if($(this).find('span>strong').html() != '5'){
								$(this).css({'cursor':'not-allowed'}).parent().addClass('not-allowed').removeClass('done');
							}
						});
						$('.sw-btn-next').removeClass('disabled').addClass('hidden');
						$('.sw-btn-finish').removeClass('hidden');
					}else{
						$('#done').find('span.error').show().prev().hide();
						$('.successful-check').hide();
					}
				}catch(e){					
					$('.successful-check').hide();
					$('#done').find('span.error').show().prev().hide();
				}
			});			
			break;
	}//switch
	return 1;
}//showstep

$smartWizardLeaveStep = function (e, anchorObject, stepNumber, stepDirection){		
	switch(stepNumber){
		case 0:			
			if(!$('#bk-services').val().length || $('#bk-services').val()==='0'){
				$('#bk-services').parent().prev().addClass('error');
				return false;
			}else $('#bk-services').parent().prev().removeClass('error');
			if(!$('#datetimepicker').val()){
				$('#datetimepicker').prev().addClass('error');
				return false;
			}else $('#datetimepicker').prev().removeClass('error');
			break;
		case 1:
			if(stepDirection != 'forward') break;	
			let bkDate = $('.book-time').data('selected-date')
			let bkTime = $('.book-time').data('selected-time');
			if(!bkDate.length || !bkTime.length){
				$('#service>.m-b5').addClass('error');return false;
			}else $('#service>.m-b5').removeClass('error');

			break;	
		case 2:
			if(stepDirection != 'forward') break;
			let cname = $('#bk-cname').val();
			let cphone = $('#bk-cphone').val();
			let cemail = $('#bk-cemail').val();
			if(!CStr.isEmail(cemail)){
				hilite('bk-cemail', 1);
				return false;
			}else hilite('bk-cemail');
			
			if(!CStr.trim(cname).length){
				hilite('bk-cname', 1);
				return false;
			}else hilite('bk-cname');
			if(!cphone.match(/^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g)){
				hilite('bk-cphone', 1);
				return false;
			}else hilite('bk-cphone');
			
			var data = {md:'service-booking', d0: 'verify-c6st-info', name : cname, phone : cphone, email : cemail};
			$bkGet(data, function(res){				
				if(res==='505ERR'){
					hilite('bk-cname', 1);
				}
			});
			break;
		case 3:
			if(stepDirection != 'forward') break;				
			break;
	}
	return true;
}//leave step

$zozoneTabContentShownCallback = function(idx, stepDirection, page){
	$('#smartwizard').smartWizard('fixHeight', idx);
	/*$('html,body').animate({ scrollTop: 0 }, 'slow');*/
}