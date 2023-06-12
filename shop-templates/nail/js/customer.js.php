<?php 
header("Content-Type: application/javascript");
ob_start("minfield");

if(0){?>
<script type="text/javascript">
<?php }?>    

jQuery(document).ready(function(){
    selectLanguage();
    $('.extra-nav').css('height',$('.header').height());    
    $('form').each(function(){
        $(this).submit(function(){       
            let fn = $(this).data('lpcbsubmit');     
            if(!fn || !fn.length) return false;
            try{
                let lpcbfn = eval('$.' + fn);
                if(typeof(lpcbfn) == 'function')
                    lpcbfn(this);
            }catch(e){
                console.log(e.message);
            }
            return false;
        });
        /*password controls with eye*/
        $(this).find('.toggle-password').click(function(){
            $(this).children('i').toggleClass("la-eye la-eye-slash");
            if($(this).parent().prev().attr('type')=='text') $(this).parent().prev().attr('type','password');
            else $(this).parent().prev().attr('type', 'text');
        });

        $(this).find('a.newsletter-opt').click(function(){
            $(this).children('i').toggleClass('fa-check-square-o fa-square-o');
            if($(this).children('i').hasClass('fa-check-square-o')) $('input[name="newsletter-option"]').val(1);
            else  $('input[name="newsletter-option"]').val(0);
        });
    });    
});	

$(window).resize(function(){		
    setTimeout(function(){
        $('.extra-nav').css('height',$('.logo-header').height());
    }, 60);
});

if(typeof(selectLanguage)!="function"){
    
    function selectLanguage(){        
        /*var code = jQuery.cookie('Quick_user_lang_code');
        var language = jQuery.cookie('Quick_lang');*/
        var code = zozoneNailParams.langCode;
	    var language = zozoneNailParams.langName;
        var blanguage_default = true;		

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
}

$.disableSubmit = function(flag){
    let btn = $('button[type="submit"]');
    if(flag){
        btn.data('text', btn.text()).text('').removeClass('site-button').addClass('loading').addClass('disabled').prop('disabled', 1);
    }else{
        btn.text(btn.data('text')).addClass('site-button').removeClass('loading').removeClass('disabled').prop('disabled', 0);
    }
};

$.commonAjaxHandler = function(){    
    let theform = arguments[0];
    let themsg = $('#themsg');
    let result = 0;
    let successURI = arguments.length>=2 ? arguments[1] : null;
    let logconsole = arguments.length>=3 ? arguments[2] : 0;
    let timeoutmilisec = arguments.length>=4 ? arguments[3] : 3000;
	let request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: $(theform).serialize(),
		success : function(rp){            
			if(logconsole) console.log(rp);
            try{
                result = $.parseJSON(rp);
                if(result.error){
                    themsg.text(result.msg).slideDown();                    
                }else{
                    themsg.toggleClass('text-danger').addClass('text-success').text(result.msg).slideDown();
                }
            }catch(e){ console.log(e.message); }
		}
	});
    request.always(function(){       
        if(result){
            if(result.error){ 
                /*setTimeout( function(){ themsg.slideUp(); }, timeoutmilisec ? timeoutmilisec : 4000);*/
                $.disableSubmit(0);
            }
            else{
                if(successURI != null){
                    setTimeout(function(){
                        document.location = successURI;
                    }, timeoutmilisec);
                }
            }
        }else{
            $.disableSubmit(0);
        }
    });
    return false;
};

$.logMeIn = function(theform){
    let themsg = $('#themsg');
    let attr = 'invalid-email';
    let p = $('#secret').val();
    let e = $('#e').val();
    let elm = $('#e');
    let error = 0;

    if(!e.isEmail()){
        ++error;
        attr = 'invalid-email';
    }
    if(!error && !p.isPwd()){
        ++error; attr = 'invalid-pwd'; elm = $('#secret');
    }

    if(error){
        themsg.showStatusMsg(attr, elm);
        return false;
    }

    $('input[name="e"]').val(e.encode());
    $('input[name="p"]').val(p.encode());
    $.disableSubmit(1); 
    $.commonAjaxHandler(theform, zozoneNailParams.bookingSiteURI, 1, 0);

    return false;
};/*logmein*/

$.changePwd = function(_form){    
    try{
        $.changePwdSubmit(_form);
    }catch(e){ console.log(e.message); }
    return false;
};

$.signMeUp = function(_form){
    if(!$.validateSignupData()){
        return false;
    }

    $('input[name="e"]').val($('#email').val().encode());
    $('input[name="p"]').val($('#secret').val().encode());
    $('input[name="secret"]').val(zozoneNailParams.apiKey);
    $.disableSubmit(1); 

    $.commonAjaxHandler(_form, zozoneNailParams.loginSiteURI, 1);
};

$.forgotPwd = function(_form){
    let themsg = $('#themsg');
    let attr = 'text';
    let e = $('#e').val();    
    if(!e.isEmail()){        
        themsg.showStatusMsg('text', $('#e'));
        return false;
    }
    $('input[name="email"]').val(e);
    $.disableSubmit(1); 

    $.commonAjaxHandler(_form, zozoneNailParams.loginSiteURI, 1);
};

$.validateSignupData = function(_form){
    let themsg = $('#themsg');
    if(!$('#firstname').val().length){
        return themsg.showStatusMsg('field-req', $('#firstname'));
    }
    if(!$('#lastname').val().length){
        return themsg.showStatusMsg('field-req', $('#lastname'));
    }
    if(!$('#email').val().isEmail()){
        return themsg.showStatusMsg('invemail', $('#email'));
    }
    if(!$('#secret').val().isPwd()){
        return themsg.showStatusMsg('pwd-pat', $('#secret'), 10);
    }
    if($('#secret').val() != $('#secret2').val()){
        return themsg.showStatusMsg('pwd-not-match', $('#secret2'));
    }
    return true;    
};

