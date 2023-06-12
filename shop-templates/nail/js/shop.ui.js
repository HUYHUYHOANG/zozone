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

jQuery(document).ready(function() {
	'use strict';
	if(typeof dz_rev_slider_5 == 'function') dz_rev_slider_5();

	resizeShopItems();
	selectLanguage();
	
	$('.dzForm').on('submit', function(evt){
		try{			
			dzContactFormSubmit(evt, this);
		}catch(e){
			console.log(e.message);
		}
		return false;
	});
});	/*ready*/

$(window).resize(function(){
	resizeShopItems();
});


var request = null;
var $bkAjax = function(adata, method, lpfnSuccess, lpfnError){
	request = $.ajax({
		method  : method,
		url     : zozoneNailParams.ajaxURL,
		data	: adata,
		beforeSend: function( xhr ) {		
			$('#smartwizard').smartWizard("loader", "show");
		}
	});
	
	request.done(function(res){		
		if(typeof(lpfnSuccess)=='function') lpfnSuccess(res);
		$('#smartwizard').smartWizard("loader", "hide");
	});
	
	request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
		if(typeof(lpfnError)=='function') lpfnError(err);
    });	

	request.always(function () {
        $('#smartwizard').smartWizard("loader", "hide");
		request = null;
    });
};

var $bkGet = function(data, lpfnSuccess, lpfnError){
	$bkAjax(data, 'GET', lpfnSuccess, lpfnError);
};

var $bkPost = function(data, lpfnSuccess, lpfnError){
	$bkAjax(data, 'POST', lpfnSuccess, lpfnError);
};

try{
	if(document.getElementById('dzcontact') != null){
		var waypoint = new Waypoint({
			element: document.getElementById('dzcontact'),
			handler: function(direction) {
				if(direction==="down" && $("body").data("gmap-init")!="yes"){
					if (window.google && google.maps) {
						// Map script is already loaded
						initializeMap();
					} else {
						lazyLoadGoogleMap();
					} 
					$("body").data("gmap-init", "yes");
				}
			}
		});
	}
}catch(e){
	console.log(e.message);
}

function resizeShopItems(){
	$('.spa-price-tbl').each(function(){
		var rc = $(this).find('.spa-price-content');
		var lc = $(this).find('.spa-price-thumb');
		rc.width($(this).width() - lc.width() - 20);
	});
}

function selectLanguage(){        
	/*var code = jQuery.cookie('Quick_user_lang_code');
	var language = jQuery.cookie('Quick_lang');*/
	var blanguage_default = true;		

	var code = zozoneNailParams.langCode;
	var language = zozoneNailParams.langName;

	if(language==null) language = zozoneNailParams.langName;
	if(code==null) code = zozoneNailParams.langCode;

	if (language != null && code != null) {
		/*language = jQuery.cookie('Quick_lang').charAt(0).toUpperCase() + jQuery.cookie('Quick_lang').slice(1);*/
		language = language.charAt(0).toUpperCase() + language.slice(1);
	}else{
		language = 'German';
		try{
			const params = new Proxy(new URLSearchParams(window.location.search), {
				get: (searchParams, prop) => searchParams.get(prop),
			});                    
			switch(code = params.lang){
				case 'en':
					language = 'English';
					break;
			}
		}catch(e){
		}  
	}
	
	if (code != null) {
		jQuery('.flag-selected').removeClass('flag-German').addClass('flag-' + language);
		jQuery('.flag-selected').html(language);
	}

	$('.dzlang-menu-content>a').click(function (e) {
		e.preventDefault();		
		var c = $(this).data('lang').toUpperCase();
		var l = language.toUpperCase();		
		var lang = jQuery(this).data('lang');
		var code = jQuery(this).data('code');			
		if (1) {
			jQuery.cookie('Quick_lang', lang, { path: '/' });
			jQuery.cookie('Quick_user_lang', lang, { path: '/' });
			jQuery.cookie('Quick_user_lang_code', code, { path: '/' });
			/*location.reload();*/
			document.location.href = window.location.href.split('?')[0] + "?lang=" + code;
		}
});
}/*selectLanguage*/
/*
function selectLanguage(){
	var code = jQuery.cookie('Quick_user_lang_code');
	var language = jQuery.cookie('Quick_lang');
	var blanguage_default = true;		

	if(language==null) language = zozoneNailParams.langName;
    if(code==null) code = zozoneNailParams.langCode;

	if (language != null && code != null) {
		//language = jQuery.cookie('Quick_lang').charAt(0).toUpperCase() + jQuery.cookie('Quick_lang').slice(1);
		language = language.charAt(0).toUpperCase() + language.slice(1);
	}
	
	if (code != null) {
		jQuery('.flag-selected').removeClass('flag-German').addClass('flag-' + language);
		jQuery('.flag-selected').html(language);
	}            
	
	$('.dzlang-menu-content>a').click(function (e) {
		e.preventDefault();		
		var c = $(this).data('lang').toUpperCase();
		var l = language.toUpperCase();		
		var lang = jQuery(this).data('lang');
		var code = jQuery(this).data('code');
		
		if (1) {
			jQuery.cookie('Quick_lang', lang, { path: '/' });
			jQuery.cookie('Quick_user_lang', lang, { path: '/' });
			jQuery.cookie('Quick_user_lang_code', code, { path: '/' });
			location.reload();
		}
	});
}*/

