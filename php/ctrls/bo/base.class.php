<?php

define("PAGINATION_ROWS_PER_PAGE", 10); //NUMBER OF ROWS WILL BE DISPLAYED EACH PAGE

define("EMPLOYER", "employer");

////////////////////////////////////////////////////////////////////////////////
// base CTRL CLASS
////////////////////////////////////////////////////////////////////////////////

class CBoCtrl{
    protected $config;
    protected $shopID;
    public $model;
    public $view;

    public function __construct(&$config, $shopID){
        $this->config = $config;    
        $this->shopID = $shopID;
    }

    public static function generateSessionKey(){
        $now = uniqid();        
        $_SESSION['__TST_KEY__'] = $now;
        return CCodec::encode($now);
    }

    public static function checkSessionKey(&$output=null){        
        $tk = $_SESSION['user']['login_string'];
        $ptkn = CRequest::postStr($tk);
        if(!is_null($output)){
            $output = "Session: " . $_SESSION['__TST_KEY__'] . " ; Sent token: " . $ptkn;
        }
        
        if($ptkn && isset($_SESSION['__TST_KEY__'])){            
            return $_SESSION['__TST_KEY__'] == $ptkn;
        }else{

        }
        return false;
    }

    public static function keyExists($key, $type = 'post'){
        return $type=='post' ? isset($_POST[$key]) : isset($_GET['key']);;
    }

    public function validateParamArray($adata, &$errorField){
        if(!count($adata)) return false;
        foreach($adata as $key => $value){
            $value = strip_tags($value, '<br>');
            if(!$this->validateParam($key, $value, $errorField)) return false;
        }
        return true;
    }

    protected function validateParam($key, $value, &$errorField){
        return true;
    }

    public static function getUser(){
        return isset($_SESSION['user']) ? (object)$_SESSION['user'] : null;
    }

    public static function getUserType(){
        return isset($_SESSION['user']['user_type']) ? $_SESSION['user']['user_type'] : '';
    }

    public static function googleTranslate($text, $language){        
        global $config;
        $ref = $text;
        $apiKey = $config['google_translate_api_key'];        

        if (empty($apiKey)) return $ref;
        try{
            $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&target=' . $language;
            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handle);
            $responseDecoded = json_decode($response, true);
            curl_close($handle);
            if (!empty($responseDecoded['data']['translations'][0]['translatedText'])) {
                $ref = $responseDecoded['data']['translations'][0]['translatedText'];
            }
        }catch(Exception $e){            
        }

        return $ref;
    }
}

////////////////////////////////////////////////////////////////////////////////
// base DATA CLASS
////////////////////////////////////////////////////////////////////////////////

class CBoLogicData{
    protected $config;    
    protected $pager;
    protected $searchData;
    protected $shopID;
    protected $data;
    protected $tableName;
    protected $tblPre;

    public function __construct(&$config, $shopID){
        $this->config = $config;    
        $this->shopID = $shopID;
        $this->tableName = '';
        $this->tblPre = $config['db']['pre'];
    }

    public function __get($name){
        if($name=='data') return $this->data;
        elseif($name=='pager') return $this->pager;
        elseif($name=='searchData') return $this->searchData;
        elseif($name=='tblPre') return $this->tblPre;
        elseif($name=='userType') return CBoCtrl::getUserType();
        elseif($name=='shopID') return $this->shopID;
        return null;
    }

