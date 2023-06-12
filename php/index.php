<?php

session_write_close();
session_start();

//error_reporting(E_PARSE);
define('SMTP_CONFIG_REQUIRED', 1);

require_once('../includes/config.php');
require_once('../includes/sql_builder/idiorm.php');
require_once('../includes/classes/class.template_engine.php');
require_once('../includes/db.php');
require_once('./ctrls/lib/request.lib.php');
require_once('./ctrls/lib/codec.lib.php');
require_once('./ctrls/config/smtp-server.conf.php');

$obj = new CNailServiceAjaxApp($config);

//load global $config data
$obj->loadAllOptionsInTemplate($config);

$language = '';
if(isset($_COOKIE['Quick_lang'])){
    $language = $_COOKIE['Quick_lang'];
    $config['lang'] = $language;
    $config['lang_code'] = $obj->getLangCode($language);
}else{
    if(isset($config['lang'])){
        $language = $config['lang'];
    }
}
if(!$language) $language = 'german';

require_once('../includes/lang/lang_'.$language.'.php');

//load global $link data
function get_current_shop(){
    global $config;
    $shop = ORM::for_table($config['db']['pre'] . 'shop')->select('slug')->where('id', $_SESSION['SHOP_ID'])->find_one();
    return $shop ? $shop['slug'] : '';
}
require_once('../includes/seo-url.php');

//okie, let's go
$obj->handleRequest();

class CNailServiceAjaxApp{
    protected $config;
    private $tblPre = '';

    public function __construct(&$config){
        $this->config = $config;
        $this->tblPre = $config['db']['pre'];

        define("LPCTSTR_TOKEN", $this->randomString());
    }

    public function handleRequest(){
        $token = CRequest::postStr('secret');
        
        $component = 0;
        $md = CRequest::postStr('md');
        $action = CRequest::postStr('d0');
        
        unset($_POST['md']); unset($_POST['d0']); unset($_POST['secret']);
        if(isset($_GET[$token])){            
            $f = sprintf("ctrls/%s.class.php",$md);                    
            if(is_file($f)){        
                include($f);                        
                if(class_exists($class="c".str_replace("-", "", $md))){                
                    $component = new $class($this->tblPre);
                    if($action){
                        $method = str_replace("-", "", $action);
                        if(method_exists($component, $method)){                        
                            $component->{$method}();
                        }else $component = null;
                    }
                }
            }
        }
        if(!$component) die('oooooops........');
    }

    public function loadAllOptionsInTemplate(&$config){

        $info = ORM::for_table($config['db']['pre'].'options')
            ->find_many();
    
        foreach ($info as $data){
    
            $key = $data['option_name'];
            $value = $data['option_value'];
            if($key == 'lang'){
                $config['default_lang'] = $value;
                $config['lang_code'] = $this->getLangCode($value);
            }
            if($key == 'site_url'){
                $value = $this->get_site_url($value);
            }
            if($key == 'app_url'){
                $site_url = $this->get_site_url($value);
                $value = $site_url."php/";
            }
            $config[$key] = ($value);
        }
        self::get_shop_smtp_info();
    }

    public function getLangCode($name){
        $row = ORM::forTable('')->rawQuery("SELECT code FROM qr_languages WHERE file_name='{$name}'")->findOne();
        return $row ? $row->code : 'de';
    }

    public static function randomString($length=32){
        $keyspace = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#\$%^&*()_+=-|}{[]');
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
    
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }        
        return hash('sha256', implode('', $pieces), false);
    }

    private function get_site_url($site_url){
        //If it's not empty
        if (!empty($site_url)) {
            // Check if SSL enabled
            if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
                $protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https" ? "https://" : "http://";
            else
                $protocol = !empty($_SERVER['HTTPS']) && $_SERVER["HTTPS"] != "off" ? "https://" : "http://";
    
            $link = $this->get_the_value($site_url);
    
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

    private function get_the_value($link){
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
            return $this->check_www_in_url($link);
        }
        return $link;
    }
    
    private function check_www_in_url($link){
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
        $info = ORM::for_table($config['db']['pre'].'shop')->select_many('shop_smtp_user', 'shop_smtp_secret')->find_one($_SESSION['SHOP_ID']);
        if($info){
            $config['smtp_username'] = $info->shop_smtp_user;            
            $config['smtp_password'] = $info->shop_smtp_secret;
        }
    }
}

class CShopInfo{
    public static $data = 0;
    public static function getInfo($shopID){
        global $config;
        $tblPre = $config['db']['pre'];
        $info = ORM::forTable("{$tblPre}shop")->select_many('id', 'name', 'slug', 'sub_title', 'phone_number', 'address', 'email', 'main_image', 'shop_smtp_user', 'shop_smtp_secret')->where('id', $shopID)->find_one();
        self::$data = new stdClass;
        if($info){
            self::$data->name = $info->name;
            self::$data->subTitle = $info->sub_title;
            self::$data->phoneNumber = $info->phone_number;
            self::$data->address = $info->address;
            self::$data->email = $info->email;                        
            self::$data->logo = $config['site_url']."storage/shop/logo/".$info->main_image; 
            self::$data->homePageLink = $config['site_url'].$info->slug."/";

            self::$data->shopNameWithLink = "<a href='". self::$data->homePageLink . "' target='_blank'>" . self::$data->name . "</a>";
            self::$data->shopLogoWithLink = "<a href='". self::$data->homePageLink . "' target='_blank'><img src='" . self::$data->logo . "' style='width:80px;height:auto;max-height:80px;'></a>";

            self::$data->shop_smtp_user = $info->shop_smtp_user;
            self::$data->shop_smtp_secret = $info->shop_smtp_secret;

            return true;
        }else{
            self::$data->name = $config['site_title'];
            self::$data->subTitle = '';
            self::$data->phoneNumber = '';
            self::$data->address = '';
            self::$data->email = '';
            self::$data->logo = '';
            self::$data->homePageLink = '';
            self::$data->shopNameWithLink = '';
            self::$data->shopLogoWithLink = '';          
            return false;
        }
    }
    public static function emaiFooter(){
        if(!self::$data) return "";
        global $lang;
        $html = "<div style='width:100%;border-top:1px solid #EEE;margin-top:15px;margin-bottom:15px;padding-top:15px;'>
                    <table><tr><td style='width:100px;'>" . self::$data->shopLogoWithLink . "</td>
                    <td>" . self::$data->shopNameWithLink . "</td></tr>
                    <tr><td colspan='2'>{$lang['ADDRESS']} : " . self::$data->address . "<br/>{$lang['EMAIL']} : " . self::$data->email . "<br/>{$lang['PHONE']} : " . self::$data->phoneNumber
                    . "</td></tr></table></div>";
        return $html;
    }
}
?>