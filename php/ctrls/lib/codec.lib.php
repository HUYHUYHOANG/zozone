<?php
	class CCodec{
		private static $g_szHex = "0123456789abcdef";
		
		private static function key_gen($str){
			$s = strtoupper($str);			
			$key=0;
			for($i=0; $i<strlen($s); ++$i){
				$key += ord($s[$i]);
			}
			return $key%255;
		}
		
		private static function dec2hex($digit){
			if($digit>255)
				return -1;
			$i = (int)($digit/16);
			$j = $digit%16;
			return self::$g_szHex[$i] . self::$g_szHex[$j];
		}
		
		private static function _decode($str, $szKey){
			$key = self::key_gen($szKey);
			$szOut = "";
			for($i=0; $i<strlen($str)/2; ++$i)
			{
				$tmp = hexdec(substr($str, $i*2, 2));				
				$tmp ^= $key;
				$szOut .= chr($tmp);
			}		
			return $szOut;
		}
		
		public static function encode($str){
			if(!$str) return false;
			$str = base64_encode($str);
			$szKey = self::dec2hex(strlen($str));
			$key = self::key_gen($szKey);			
			$szOut = "";
			for($i=0; $i<strlen($str); ++$i){
				$tmp = ord($str[$i]);
				$tmp ^= $key;
				$szOut .= self::dec2hex($tmp);
			}
			
			return $szOut . $szKey . self::dec2hex(strlen($szKey));
		}
		
		public static function decode($str, $oldEnc=0){
			$s = $str;
			$len = strlen($str);
			$key_length = hexdec(substr($str, $len-2, 2));
			$szKey = substr($str, $len-2-$key_length, $key_length);
			if($oldEnc) return self::_decode(substr($str, 0, $len-2-$key_length), $szKey);
			return base64_decode(self::_decode(substr($str, 0, $len-2-$key_length), $szKey));
		}		
	}
?>