    public function prepareSQL($data, $type='insert', $tableName=null){
        $sqlVal = ''; $sql = '';
        $count = count($data); $idx = 0;
        foreach($data as $k => $v){
            if($k=='id'){
                ++$idx;
                continue;
            } 

            $v = CRequest::postStr($k);
            $data[$k] = $v;

            if($type == 'update'){
                $sqlVal .= "{$k} = :{$k}";
                if(++$idx < $count) $sqlVal .= ',';
            }elseif($type=='insert'){//insert query
                $sql .= "{$k}";
                $sqlVal .= ":{$k}";
                if(++$idx < $count){
                    $sql .= ','; $sqlVal .= ',';
                }
            }
        }
        $sqlVal = trim($sqlVal, ",");
        if(empty($tableName) || is_null($tableName)) $tableName = $this->tableName;
        if($type=='insert') $sql = "INSERT INTO {$tableName}({$sql}) VALUES({$sqlVal})";
        else $sql = "UPDATE {$tableName} SET {$sqlVal} WHERE id={$data['id']}";
        
        return $sql;
    }

    public static function extractDateFromString($date, &$count){
        if(empty($date)) return false;
        $date = preg_replace('/\s+/', '', $date);
        $dates = explode('-', $date, 2);
        $count = count($dates);        
        return $dates;
    }
    
    public function formatPrice($nbr, $ccode='€'){
        return number_format($nbr, 2) . " {$ccode}";
    }

    public static function isDateTime($date, $format = 'Y-m-d H:i'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function isEmployer(){
        return CBoCtrl::getUserType() == EMPLOYER;
    }

    public static function getServiceNames($ids){
        $rows = ORM::forTable('qr_menu')->select('name')->where_in('id', explode(',', $ids))->findMany();        
        $names = ''; $count = count($rows); $idx = 0;        
        foreach($rows as $row){
            $names .= $row['name'];
            if($idx++ < $count-1) $names .= ', ';            
        }
        return $names;
    }

    public static function getServiceCategoryNames($ids){
        $rows = ORM::forTable('qr_catagory_main')->select('cat_name')->where_in('cat_id', explode(',', $ids))->findMany();
        $names = ''; $count = count($rows); $idx = 0;        
        foreach($rows as $row){
            $names .= $row['cat_name'];
            if($idx++ < $count-1) $names .= ', ';
        }
        return $names;
    }

    public function &getClientsList(){
        $rows = ORM::forTable('qr_customers')->select_many(array('id','name','phone','email'))->where('shop_id', $this->shopID)->where('deleted',0)->order_by_asc('name')->findMany();
        return $rows;
    }

    public function &getTheStaffsList(){
        $rows = ORM::forTable('qr_user')->select_many(array('id','name'))->where('shop_id', $this->shopID)->where('deleted',0)->where('is_active',1)->order_by_asc('name')->findMany();
        return $rows;
    }

    public function &getLanguages($selCode=''){
        $rows = ORM::forTable('qr_languages')->select_many(array('code', 'name'))->where('active',1)->order_by_asc('id')->find_many();
        $data = array();
        foreach($rows as $r){
            $data[$r['code']] = array('code'=>$r['code'], 'name' => $r['name'], 'selected' => $selCode==$r['code']?'selected':'');
        }
        return $data;
    }
}


////////////////////////////////////////////////////////////////////////////////
// base VIEW CLASS
////////////////////////////////////////////////////////////////////////////////
class CBoHtmlView{
    protected $language;
    protected $model;
    protected $arrLang;

    public function __construct(&$model){
        $this->language = isset($_COOKIE['Quick_lang'])?$_COOKIE['Quick_lang']:'english';
        $this->model = $model;
    }

    public function defaultView(){        
    }

    protected function formarDate($date){
        if($this->language=='vietnamese'){
            $d = date('d', $date); $m = date('m'); $y = date('Y');
            return sprintf('Ngày %d tháng %d năm %d', $d, $m, $y);
        }
        elseif($this->language=='english') return date('M d, Y', $date);
        return date('M d, Y', $date);
    }

    protected function formatPrice($nbr, $ccode='€'){
        return $this->model->formatPrice($nbr, $ccode);
    }
}

////////////////////////////////////////////////////////////////////////////////
// shop helper class
////////////////////////////////////////////////////////////////////////////////
if(!class_exists("CShopInfo")){
    class CShopInfo{
        public static $data;
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
}//class_exists
?>