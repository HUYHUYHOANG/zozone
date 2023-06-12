var CStr = {
	trim : function(str){
		if(!str || typeof str != "string")
			return "";
		return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	},
	isEmail : function(s){
		var re = /^([a-zA-Z_]+)([a-zA-Z0-9._%-]+)@[\w0-9.-]+\.[\w]{2,4}$/;
		return s.match(re);
	}
}

String.prototype.trim = function(){
	if(this.length) return this.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	return "";
};
String.prototype.isEmail = function(){
	var re = /^([a-zA-Z_]+)([a-zA-Z0-9._%-]+)@[\w0-9.-]+\.[\w]{2,4}$/;
	return this.match(re);
};
String.prototype.isZozonePwd = function(){
	var reg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
	return this.match(reg);
};
String.prototype.isZozoneUid = function(){
	/* 
    Usernames can only have: 
    - Lowercase Letters (a-z) 
    - Numbers (0-9)
    - Dots (.)
    - Underscores (_)
  */	
	var reg = /^[a-z0-9]\w{3,15}$/;
	return this.toLowerCase().match(reg)? 1 : 0;
};

Date.prototype.toYMDString = function(){
	var m = '' + (this.getMonth() + 1);
	var d = '' + this.getDate();
	var y = this.getFullYear();
	if(m.length<2) m = '0' + m;
	if(d.length<2) d = '0' + d;
	return [y,m,d].join('-');	
}

var $bkAjax = function(adata, method, lpfnSuccess, lpfnError){	
	$.ajax({
		method  : method,
		url     : boConfigParams.boSvrSide,
		data	: adata,
		datatype: 'json',
		beforeSend: function( xhr ){
		}
	}).done(function(res){		
		$('body').css({cursor:'default'});
		if(typeof(lpfnSuccess)=='function') lpfnSuccess(res);
	}).fail(function(err) {
		$('body').css({cursor:'default'});
		// Handle ajax error
		if(typeof(lpfnError)=='function') lpfnError(err);
	});
};

var $bkGet = function(data, lpfnSuccess, lpfnError){
	$('body').css({cursor:'not-allowed'});
	setTimeout(function(){$bkAjax(data, 'GET', lpfnSuccess, lpfnError);}, 300);
};

var $bkPost = function(thedata, lpfnSuccess, lpfnError){	
	$('body').css({cursor:'not-allowed'});
	$bkAjax(thedata, 'GET', lpfnSuccess, lpfnError);
};

$.fixMfp = function(){
	$('.mfp-container,.mfp-content').click(function(e){
		var elm = $(e.target);
		if(elm.hasClass('mfp-container') || elm.hasClass('mfp-content')){
			e.preventDefault();
			return false;
		}
		return true;
	});
};

function hilite(id, flag){
	if(flag) $('#'+id).focus().prev().addClass('error');
	else $('#'+id).prev().removeClass('error');		
};

$.submitErrorMsg = function(field, text){
	var elm = null, fc = field;
	$('#' + fc).hilite(1);
	if(elm){            
		elm.children().text(text);
		elm.showInputMessage();
	}
};

