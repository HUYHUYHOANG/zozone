<?php
session_write_close();
session_start();

require_once('../../../includes/config.php');
require_once('../../../includes/sql_builder/idiorm.php');
require_once('../../../includes/db.php');
require_once('../../../includes/lang/lang_' . (isset($_COOKIE['Quick_lang']) ? $_COOKIE['Quick_lang'] : 'english') . '.php');
require_once('../lib/request.lib.php');
require_once('../lib/codec.lib.php');
require_once('../lib/pagination.lib.php');
require_once('./base.class.php');

CShopBOAjaxApp::loadAllOptionsInTemplate($config);

new CShopBOAjaxApp();

class CShopBOAjaxApp{

    public function __construct(){

        session_write_close();
        session_start();
        
        $authString = $_SESSION['user']['login_string'];
        if(!isset($authString)) return;
        if(!isset($_GET[$authString])) return;

        define("LPCTSTR_TOKEN", true); 
        
        $this->_handleRequest();
    }

    private function _handleRequest(){
        $msg = '';
        $component = 0;
        $m = CRequest::getStr('m');
        if(!$m) $m = CRequest::postStr('m');
        $md = $m.'-ctrl';
        $f = sprintf("%s.class.php",$md);        
        if(is_file($f)){            
            include($f);
            
            if(class_exists($class="c".str_replace("-", "", $md))){

                global $config;
                $component = new $class($config, $_SESSION['user']['shop_id']);
                $action = CRequest::getStr('d0');
                if(!$action) $action = CRequest::postStr('d0');
                if($action){
                    $method = str_replace("-", "", $action);
                    if(method_exists($component, $method)){                        
                        $component->{$method}();
                    }else{
                        $msg = '-505 Invalid param';
                    }
                }else{
                    $msg = '-505 Invalid param';
                }
            }
        }else{            
            $msg = '-505 Object not found';
        } 
        if($msg){            
            die(json_encode(array('error'=>true, 'err-msg'=>$msg)));
        }
    }

    public static function loadAllOptionsInTemplate(&$config){

        $info = ORM::for_table($config['db']['pre'].'options')->find_many();
    
        foreach ($info as $data){
    
            $key = $data['option_name'];
            $value = $data['option_value'];
            if($key == 'lang')
                $config['default_lang'] = $value;
    
            if($key == 'site_url'){
                $value = self::get_site_url($value);
            }
            if($key == 'app_url'){
                $site_url = self::get_site_url($value);
                $value = $site_url."php/";
            }
            $config[$key] = ($value);
        }

        self::get_shop_smtp_info();
    }

    private static function get_site_url($site_url){
        //If it's not empty
        if (!empty($site_url)) {
            // Check if SSL enabled
            if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
                $protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https" ? "https://" : "http://";
            else
                $protocol = !empty($_SERVER['HTTPS']) && $_SERVER["HTTPS"] != "off" ? "https://" : "http://";
    
            $link = self::get_the_value($site_url);
    
            $params = explode('.', $_SERVER["HTTP_HOST"]);
    
            if($params[0] == 'www') {
                // www exists
                $link = "www.".$link;
            }else{
                // non www
            }
    
            return $site_url = $protocol.$link;
        }
        return $site_url;
    }

    private static function get_the_value($link){
        //If it's not empty
        if (!empty($link)) {
            //If it begins with https...
            if (preg_match('/^https/', $link)) {
                //...then we'll set the $url_prefix variable to https://
                $url_prefix = 'https://';
            } else {
                //If it does not begin with https we'll use http
                $url_prefix = 'http://';
            }
            //Get rid of the http:// or https://
            $link = str_replace(array('http://', 'https://'), '', $link);
            return self::check_www_in_url($link);
        }
        return $link;
    }
    
    private static function check_www_in_url($link){
        $params = array();
        //If it's not empty
        if (!empty($link)) {
            $params = explode('.', $link);
    
            if($params[0] == 'www') {
                // www exists
            }else{
                // non www
            }
            //Get rid of the www.
            return  str_replace("www.", '', $link);
        }
        return $link;
    }

    private static function get_shop_smtp_info(){
        global $config;
        $info = ORM::for_table($config['db']['pre'].'shop')->select_many('shop_smtp_user', 'shop_smtp_secret')->find_one($_SESSION['user']['shop_id']);
        if($info){
            $config['smtp_username'] = $info->shop_smtp_user;            
            $config['smtp_password'] = $info->shop_smtp_secret;
        }        
    }
}
?>