$.changePwdSubmit = function(theform){    
    let e = $('#e').val().decode();
    let r = $('#r').val();
    let t = $('#t').val();
    let f = $('#f').val();
    let themsg = $('#themsg');
    let sinvalid = themsg.data('invalid');
    let snotmath = themsg.data('notmatch');
    let pwd = $('#secret').val();
    let pwd2 = $('#secret2').val();
    let error = 0;
    if(!pwd.isPwd()){
        themsg.text(sinvalid); $('#secret').select(); ++error;
    }
    if(!error && pwd != pwd2){
        themsg.text(snotmath); $('#secret2').select(); ++error;
    }
    if(error){
        themsg.slideDown(); setTimeout(function() { themsg.slideUp(); }, 4000);
        return false;
    }

    $('input[name="secret"]').val(zozoneNailParams.apiKey);
    $('#p').val(pwd.encode());
    $.disableSubmit(1);

    let result = 0;
	let request = $.ajax({
		method  : 'POST',
		url     : zozoneNailParams.ajaxURL,
		data	: $(theform).serialize(),
		success : function(rp){			
			console.log(rp);
            try{
                result = $.parseJSON(rp);
                if(result.error){
                    themsg.text(result.msg).slideDown();
                }else{
                    themsg.toggleClass('text-danger').addClass('text-success').text(result.msg).slideDown();
                }
            }catch(e){ console.log(e.message); }
		}
	});
    request.always(function(){       
        if(result){
            if(result.error){ 
                setTimeout( function(){ themsg.slideUp(); }, 2500);
                $.disableSubmit(0);
            }
            else{
                setTimeout(function(){
                    document.location = zozoneNailParams.loginSiteURI+'?login';
                }, 4000);
            }
        }else{
            $.disableSubmit(0);
        }
    });
    return false;
};/*changePwdSubmit*/

String.prototype.trim = function(){
	if(this.length) return this.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	return "";
};
String.prototype.isEmail = function(){
	var re = /^([a-zA-Z_]+)([a-zA-Z0-9._%-]+)@[\w0-9.-]+\.[\w]{2,4}$/;
	return this.match(re);
};
String.prototype.isPwd = function(){
	var reg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
	return this.match(reg);
};

String.prototype.encode = function(){
	return HexCodec.encode2(btoa(this));
};
String.prototype.decode = function(){
	return atob(HexCodec.decode2(this));
};

var HexCodec = {
	g_szHex:"0123456789abcdef",
	key_gen:function (str){
		var s = new String(str);
		s = s.toUpperCase();
		var key=0;
		for(i=0; i<s.length; ++i)
			key += s.charCodeAt(i);
		return key%255;
	},
	encode:function(str, szKey){
		var key = HexCodec.key_gen(szKey);
		var s = new Array(str.length);
		var szOut = new String("");
		for(i=0; i<s.length; ++i)
		{
			s[i] = str.charCodeAt(i);
			s[i] ^= key; /*mask with the key*/
			szOut += HexCodec.dec2hex(s[i]);
		}			
		return szOut;
	},	
	encode2:function (str){
		var szKey = HexCodec.dec2hex(eval(str.length));
		var key = HexCodec.key_gen(szKey);		
		var s = new Array(str.length);
		var szOut = new String("");
		for(i=0; i<s.length; ++i){
			s[i] = str.charCodeAt(i);
			s[i] ^= key; /*mask with the key*/
			szOut += HexCodec.dec2hex(s[i]);
		}				
		return szOut + szKey + HexCodec.dec2hex(eval(szKey.length));
	},	
	decode2:function(str){
		var s = new String(str);
		var key_length = HexCodec.hex2dec(s.substring(s.length-2, s.length));
		var szKey = s.substring(s.length-2-key_length, s.length-2);		
		return HexCodec.decode(s.substring(0, s.length-2-key_length), szKey);
	},	
	
	decode:function(str, szKey){
		var key = HexCodec.key_gen(szKey);			
		var s = new Array(str.length/2);
		var szOut = new String("");
		
		for(i=0; i<str.length/2; ++i){
			s[i] = HexCodec.hex2dec(str.substring(i*2, i*2 + 2));
			s[i] ^= key;
			szOut += String.fromCharCode(s[i]);
		}
		return szOut;
	},	
	
	dec2hex:function(digit){
		if(digit>255)
			return NaN;
		return HexCodec.g_szHex.charAt(digit/16) + '' + HexCodec.g_szHex.charAt(digit%16);
	},
	
	hex2dec:function(hexStr){
		return parseInt(hexStr, 16);
	}
};

/*plgin*/
(function($){
    $.fn.showStatusMsg = function(attr, elm){
        let $this=  $(this);
        let text = $(this).data(attr);
        $(this).text(text).slideDown();        
        setTimeout( function() {
            $this.slideUp();
        } , arguments.length==3 && !isNaN(arguments[2]) ? arguments[2]*1000 : 2500 );
        if(elm && elm[0]) elm.select();        
        return false;
	};
})( jQuery );
<?php if(0){?>
</script>
<?php }

ob_end_flush();
function minfield($str){
    return $str;
    return preg_replace("/\r|\n|\t+|\s{3,}/", "", $str);
}
?>