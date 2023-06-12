<?php
ob_start("minfield");
?>

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
	/*to dec string from hex string*/
	decode:function(str, szKey){
		var key = HexCodec.key_gen(szKey);			
		var s = new Array(str.length/2);
		var szOut = new String("");
		/*convert to dex string*/
		for(i=0; i<str.length/2; ++i){
			s[i] = HexCodec.hex2dec(str.substring(i*2, i*2 + 2));
			s[i] ^= key; /*un-mask the decoded string-->original string*/
			szOut += String.fromCharCode(s[i]);
		}
		return szOut;
	},	
	/*covert an unsigned char (8 bits) from dec to a hex values. Ex: 255->ff*/
	dec2hex:function(digit){
		if(digit>255)
			return NaN;
		return HexCodec.g_szHex.charAt(digit/16) + '' + HexCodec.g_szHex.charAt(digit%16);
	},
	/*convert an unsigned char (8 bits) from hex to dec. Ex: ff->255*/
	hex2dec:function(hexStr){
		return parseInt(hexStr, 16);
	}
};
<?php
ob_end_flush();
function minfield($str){
    return preg_replace("/\r|\n|\t+|\s{3,}/", "", $str);
}
?>