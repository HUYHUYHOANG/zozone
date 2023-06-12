<?php

defined("LPCTSTR_TOKEN") or die(":-((");

class CCustomerService{    
    private $tableName;
    private $shopId=0;
    private $slug = 0;    
    private $sessionName;
    private $data = false;
    private $returnError = 0;

    public function __construct($tblPre){        
        $this->tableName = $tblPre.'customers';
        $this->shopId = $_SESSION['SHOP_ID'];
        $this->slug = get_current_shop();

        $this->sessionName .= "__ZZ_CUSTOMER__:__{$this->shopId}_";

        if(isset($_SESSION[$this->sessionName])){
            $this->data = (object)$_SESSION[$this->sessionName];         
        }
        $this->returnError = (object)(array('error' => 0, 'message' => '', 'errorType' => ''));
    }

    public function __get($name){
        if($name=='slug') return $this->slug;
        elseif($name=='name'){
            return $this->data ? $this->data->name : '';
        }elseif($name=='email') return $this->data ? $this->data->email : '';
        elseif($name=='phone') return $this->data ? $this->data->phone : '';
        elseif($name=='data') return $this->data;
        return false;
    }

    public function sendForgotPwdRequest(){
        global $lang, $config;
        $email = CRequest::postStr('email');
        $json = new stdClass;
        $json->error = 0; $json->message = $lang['CONFIRMATION_MAIL_SENT'].' '.$lang['CHECKEMAILFORGOT'];
        if(!CRequest::validateEmail($email)){
            $json->error = 13; $json->message = $lang['EMAILINV'];
            $json->msg = $json->message;
            echo json_encode($json);
            return 0;
        }

        if($this->checkAccountExists($email)){
            $custId = $this->getIdByEmail($email);        
            // Send the email
            if(!$this->sendForgotEmail($email, $custId)){
                $json->error = 1;
                $json->message = $lang['ERROR_TRY_AGAIN'] . " [" . $config['email_result']['message'] . "]";                
            }    
        }else{
            $json->error = 1; $json->message = $lang['EMAILNOTEXIST'];
        }
        $json->msg = $json->message;
        echo json_encode($json);
    }

    public function getIdByEmail($email){
        $info = ORM::for_table($this->tableName)->select('id')->where('email', $email)->find_one();    
        return isset($info['id']) ? $info['id'] : FALSE;
    }

    public function checkAccountExists($email){
        $count = ORM::for_table($this->tableName)->where('email', $email)->count();
        return $count;
    }

    public function sendForgotEmail($to,$id){
        global $config, $lang,$link;        

        $time = time();
        $rand = $this->getRandNum(10);
        $forgot = md5($time.'_:_'.$rand.'_:_'.$to);
        
        $person = ORM::for_table($this->tableName)->find_one($id);
        $person->forgot = $forgot;
        $person->save();

        $custData = $this->getCustmerData(null,$id);
        $to_name = $custData['name'];

        $page = new HtmlTemplate();
        $page->html = $config['email_sub_forgot_pass'];
        
        $page->SetParameter ('EMAIL', $to);
        $page->SetParameter ('USER_FULLNAME', $to_name);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);
        
        $forget_password_link = $config['site_url'].$this->slug."/login?forgot=".$forgot."&r=".$rand."&e=".$to."&t=".$time;
        $page = new HtmlTemplate();
        $page->html = $config['email_message_forgot_pass'];
        $page->SetParameter ('FORGET_PASSWORD_LINK', $forget_password_link);
        $page->SetParameter ('EMAIL', $to);
        $page->SetParameter ('USER_FULLNAME', $to_name);
        $email_body = $page->CreatePageReturn($lang,$config,$link);    
        