var gmParams; 
function initialize(gmParams) {
	var myLatlng = new google.maps.LatLng($('#map_canvas').data('lat'), $('#map_canvas').data('lng'));
	var mapOptions = {
		center: myLatlng,
		zoom: 17,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};        
	var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: "{ADDRESS}"
	});        
}

function lazyLoadGoogleMap() {
	$.getScript("https://maps.googleapis.com/maps/api/js?key=" + $("#lang-settings").data("gmap-api-key") 
				+ "&libraries=places&callback=initializeMap&region="+$('.current-lang-code').text()+"&language="+$('.current-lang-code').text())
	.done(function (script, textStatus) {
	})
	.fail(function (jqxhr, settings, ex) {
		console.log("Could not load Google Map script: " + jqxhr);
	});
}

function initializeMap() {
	initialize(gmParams);
}

$('#itemInfoModal').on('shown.bs.modal', function (e) {	
	var alink = $(e.relatedTarget);	
	$(this).find('.modal-title').text(alink.data('catname'));
	$(this).find('.modal-body').html($(alink.data('ref-id')).html());
})

function dzContactFormSubmit(evt, theform){	
	evt.preventDefault();
	if(request) {
        request.abort();
    }

	var elm = $('.send-contact-result');

    var $form = $(theform);

    var $inputs = $form.find("input, select, button, textarea");

    var serializedData = $form.serialize();

    $inputs.prop("disabled", true).addClass('disabled');
	
	var url = $form.prop('action');	
    request = $.ajax({
        url: url,
        type: "post",
        data: serializedData
    });
	
	request.done(function(response, textStatus, jqXHR){
		try{
			var r = $.parseJSON(response);					
			if(r.result=="+220") elm.text(elm.data('success')).removeClass('error').slideDown();
			else elm.text(elm.data('error')).addClass('error').slideDown();
			setTimeout(function(){
				elm.slideUp();
			}, 3000);
		}catch(e){
		}
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    request.always(function () {
        $inputs.prop("disabled", false).removeClass('disabled');
    });


	return false;
}

function hilite(id, flag){
	if(flag) $('#'+id).focus().prev().addClass('error');
	else $('#'+id).prev().removeClass('error');		
}

document.addEventListener("DOMContentLoaded", function() {	
	var tags = ['INPUT', 'TEXTAREA'];
	for(tag = 0; tag < tags.length; ++tag){
		var elements = document.getElementsByTagName(tags[tag]);		
		for (var i = 0; i < elements.length; i++) {
			elements[i].oninvalid = function(e) {
				e.target.setCustomValidity("");
				if (!e.target.validity.valid) {
					e.target.setCustomValidity($("#lang-settings > i.lang-error-input-required").text());
				}
			};
			elements[i].oninput = function(e) {
				e.target.setCustomValidity("");
			};
		}
	}
})