(function($){
    var methods = {
        
    };

	$.fn.hilite = function(bFocus){
		var obj = $(this);
		var elm;
		$(this).addClass('input-error');
		if(bFocus) $(this).focus();
		elm = $(this).parent().prev();
		if(elm.prop('tagName')==undefined) elm = $(this).parent().children().first();
		elm.addClass('text-danger');
		setTimeout(function(){
			obj.removeClass('input-error');
			elm.removeClass('text-danger');
		}, 3000);
		return $(this);
	};

	/*call from label element pre-selectpircker*/
	$.fn.selectPickerError = function(){
		var obj = $(this).addClass('text-danger');
		var elm = $(this).next().addClass('input-error');
		setTimeout(function(){
			obj.removeClass('text-danger');
			elm.removeClass('input-error');
		}, 3000);
		return $(this);
	};

    $.fn.numericInput = function() {
        $(this).keypress(function(evt){			
            if ((evt.which < 48 || evt.which > 57) && evt.which!=13){
                evt.preventDefault();
            }
        }).on('paste', function(e){
            return false;
        });
    };

	$.fn.emailInput = function(){
		var lpcb = null;
		if(arguments.length && typeof(arguments[0])=='function') lpcb = arguments[0];
		$(this).keypress(function(evt){
			var kc = evt.which;		
			if(kc==64){
				return $(this).val().indexOf('@') == -1;
			}
			if((kc >=48 && kc <= 57) || (kc>=97 && kc<=122) || (kc>=65 && kc<=90) || kc==95 || kc==45 || kc==46 || kc==64) return true;
			return false;
		}).blur(function(){
			var s = $(this).val().trim();
			if(!s.length) return;
			var ret = s.isEmail() ? 1 : 0;
			if(!ret) $(this).hilite();
			if(lpcb) lpcb($(this), ret);
		});
	};

	$.fn.uidInput = function(){		
		/*if(arguments.length) maxLength = arguments[0];*/
		/*using jquery.mask.js plugin*/
		var lpcb = null;
		if(arguments.length && typeof(arguments[0])=='function') lpcb = arguments[0];
		$(this).mask('AAAAAAAAAAAAAAA')
			   .blur(function(){
					var v = $(this).val().trim();
					if(v.length<4 || v.length>15){
						if(lpcb) lpcb($(this), 0);
						$(this).hilite();
						return false;
					}
					return lpcb!=null ? lpcb($(this), v.isZozoneUid()) : true;
			   });
	};

	$.fn.pwdInput = function(){
		/* 6<= pwd length <= 20 ;  least 1 number, 1 lowercase letter and 1 uppercase character */		
		var reg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
		var lpcb = null;
		if(arguments.length && typeof(arguments[0])=='function') lpcb = arguments[0];
		$(this).blur(function(){
			let v = $(this).val().trim().length;
			if(!v) return;
			var s = $(this).val().replace(/\s/g, '');
			var ret = s.match(reg);
			if(lpcb) lpcb($(this), ret?1:0);
			if(!ret) $(this).hilite();
		});		
	};

	$.fn.preventBgClose = function(){
		$(this).click(function(e){
			var elm = $(e.target);
			if(elm.hasClass('mfp-container') || elm.hasClass('mfp-content')){
				e.preventDefault();
				return false;
			}
			return true;
		});
	};

	$.fn.autoHeight = function(){
		$(this).on('keyup keypress', function() {
			$(this).height(0);
			$(this).height((this.scrollHeight>140 ? 140:this.scrollHeight) - 10);
		});
	};

	$.fn.disableForm = function(flag){
		if(flag){
			$(this).find('button').prop('disabled', true);
			$(this).find('input').prop('disabled', true).addClass('disabled');			
		}else{
			$(this).find('button').prop('disabled', false).removeClass('disabled');
			$(this).find('input').prop('disabled', false).removeClass('disabled');
		}
	};

	$.fn.disableMe = function(flag){
		if(flag)
			$(this).prop('disabled', true).addClass('disabled');
		else 
			$(this).prop('disabled', false).removeClass('disabled');
	};

	$.fn.slidingBtnAjaxIcon = function(flag){
		if(flag){
			$(this).addClass('ajxloading').prop('disabled',true).removeClass('button-sliding-icon').find('i,span').hide();
		}else{
			$(this).removeClass('ajxloading').prop('disabled',false).addClass('button-sliding-icon').find('i,span').show();
		}		
	};

	$.fn.showInputMessage = function(){
		var span = $(this).children();
		span.addClass('open').slideDown();
		setTimeout(function(){
			span.removeClass('open').slideUp();
		}, 3000);
	};

	/*popup*/
	$.fn.mfpPopup = function(options, lpfnBeforeOpenCallback, lpfnOpenCallback){
		$.magnificPopup.open({
			items: {
				src: $(this),
				type: 'inline',
				closeBtnInside: false,
				closeOnBgClick : false,
				enableEscapeKey : false,
				fixedContentPos: false,
				fixedBgPos: true,
				midClick: true,   
				mainClass: 'my-mfp-zoom-in',
				modal : true,
				overflowY: 'auto',
				preloader: true,
				removalDelay: 300,
			},
			callbacks:{
				beforeOpen: function(){
					options.contentWrapper.html('').addClass('loading');
					if(typeof(lpfnBeforeOpenCallback)=='function') lpfnBeforeOpenCallback();
				},
				open : function(){					
					if(typeof(lpfnOpenCallback)=='function') lpfnOpenCallback();
				}
			}
		});
	};
})( jQuery );

///////////////////////////////////////////////////////////////////////////////
/*swal*/
(function($){
	$.fn.confirm = function(message, lpfnCallback, lpfnCancelCallback){
		swal({                
			text: message,
			icon: 'warning', 
			buttons: true
		}).then((letGo) => {
			if(!letGo){
				if(typeof(lpfnCancelCallback) == 'function') lpfnCancelCallback($(this));	
				return;
			}
			if(typeof(lpfnCallback) == 'function') lpfnCallback($(this));
		});
	};
})(jQuery);