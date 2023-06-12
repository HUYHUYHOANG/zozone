<?php
defined("LPCTSTR_TOKEN") or die(":-((");

if(!class_exists('CBoCtrl')) require_once('php/ctrls/bo/base.class.php');

require_once('models/vouchers-model.class.php');
require_once('views/vouchers-view.class.php');

class CVouchersCtrl extends CBoCtrl{
    private $lang;
    public function __construct(&$config=null, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CVouchersData($config, $shopID);
        $this->view = new CVouchersView($this->model);

        global $lang;
        $this->lang = &$lang;
    }

    public function loadVouchers(){
        $this->view->loadVouchers();
    }
    
    public function loadVoucher(){        
        $this->view->loadVoucher(CRequest::getNbr('id'));
    }

    public function deleteTheVoucher(){
        echo json_encode(array('result' => $this->model->deleteVoucher($id = CRequest::getNbr('id')), 'id' =>$id));
    }

    public function addVouchersDialog(){
        $this->view->addVouchersDialog();
    }

    public function generateQRCode(){
        require_once('../phpqrcode/qrlib.php');        
        $code = CRequest::getStr('code');
        $html = "";
        if($code && ($code=CCodec::decode($code))){
            header("Content-type:image/png");
            QRcode::png($code); return;
        }
    }

    public function downloadPDFWithQRCode(){
        $downloadPDF = CRequest::getStr('download');        
        $this->view->downloadPDFWithQRCode($downloadPDF=="true");
    }

    public function handlePostAction($action, &$redirect, &$err){
        $ajax = CRequest::getStr("ajax");
        if($ajax!=="true" || empty($_POST) || !CBoCtrl::checkSessionKey()){
            $redirect = 1;
            return false;
        }
        
        $continue = $this->validateParamArray($_POST, $err);
        $id = 0;        
        if(!$continue){
            $err->error = 1;
        }else{
            $action = str_replace('-', '', $action);
            if(!method_exists($this->model, $action)){
                $err->error = 1;
                $err->field = '';
                return false;
            }

            $id = $this->model->{$action}($err);
            $err->error = $id ? 0 : 1;
            $err->field = '';
            $err->id = $id;
        }
        return !$err->error;
    }

    protected function validateParam($key, $value, &$errObj){        
        $errObj = new stdClass();
        $errObj->error = 0;
        $errObj->field = $key;
        $errObj->text = '';
        switch($key){
            case 'value':
                if(!is_numeric($value)){
                    $errObj->text = $this->lang['INVALID_DATA'];
                    return false;
                }
                break;
            case 'issued_date':
            case 'expired_date':
                $date = DateTime::createFromFormat('m-d-Y', $value);
                return $date;
        }
        return true;
    }

    public function validateParamArray($adata, &$err){
        if(!parent::validateParamArray($adata, $err)){
            return false;
        }

        $continue = 1;
        if(isset($adata['issued_date']) && isset($adata['expired_date'])){
            $issued_date = DateTime::createFromFormat('m-d-Y', CRequest::postStr('issued_date'));
            $expired_date = DateTime::createFromFormat('m-d-Y', CRequest::postStr('expired_date'));                
            $now = new DateTime();                
            if($expired_date<=$issued_date || $expired_date<=$now){
                $err->error = 1;
                $err->field = 'expired_date';
                $err->text = $this->lang['ERROR_DATE'];
                //sprintf('Expired date (%s) must be later Issued date (%s)', $expired_date->format('m-d-Y'), $issued_date->format('m-d-Y'));                    
                return false;
            }
        }
        
        $value = CRequest::postNbr('value');
        $sale_type = CRequest::postStr('sale_type');
        if($sale_type=='%' && $value>=100){            
            $err->error = 1;
            $err->field = 'value';
            $err->text = $this->lang['INVALID_DATA'];
            return false;
        }

        $custID = CRequest::postNbr('cust_id');
        if($custID>0){
            $value = CRequest::postNbr('value');
            if($value<=0){
                $err->error = 1;
                $err->field = 'value';
                $err->text = $this->lang['INVALID_DATA'];
                return false;
            }
        }
        return true;
    }
}
?>