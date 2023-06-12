<?php
////*********************************************************************************************************************** */
/// CONTROL
////*********************************************************************************************************************** */
require_once(__DIR__.'/shop-options-ctrl.class.php');

class CMailListCtrl extends CBoCtrl{
    private $ggtl = 0;
    private $mailer = 0;
    
    public function __construct (&$config, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CMailListData($config, $shopID);
        $this->view = new CMailListView($this->model, $shopID);
    }

    public function loadShopMailListOption(){
        $this->view->loadShopMailListOption();
    }

    public function sendMailListNow(){
        $json = false;
        $this->view->sendMailListNow($json);        
        echo json_encode($json);
    }

    public function saveSettings(){
        $this->model->saveSettings();
    }

    public function setShopId($Id){
        $this->model->setShopId($Id);
    }

    public function setUsernameAndPwd($uid, $pwd){
        $this->view->setUsernameAndPwd($uid, $pwd);
    }
}

////*********************************************************************************************************************** */
// DATA
////*********************************************************************************************************************** */
class CMailListData extends CBoLogicData{
    public $shopData = 0;
    public function __construct($config, $shopID){
        parent::__construct($config, $shopID);
        $this->tableName = $this->config['db']['pre'].'shop_options';
        
        global $config;
        $this->shopData = ORM::forTable('qr_shop')->selectMany('name', 'address', 'email', 'phone_number')->where('status', 'active')->findOne($shopID);        
        if($this->shopData){
            $config['shop_info'] = $this->shopData;
        }else $config['shop_info'] = 0;
    }
    
    public function getCustomers($groupIds = '', $afterActivityDays = 0){
        $sql = "SELECT id, email, name, gender FROM qr_customers WHERE shop_id={$this->shopID} AND !deleted AND newsletter";
        if($groupIds) $sql .= " AND group_id IN({$groupIds}) ";
        if($afterActivityDays){
            $sql .= " AND (last_activity IS NULL OR TIMESTAMPADD(DAY, {$afterActivityDays}, last_activity) <= NOW()) ";
        }
        $sql .= " ORDER BY name ASC";        
        
        return ORM::forTable('')->rawQuery($sql)->findMany();
    }

    public function &getMessageTemplate($id){
        if(!$id) return 0;
        $sql = "SELECT title, content FROM qr_message_templates WHERE id={$id}";
        $data = ORM::forTable('')->rawQuery($sql)->findOne($id);
        if(!$data) return 0;
        return $data;
    }

    public function getSettings(){
        //settings data samples
        /*
        {"customer_setting":"last-activity","last_visit_days":"15","email_template":"3","schedule":"semi-monthly","group_ids":""}
        */  
        global $config;
        $objShopOpt = new CShopOptionsData($config, $this->shopID);        
      return json_decode($objShopOpt->getShopOtion($this->shopID, 'send_email_cron_job'));
    }

    public function saveSettings(){
        $ptkn = $_SESSION['user']['login_string'];
        if(isset($_POST[$ptkn])) unset($_POST[$ptkn]);
        
        global $config, $lang;        
        
        $json = new stdClass;
        
        $objShopOpt = new CShopOptionsData($config, $this->shopID);

        $json->error = $objShopOpt->updateShopOption($this->shopID, 'send_email_cron_job', json_encode($_POST)) ? 0 : 1;
        
        $json->message = $json->error ? $lang['ERROR'] : $lang['SUCCESSFUL'];
        $json->data = $_POST;
        echo json_encode($json);

    }

    public function setShopId($id){
        $this->shopID = $id;
    }
}//end data class


////*********************************************************************************************************************** */
// VIEW
////*********************************************************************************************************************** */
////*********************************************************************************************************************** */
////*********************************************************************************************************************** */
class CMailListView extends CBoHtmlView{    
    private $shopID = 0;
    private $settings = 0 ;
    public $mailer;

    public function __construct($model, $shopID){
        $this->shopID = $shopID;
        parent::__construct($model);
    }

    public function loadShopMailListOption(){
        global $config, $lang;
        require_once(__DIR__.'/models/customers-model.class.php');
        require_once(__DIR__.'/message-template-ctrl.class.php');
        $customerModel = new CCustomersData($config, $this->shopID);
        $customerModel->loadCustomerGroups(1);
        $msgData = new CMessageTemplateData($config, $this->shopID);
        $templates = $msgData->getAllTemplates('email', 'comeback_shop_remind');
        $activeLanguages = $this->model->getLanguages('de');
        $this->settings = $this->model->getSettings();
        
        include(__DIR__.DIRECTORY_SEPARATOR.'templates/mail-list-settings.dialog.php');        
    }  

