<?php
defined("LPCTSTR_TOKEN") or die(":-((");

if(!class_exists('CBoCtrl')) require_once('php/ctrls/bo/base.class.php');

require_once('models/staffs-model.class.php');
require_once('views/staffs-view.class.php');

class CStaffsCtrl extends CBoCtrl{

    public function __construct(&$config=null, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CStaffsData($config, $shopID);
        $this->view = new CStaffsView($this->model);        
    }

    protected function validateParam($key, $value, &$errObj){
        global $lang;
        $errObj = new stdClass();
        $errObj->error = 0;
        $errObj->field = $key;

        /*echo "\r\n";
        echo "{$key} : {$value}";*/
        switch($key){
            case 'name':
                return mb_strlen($value);            
            case 'email':
                if(CRequest::validateEmail($value)){                    
                    if($id = $this->model->findStaffByEmail($value)){
                        if($id != $_POST['id']){
                            $errObj->text = $lang['EMAIL_EXISTS'];
                            return false;
                        }
                    }
                    return true;
                }else $errObj->text = $lang['EMAILINV'];
                return false;
            case 'username':                
                $reg = '/^[a-z\d]\w{2,23}[^_]$/i';
                if(!preg_match($reg, $value)){
                    $errObj->text = $lang['USERLEN']; return false;
                }else{
                    if($id = $this->model->findStaffByUid($value)){
                        if($id != $_POST['id']){
                            $errObj->text = $lang['USERUNAV'];
                            return false;
                        }
                    }
                }
                break;
            case 'secret':
                $id = CRequest::postNbr('id');
                if($id>0 && empty($value)) break; //edit staff and let pwd blank
                $pwd = CCodec::decode($value);
                $upc = preg_match('@[A-Z]@', $pwd);
                $lwc = preg_match('@[a-z]@', $pwd);
                $nbr    = preg_match('@[0-9]@', $pwd);
                $len = strlen($pwd);                
                if(!$upc || !$lwc || !$nbr || $len<6 || $len>20){
                    $errObj->text = $lang['PLEASE_ENTER_A_PASSWORD_WITH_A_LENGTH_OF_8_20_CHARACTERS'];                    
                    return false;
                }
                break;
            /*case 'spec_ids':
                return strlen($value)?true:false;*/
            default:
                if(!empty($value)){
                    $_POST[$key] = CRequest::stripTags($value);
                }
                break;
        }
        return true;
    }

    public function findStaffByEmail(){
        $email = CCodec::decode(CRequest::getStr('email'));
        if($email && CRequest::validateEmail($email)){
            $id = $this->model->findStaffByEmail($email);
            echo json_encode(array('result'=>$id, 'error'=>'', 'email' => $email));
        }else{
            echo json_encode(array('result'=>-1, 'error'=> "Invalid email:{$email}"));
        }
    }
    
    public function findStaffByUid(){
        $uid = CRequest::getStr('uid');
        $uid = CCodec::decode(CRequest::getStr('uid'));
        if($uid){
            $id = $this->model->findStaffByUid($uid);
            echo json_encode(array('result'=>$id, 'error'=>'', 'uid' => $uid));
        }else{
            echo json_encode(array('result'=>-1, 'error'=> ''));
        }
    }

    public function loadStaffs($outputFlag = 1){
        $html = $this->view->defaultView();
        if($outputFlag) echo $html;
        else return $html;
    }

    public function staffGroups(){
        $this->view->staffGroups();
    }

    public function groupData(){
        $id = CRequest::getNbr("gid");
        echo json_encode($this->model->loadGroupData($id));
    }

    public function saveGroupData(){
        $id = CRequest::getNbr('gid');
        $ret = $this->model->saveGroupData($id);        
        echo json_encode(array('result' => $ret ? 1 : 0, 'error' => ''));
    }

    public function deleteTheGroup(){
        $id = CRequest::getNbr('id');
        $ret = $this->model->deleteGroup($id);        
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }

    public function deleteTheStaff(){
        $id = CRequest::getNbr('id');
        $ret = $this->model->deleteTheStaff($id);        
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }

    public function addStaffForm(){
        $this->view->addStaffForm();
    }

    public function editStaffForm(){
        $id = CRequest::getNbr('staff');        
        $this->view->editStaffForm($id);
    }

    public function staffReservations(){
        $id = CRequest::getStr('staff');
        $this->view->staffReservations($id);
    }

    public function deleteStaffReservation(){
        $id = CRequest::getNbr('id');
        $ret = $this->model->deleteStaffReservation($id);
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }
    public function editStaffReservation(){        
        $this->view->editStaffReservation(CRequest::getNbr('id'));
    }
    public function changeStaffReservationStatus(){
        $ret = $this->model->updateReservationStatus($id = CRequest::getNbr('id'));        
        echo json_encode(array('ret' => $ret , 'id'=>$id, 'error' => ''));
    }

    public function findStaffs(){
        $this->model->findStaffs();
    }
}

?>