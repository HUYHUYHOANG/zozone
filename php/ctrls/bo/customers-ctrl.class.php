<?php
defined("LPCTSTR_TOKEN") or die(":-((");

if(!class_exists('CBoCtrl')) require_once('php/ctrls/bo/base.class.php');

require_once(__DIR__.'/models/customers-model.class.php');
require_once(__DIR__.'/views/customers-view.class.php');

class CCustomersCtrl extends CBoCtrl{

    public function __construct(&$config=null, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CCustomersData($config, $shopID);
        $this->view = new CCustomersView($this->model);        
    }

    public function editCustomerData(&$error){
        $id = CRequest::postNbr('id');        
        $error = '';
        return $this->model->editCustomerData($id, $error);        
    }

    public function loadCustomers($outputFlag = 1){
        $html = $this->view->defaultView();
        if($outputFlag) echo $html;
        else return $html;
    }

    public function customerGroups(){
        $this->view->customerGroups();
    }

    public function groupData(){
        $id = CRequest::getNbr("gid");
        echo json_encode($this->model->loadGroupData($id));
    }

    public function saveGroupData(){
        $id = CRequest::getNbr('gid');
        $ret = $this->model->saveGroupData($id);        
        echo json_encode(array('result' => $ret , 'error' => ''));
    }

    public function deleteTheGroup(){
        $id = CRequest::getNbr('id');
        $ret = $this->model->deleteGroup($id);
        sleep(1);
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }

    public function csvExport(){        
        $this->downloadSendHeaders("customers" . date("YmdHis") . ".csv");
        $this->view->csvExport();
    }

    public function printableCustomersList(){
        $this->view->printableCustomersList();
    }

    private function downloadSendHeaders($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
    
        // force download  
        /*header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");*/
    
        // disposition / encoding on response body
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename={$filename}");
    }

    public function deleteTheCustomer(){
        $id = CRequest::getNbr('id');
        $ret = $this->model->deleteTheCustomer($id);        
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }

    public function addCustomerForm(){
        $this->view->addCustomerForm();
    }

    public function editCustomerForm(){
        $id = CRequest::getNbr('customer');        
        $this->view->editCustomerForm($id);
    }

    public function customerReservations(){
        $id = CRequest::getStr('customer');
        $this->view->customerReservations($id);
    }

    public function deleteCustomerReservation(){
        $id = CRequest::getNbr('id');
        $ret = $this->model->deleteCustomerReservation($id);
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }
    public function editCustomerReservation(){        
        $this->view->editCustomerReservation(CRequest::getNbr('id'));
    }
    public function changeCustomerReservationStatus(){
        $ret = $this->model->updateReservationStatus($id = CRequest::getNbr('id'));
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }

    public function findCustomers(){
        $this->model->findCustomers();
    }

    public function loadVouchers(){
        $theID = CRequest::getNbr('customer');
        $this->view->loadCustomerVouchers($theID);
    }

    public function findCustomerByEmail(){        
        $email = CCodec::decode(CRequest::getStr('email'));
        $id = 0;
        if(CRequest::validateEmail($email)){            
            $id = $this->model->findCustomerByEmail($email);
        }
        echo json_encode(array('result'=>$id, 'email' => $email));
    }

    protected function validateParam($key, $value, &$errObj){
        global $lang;
        $errObj = new stdClass();
        $errObj->error = 0;
        $errObj->field = $key;
        
        switch($key){
            case 'name':
                return mb_strlen($value);
            case 'email':
                $postID = CRequest::postNbr('id');
                $cid = $this->model->findCustomerByEmail($value);                
                //$errObj->text = sprintf('post: %d, find: %d ', $postID, $cid);
                if(($postID && $cid && $postID!=$cid) || (!$postID && $cid)){
                    $errObj->text .= $lang['EMAIL_EXISTS'];
                    return false;
                } 
                break;
        }
        return true;
    }
}

?>