        $this->email($to,$to_name,$email_subject,$email_body);
        return !$config['email_result']['error'];
    }

    public function email($email_to,$email_to_name,$email_subject,$email_body,$bcc=array(),$email_reply_to=null, $email_reply_to_name=null){
        global $config;
        if($config['email_template']){
            $email_subject = stripcslashes(nl2br($email_subject));
        }        
        include(dirname(__FILE__).DIRECTORY_SEPARATOR."../../includes/mail/".$config['email_engine']."/init.engine.php");
    }

    public function getCustmerData($email=null, $userid=null){
        if($email != null)
            $info = ORM::for_table($this->tableName)->where(array('email'=>$email))->find_one();
        else
            $info = ORM::for_table($this->tableName)->where('id', $userid)->find_one();
        if (isset($info['id'])) {
            $data['id']         = $info['id'];
            $data['shop_id']    = $info['shop_id'];            
            $data['name']       = $info['name'];
            $data['email']      = $info['email'];            
            $data['password']   = $info['password_hash'];
            $data['forgot']     = $info['forgot'];

            return $data;
        }
        return 0;
    }

    private function getRandNum($length)
    {
        $randstr='';
        srand((double)microtime()*1000000);
        $chars = array ( 'a','b','C','D','e','f','G','h','i','J','k','L','m','N','P','Q','r','s','t','U','V','W','X','y','z','1','2','3','4','5','6','7','8','9');
        for ($rand = 0; $rand <= $length; $rand++)
        {
            $random = rand(0, count($chars) -1);
            $randstr .= $chars[$random];
        }

        return $randstr;
    }

    public function validateFogotPwdLink(&$outData, $lpfnSuccess = null){
        global $lang;
        $outData = new stdClass;
        $outData->state = 0;
        $outData->loginError = '';
        $outData->email = '';
        $outData->time = '';
        $outData->rand = '';
        $outData->forgot = '';

        if(!isset($_GET['forgot'])){
            $outData->loginError = $lang['FORGOTINV'];
            return false;
        } 
        
        $email = CRequest::getStr('e') ;
        if(!CRequest::validateEmail($email)){
            $outData->loginError = $lang['FORGOTINV'];
            return false;
        } 
        
        $forgot = CRequest::getStr('forgot');
        $checkForgot = ORM::for_table($this->tableName)->select_many('id', 'forgot', 'name')->where('email', $email)->find_one();

        $outData->email = $email;

        if($checkForgot && $forgot == $checkForgot->forgot)
        {   
            $time = CRequest::getStr('t');
            $rand = CRequest::getStr('r');
            $outData->time = $time;
            $outData->rand = $rand;

            if($forgot == md5($time . '_:_' . $rand . '_:_' . $email)){
                // Check that the link hasn't timed out (30 hours old)                
                if($time > (time()-108000)){
                    $outData->forgot = $forgot;
                    $outData->state = 1;
                    $outData->name = $checkForgot->name;                     
                }else{
                    $outData->loginError = $lang['FORGOTEXP'];
                }
            }else{
                $outData->loginError = $lang['FORGOTINV'];
            }
        }else{
            $outData->loginError = $lang['FORGOTINV'];
        }

        if(!empty($lpfnSuccess) && method_exists($this, $lpfnSuccess)){
            $this->{$lpfnSuccess}($checkForgot , $outData);
        }
        return empty($outData->loginError);
    }//validateForgotPwdLink

    public function changePwd(){
        foreach($_POST as $k=>$v){
            if($k == 'e') $v = CCodec::decode($v);
            $_GET[$k] = $v;
        }
        $_GET['forgot'] = $_POST['f'];       
        $data = false;
        $this->validateFogotPwdLink($data, "forgotPwdValidateCallback");
    }

    private function forgotPwdValidateCallback(&$customer, &$checkData){ 
        global $lang;
        if(!$checkData->state){
            echo json_encode( array( 'error' => 1, 'msg' => $checkData->loginError) );
            return;
        }
        $pwd = CCodec::decode($_POST['p']);
        $customer->password_hash = password_hash($pwd, PASSWORD_DEFAULT);
        $customer->forgot = '';
        $ret = $customer->save();

        if(!$ret) $checkData->loginError = $lang['ERROR_TRY_AGAIN'];
        else $checkData->loginError = $lang['PASSCHANGED'];
        echo json_encode( array( 'error' => ($ret+1)%2, 'msg' => $checkData->loginError) );
    }

    public function logMeIn($foutputJson = 1){
        global $lang;
        $result = new stdClass;
        $result->error = 1;
        $result->msg = '';
        $error = 0;
        
        $email = CCodec::decode(CRequest::postStr('e')); $pwd = CRequest::postStr('p');
        
        if(!CRequest::validateEmail($email)){
            ++$error; $result->msg = $lang['EMAILINV'];
        }
        
        if(!$error){
            $pwd = CCodec::decode($pwd);            
            $upc = preg_match('@[A-Z]@', $pwd);
            $lwc = preg_match('@[a-z]@', $pwd);
            $nbr    = preg_match('@[0-9]@', $pwd);
            $len = strlen($pwd);                
            if(!$upc || !$lwc || !$nbr || $len<6 || $len>20){
                $result->msg = $lang['PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS'];                    
                ++$error;
            }
        }
        
        if(!$error){
            $info = 0;
            if($this->login($email, $pwd, $info)){
                $this->updateLastActivity($info->id);
                //upate data
                $_SESSION[$this->sessionName] = array('id' => $info->id, 'name' => $info->name, 'email' => $email, 'phone' =>$info->phone, 'shop' => $info->shop_id, 'secret' => $info->password_hash);                
                $this->data = (object)$_SESSION[$this->sessionName];
            }else {
                ++$error;
                $result->msg = $lang['LOGIN_FAILED'];
            }
        }        
        
        $result->error = $error;
        $this->returnError->error = $result->error;
        $this->returnError->message = $result->msg;
        if($foutputJson) echo json_encode($result);
        return $error ? 0 : 1;
    }//login

    public function login($email, $pwd, &$info){
        $rows = ORM::for_table($this->tableName)->select_many('id', 'password_hash')->where(array('email'=>$email, 'shop_id'=>$this->shopId))->count();    
        if (!$rows) return 0;

        $info = ORM::for_table($this->tableName)->select_many('id', 'status', 'email', 'password_hash', 'name', 'phone', 'shop_id')->where(array('email'=>$email, 'shop_id'=>$this->shopId))->find_one();
        if(!$info) return 0;
        return password_verify($pwd, $info->password_hash) ? 1 : 0;
    } 
    
    public function checkLoggedIn(){
        if(!isset($_SESSION[$this->sessionName])) return 0;
        $data = (object)$_SESSION[$this->sessionName];
        
        try{
            $info = ORM::forTable($this->tableName)->findOne($data->id);
            if(!$info) return 0;            
            if($info->shop_id!=$data->shop || $info->email != $data->email || !hash_equals($info->password_hash, $data->secret)) return 0;
            $_SESSION[$this->sessionName] = array('id' => $info->id, 'name' => $info->name, 'email' => $info->email, 'phone' =>$info->phone, 'shop' => $info->shop_id, 'secret' => $info->password_hash);

        }catch(Exception $e){
            return 0;
        }
        return 1;
    }

    public function updateLastActivity($id){
        if($r = ORM::for_table($this->tableName)->findOne($id)){
            $r->last_activity = date('Y-m-d H:i:s');
            $r->save();
        }
    }    

    public function customerLoginRequestForm(){
        $json = new stdClass;
        $json->error = 0; $json->msg = '';
        $form = CRequest::postStr('form');
        if($form=="logout"){
            $this->logMeOut();
        }
        echo json_encode($json);
    }

    public function logMeOut(){
        
        if(isset($_SESSION[$this->sessionName])){            
            $_SESSION[$this->sessionName] = false;
            unset($_SESSION[$this->sessionName]);
        }
        require_once('booking-cart.class.php');
        TheBookingC2rt::clearCart($this->shopId);
        return 1;
    }

    public function signMeUp(){
        $this->addNewCustomer($_POST);
        $this->returnError->msg = $this->returnError->message;
        //send signup email

        //
        //echo json_encode($_POST);
        echo json_encode($this->returnError);
    }

    public function addNewCustomer(&$custData){
        global $lang;
        $data = (object)$custData;
        $email = CCodec::decode(($data->e));
        $pwd = CRequest::postStr('p');
        if(!CRequest::validateEmail($email)){
            $this->returnError->error = 1;
            $this->returnError->message = $lang['EMAILINV'];
            return 0;
        }else{
            //check if exists
            $checkInfo = $this->getCustmerData($email);
            if($checkInfo){
                $this->returnError->error = 1;
                $this->returnError->message = $lang['EMAIL_EXISTS'];                
                return 0;
            } 
        }

        if($pwd){
            $pwd = CCodec::decode($pwd);            
            $upc = preg_match('@[A-Z]@', $pwd);
            $lwc = preg_match('@[a-z]@', $pwd);
            $nbr    = preg_match('@[0-9]@', $pwd);
            $len = strlen($pwd);                
            if(!$upc || !$lwc || !$nbr || $len<6 || $len>20){
                $this->returnError->message = $lang['PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS'];                    
                $this->returnError = 1;
                return 0;
            }
        }

        $fname = CRequest::postStr('fname');
        $lname = CRequest::postStr('surname');
        if(!$fname || !$lname){
            $this->returnError->error = 1;
            $this->returnError->message = $lang['YOUR_NAME_REQUIRED'];
            return 0;
        }

        $phone = CRequest::postStr('phone');
        $newslettter = CRequest::postStr('newsletter-option');         
        
        $insertData = ORM::for_table($this->tableName)->create();
        $insertData->shop_id = $this->shopId;
        $insertData->name = $fname . ' ' . $lname;
        $insertData->phone = $phone;
        $insertData->email = $email;
        $insertData->created_at = date('Y-m-d H:i:s');
        $insertData->last_activity = date('Y-m-d H:i:s');
        $insertData->newsletter = $newslettter;
        $insertData->deleted = 0;

        if($pwd){
            $insertData->password_hash = password_hash($pwd, PASSWORD_DEFAULT);
        }
        $insertData->save();
        
        if($id = $insertData->id()){
            $this->data = $insertData;
            $this->data->id = $id;
            $this->returnError->message = $lang['THANKSIGNUP'];
            return 1;
        }
        return 0;
    }

    public function completeCustomerBooking(){
        $loginType = CRequest::postStr('login-type');
        $logged = 0; 
        $error = 0;
        $errorType = 'login';

        if($loginType=='login'){
            $logged = $this->logMeIn(0);
            if(!$logged){
                ++$error;
            }else $this->returnError->logged = 'logged';
        }else{
            $logged = $this->checkLoggedIn();
            if(!$logged){
                //create a new customer            
                if(!$this->addNewCustomer($_POST)) ++$error;
            }
        }

        if(!$error){
            require_once('service-booking-v20.class.php');
            global $config, $lang;
            $thebook = new CServiceBookingV20($config['db']['pre']);
         //   $success = $thebook->addBooking($this->data, $_POST, $this->returnError, $this);
        //    $errorType = 'booking';
        }   
      //  $this->returnError->errorType = $errorType;     
       // echo json_encode($this->returnError);
    }

    public function sendBookingEmail($bookingDetailHtml){
        //get template content
        global $config, $lang;
        
        $sql = "SELECT title, content, translation FROM qr_message_templates WHERE template_type='booking_success' AND send_via='email' AND active AND shop_id={$this->shopId}";
        $msg = ORM::forTable('')->rawQuery($sql)->findOne();
        $title = ''; $content = '';
        if($msg){
            $json = json_decode($msg->translation);
            $langCode = $config['lang_code'];
            $title = isset($json->{$langCode}->title) ? $json->{$langCode}->title : $msg->title;
            $content = isset($json->{$langCode}->content) ? $json->{$langCode}->content : $msg->content;
            $title = html_entity_decode($title);
            $content = html_entity_decode($content);
        }else{
            $title = $config['site_title'];
        }
        
        CShopInfo::getInfo($this->shopId);
        $shopName = "<p>" . CShopInfo::$data->shopNameWithLink 
                  . "</p><p>{$lang['ADDRESS']} : " . CShopInfo::$data->address . "<br/>{$lang['EMAIL']} : " . CShopInfo::$data->email . "<br/>{$lang['PHONE']}  : " . CShopInfo::$data->phoneNumber;

        if($content){
            $content = str_replace(array('{CUSTOMER_NAME}', '{SHOP_NAME}', '{BOOKING_CONTENT}'), 
                                         array($this->data->name, $shopName, $bookingDetailHtml), $content);
        }

        $content = "<table width='100%' style='margin-bottom:20px;'><tr><td style='width:100px;'>" . CShopInfo::$data->shopLogoWithLink . "</td><td syle='text-align:absmiddle;font-weight:bold;font-size:22px;'>" . CShopInfo::$data->name . "</td></tr></table>" . $content;
        
        $config['site_title'] = CShopInfo::$data->name;
        $this->email($this->data->email, $this->data->name , $title, $content);
    }
}
?>