<?php
class CRequest{
	public static function getNbr($k, $default=0){
		return CRequest::getInt($k, $default);
	}
	
	public static function getInt($k, $default=0){
		if(isset($_GET[$k])) return intval($_GET[$k]);
		return $default;
	}
	public static function getStr($k, $default=""){
		if(isset($_GET[$k])){
			$s = self::stripTags(trim($_GET[$k]));
			//if(get_magic_quotes_gpc()) return stripcslashes($s);
			return $s;
		}
		return $default;
	}
	
	public static function postNbr($k, $default=0){
		return CRequest::postInt($k, $default);
	}
	
	public static function postInt($k, $default=0){
		if(isset($_POST[$k])) return intval($_POST[$k]);
		return $default;
	}
	public static function postStr($k, $default=""){
		if(isset($_POST[$k])){
			$s = self::stripTags(trim($_POST[$k]));
		//	if(get_magic_quotes_gpc()) return stripcslashes($s);
			return $s;
		}
		return $default;
	}
	public static function safePostStr($k, $default=""){
		$v = CRequest::postStr($k, $default);
		if($v){
			if(get_magic_quotes_gpc()) $v = stripcslashes($v);
			return mysql_real_escape_string($v);
		}
		return $default;		
	}

	public static function validateEmail($email){
		return preg_match("|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i", $email);
	}

	public static function stripTags($str){
		$search = array('\'', '"', '\r\n');
		$replace = array('&#8216;', '&#8220;', '<br/>'); 
		$str = str_replace($search, $replace, $str);
		return strip_tags($str, '<br>');
	}

	public static function escUrl($url) {
		if (!strlen($url)) return $url;
	
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = (string) $url;	
		$count = 1;
		while ($count) {
			$url = str_replace($strip, '', $url, $count);
		}
	
		$url = str_replace(';//', '://', $url);	
		$url = htmlentities($url);	
		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);	
		if ($url[0] !== '/') {			
			return '';
		}
		return $url;
	}

	public static function splitName($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
		if(empty($first_name)) $first_name = $last_name;
        return array($first_name, $last_name);
    }
}

class JsonHelper{
	public static function getValByLangCode($jsonText, $langCode='de'){
		$json = json_decode($jsonText);
		$text = '';
		if($json){
			if(isset($json->{$langCode})) $text = $json->{$langCode};
			elseif(isset($json->de)) $text = $json->de;
			else $text = array_values((array)$json)[0];
		}
		return $text;
	}

	public static function getActiveLangCodes(){
		$arr = get_language_list(0, 0, 1);
		$items = array();
		foreach($arr as $item){
			$items[] = $item['code'];
		}
		return count($items) ? $items : false;
	}
}
?>