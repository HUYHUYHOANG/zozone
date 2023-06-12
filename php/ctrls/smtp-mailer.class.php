<?php
require 'ctrls/PHPMailer/src/Exception.php';
require 'ctrls/PHPMailer/src/PHPMailer.php';
require 'ctrls/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

defined("LPCTSTR_TOKEN") or die(":-((");

class CSmtpMailer{
    private $tblPre;
    private $smtp;
    public function __construct($tblPre){
        global $smtpData;
        $this->tblPre = $tblPre;
        $this->smtp = (object)$smtpData;
    }

    public function s3ndC0nt2ct(){
        $token = CRequest::getStr('ptkn');        
        $sessionToken = $_SESSION['SHOP_RANDOM_TOKEN'];
        if(!isset($_GET[$sessionToken])) die;

        $rcpt = CRequest::postStr('rcpt');
        $formEmail = CRequest::postStr('dzEmail');
        $formName = CRequest::postStr('dzName');        
        $phone = CRequest::postStr('dzPhone');
        $msg = htmlentities(CRequest::postStr('dzMessage'));

        $data = array('selfName' => 'Lotus Nail Service', 'email'=>$formEmail, 'name'=>$formName, 'phone'=>$phone, 'msg'=>$msg);

        $mail = new PHPMailer(true);
        //Enable SMTP debugging.
        $mail->SMTPDebug = 0;

        
        $mail->isSMTP();        
        $mail->SMTPAuth = true;
        $mail->AuthType = 'LOGIN';                  //PLAIN, LOGIN, NTLM, CRAM-MD5, XOAUTH2
        $mail->Host = 'mail.ihoapm.com';            //$this->smtp->myhost['host'];
        $mail->Username = 'wbmaster@ihoapm.com';    //$this->smtp->myhost['uid'];
        $mail->Password = 'QwerT54321!@#$%';        //$this->smtp->myhost['hash'];
        $mail->SMTPSecure = 'ssl';                  //$this->smtp->myhost['secure'];
        $mail->Port = 465;                          //$this->smtp->myhost['port'];
        

        $mail->From = $this->smtp->myhost['uid'];
        $mail->FromName = $this->smtp->myhost['rcptName'];

        $mail->addAddress("wbmaster@ihoapm.com", "wbmaster");
        if(CRequest::validateEmail($rcpt)) $mail->AddAddress($rcpt, "wbmaster");
        $mail->addReplyTo($formEmail, $formName);

        $mail->CharSet = "UTF-8"; 
        $mail->Encoding = 'base64';

        $mail->isHTML(true);
        $mail->Subject = "Message from Lotus Nail";
        $mail->Body = $this->_contactMessageTempl($data);
        $mail->AltBody = $data['msg'];

        try {
            $mail->send();            
            echo json_encode( array("result" => "+220", "title" => ""));
        } catch (Exception $e) {            
            echo json_encode( array("result" => "-500", "error" => $mail->ErrorInfo));
        }
    }

    private function _contactMessageTempl(&$data){        
        return  '<p><strong>This is a message from ' . $data['selfName'] . ' contact form</strong></p>
                <p><strong>Name: ' . $data['name'] . ' - Phone: ' . $data['phone'] . '</p>
                <p style="background:#FAFAFA;"><i>' . $data['msg'] . '</i></p>';
    }//
}

?>