<?php

defined("LPCTSTR_TOKEN") or die(":-((");

class CSendContactMsg{    
    public function __construct($tblPre){
        global $smtpData;
        $this->tblPre = $tblPre;
        $this->smtp = (object)$smtpData;
    }

    public function s3ndC0nt2ct(){
        $shopID = CRequest::postNbr("shop-id");
        $json = new stdClass;
        $json->errorMsg = "";
        $json->error = 0;
        $json->result = "+220";

        if($shopID<=0 || !CShopInfo::getInfo($shopID)){
            $json->error = 1; $json->result = "-500";
            $json->errorMsg = "Invalid param: ShopID [{$shopID}]...";
        }else{
            $rcpt = CRequest::postStr('rcpt');
            $formEmail = CRequest::postStr('dzEmail');
            $formName = CRequest::postStr('dzName');        
            $phone = CRequest::postStr('dzPhone');
            $msg = htmlentities(CRequest::postStr('dzMessage'));
            
            $contact = new stdClass;
            $contact->name = $formName;
            $contact->email = $formEmail;
            $contact->phone = $phone;
            $contact->msg = $msg;

            global $config, $lang;
            $shopInfo = CShopInfo::$data;
            $subject = $lang['CONTACT_INFORMATION'];
            $body = $this->contactMessageTempl($contact, $shopInfo) . CShopInfo::emaiFooter();

            include("ctrls/bo/base.class.php");
            include("ctrls/bo/mail-list-ctrl.class.php");
            $ctrl = new CMailListCtrl($config, $shopID);
            $ctrl->view->initEmailEngine();
            $ctrl->view->mailer->SetFrom($config['smtp_username'], $contact->name);

            if(!$ctrl->view->emailCustomer($shopInfo->email, $shopInfo->name, $subject, $body, null, $formEmail, $formName)){
                $json->errorMsg = $config['email_result_message'];
                $json->error = 1;
                $json->result = "-500";
            }
        }
        echo json_encode($json);
    }

    private function contactMessageTempl(&$data, &$shopInfo){
        global $lang;
        return  "<p syle='line-height:32px;'>{$lang['NAME']}: " . $data->name . " <br/>{$lang['PHONE']}: " . $data->phone . "<br/>Email: {$data->email}</p>
                <p style='background:#FAFAFA;padding:15px;border:1px dotted #EEE;line-height:32px;'><i>" . $data->msg . "</i></p>";
    }
}

?>