    public function sendMailListNow(&$json){
        global $config, $lang;
        
        $json = new stdClass;
        
        $token = isset($_SESSION['user']['login_string']) ? $_SESSION['user']['login_string'] : '';
        if($token && isset($_POST[$token])) unset($_POST[$token]);

        $sendToList = CRequest::postStr('customer_setting');
        if($sendToList=='all'){
            $customers = $this->model->getCustomers();
        }elseif($sendToList=='in-group'){
            $groups = CRequest::postStr('group_ids');
            $customers = $this->model->getCustomers($groups);
        }elseif($sendToList=='last-activity'){
            $days = CRequest::postNbr('last_visit_days');
            if($days<=0) $days = 0;
            elseif($days>100) $days = 100;
            $customers = $this->model->getCustomers(0, $days);
        }
        
        if(!$customers){
            $json->error = 1; $json->message = $lang['CUSTOMER'] . ': ' . $lang['RECD_NOT_FOUND'];
            return false;
        }

        //get message template        
        $templateId = CRequest::postNbr('email_template');
        $message = $this->model->getMessageTemplate($templateId);
        if(!$message){
            $json->error = 1; $json->message = sprintf("%s %s: %s", $lang['MESSAGE'], $lang['MESSAGE'], $lang['RECD_NOT_FOUND']);
            return false;
        }

        if(!$message->title) $message->title = $config['site_title'];
        
        $this->initEmailEngine();
        $subject = html_entity_decode($message->title);
        $body = html_entity_decode($message->content);
        
        
        $idx = 1; $success = 0;
        $results = array();        
        
        if(CShopInfo::getInfo($this->shopID)){
            $fromEmail = CShopInfo::$data->email;
            $formName = CShopInfo::$data->name;
            $phoneNo = CShopInfo::$data->phoneNumber;
            $body = str_replace('{SHOP_NAME}', $formName, $body);
            
        }else{
            $fromEmail = $config['admin_email'];
            $formName = $config['site_title'];
            $body = str_replace('{SHOP_NAME}', $formName, $body);
        }        
        
        $body .= CShopInfo::emaiFooter();

        //********************************************************* */
        /* IMPORTANT : some smtp server will refuse connection when sender email is difference the username $config['smtp_username'] */
        /* if so we have to set from name the same as the username */ 
        /* $this->mailer->SetFrom($config['smtp_username'], $formName); */
        //********************************************************* */

        $this->mailer->SetFrom($config['smtp_username'], $formName);
        //$this->mailer->SetFrom($fromEmail, $formName);
        //$this->mailer->SetFrom($config['admin_email'], $name = $config['site_title']);
        $this->mailer->AddReplyTo($fromEmail, $formName);
        $idx =  0;
        foreach($customers as $r){
            $customer = (object)$r;
            $results[$idx] = array('email' => $customer->email, 'sent' => 0);            
            $emailBody = str_replace('{CUSTOMER_NAME}', $customer->name, $body);
            $sent = $this->emailCustomer($customer->email, $customer->name, $subject, $emailBody);
            $results[$idx]['sent'] = $sent;
            if($sent) ++$success;
            ++$idx;
        }
        $json->error = $success ? 0 : 1;
        $json->customers = count($customers);
        
        if(!$success){
            $json->message = $lang['SEND_EMAIL_ERROR'];
            $json->email_error = $config['email_result_message'];
            $json->sent_items = $results;
            $json->test = "ok2";
        }else{
            $json->message = $success . '  ' . $lang['N_EMAIL_SENT'];
        }
    }

    public function emailCustomer($email_to, $email_to_name, $email_subject, $email_body, $bcc=array(), $email_reply_to=null, $email_reply_to_name=null){
        global $config;
        
        if($email_reply_to != null){
            $this->mailer->AddReplyTo($email_reply_to, $email_reply_to_name);
        }

        /* Clear Mails */
        $this->mailer->clearAddresses();
        $this->mailer->clearCustomHeaders();
        $this->mailer->clearAllRecipients();
        $this->mailer->AddAddress($email_to, $email_to_name);
        $this->mailer->Subject  =  $email_subject;
        $this->mailer->Body = $email_body;

        /* Send Error */
        if(!$this->mailer->Send()){        
            $config['email_result_error'] = 1;
            $config['email_result_message'] = $this->mailer->ErrorInfo;
            return false;            
        }
        return true;
    }

    public function initEmailEngine(){
        global $config;
        $phpMailerDir = dirname(__FILE__).DIRECTORY_SEPARATOR."../../../includes/mail/phpmailer";        
        require_once("{$phpMailerDir}/class.phpmailer.php");
        require_once("{$phpMailerDir}/class.smtp.php");
        require_once("{$phpMailerDir}/PHPMailerAutoload.php");

        $this->mailer = new PHPMailer();        
        $this->mailer->Encoding = 'base64';
        $this->mailer->CharSet = "utf-8";        
        $this->mailer->IsHTML(true);
        $this->mailer->ContentType = "text/html";

        $this->initMailer($config['email_type']);
        //$this->initMailer('mail');
    }

    public function setUsernameAndPwd($uid, $pwd){
        $this->mailer->Username = $uid;
        $this->mailer->Password = $pwd;
    }

    private function initMailer($emailType){
        global $config;        
        $config['smtp_debug'] = 0;
        switch($emailType){
            case 'smtp':
                $this->mailer->IsSMTP();
                $this->mailer->Host     = $config['smtp_host'];
                $this->mailer->SMTPAuth = $config['smtp_auth'];
                $this->mailer->SMTPDebug = $config['smtp_debug'];
                $this->mailer->Debugoutput = 'html';
                $this->mailer->SMTPKeepAlive = true;
                if($config['smtp_secure']==1){# SSL
                    $this->mailer->SMTPSecure = 'ssl';
                }else if($config['smtp_secure']==2){# TLS
                    $this->mailer->SMTPSecure = 'tls';
                }
                $this->mailer->Username = $config['smtp_username'];
                $this->mailer->Password = $config['smtp_password'];
                $this->mailer->Port = $config['smtp_port'];
                $this->mailer->Priority = 1;
                break;
            case 'mail':
                $this->mailer->Debugoutput = 'html';
                $this->mailer->Priority = 1;
                break;
        }
    }
}//view
?>