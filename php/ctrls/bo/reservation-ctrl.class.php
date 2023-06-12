<?php
defined("LPCTSTR_TOKEN") or die(":-((");

//define("BOOKING_STATUS_PENDING", 0);

define("BOOKING_STATUS_CONFIRMED", 0);
//define("BOOKING_STATUS_NOT_COME", 3);
//define("BOOKING_STATUS_IN_SERVICE", 4);
define("BOOKING_STATUS_DONE", 1);
define("BOOKING_STATUS_CANCELLED", 2);
//define("BOOKING_STATUS_DELETED", 6);

if(!class_exists('CBoCtrl')) require_once('php/ctrls/bo/base.class.php');

require_once('models/reservation-model.class.php');
require_once('views/reservation-view.class.php');

class CReservationCtrl extends CBoCtrl{

    public function __construct(&$config=null, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CReservationData($config, $shopID);
        $this->view = new CReservationView($this->model);
    }

    public static function getStatuses($selected = 0){
        $a = array(); $str = "";
        for($i = BOOKING_STATUS_CONFIRMED; $i<=BOOKING_STATUS_CANCELLED; ++$i){
            $arr = 0;
            CReservationView::_statusStyle($i, $arr);
            $label = $arr['text'];
            $class = $arr['color'];        
            $sSelected = $selected==$i ? 'selected' : '';
            $str .= "<option value='{$i}' {$sSelected} data-content=\"<div class='btn btn-sm btn-{$class}'>{$label}</div>\">$label</option>";
        }        
        return $str;
    }

    public function searchReservation($outputFlag = 1){
        $html = $this->view->defaultView();
        if($outputFlag) echo $html;
        else return $html;
    }

    public function bookingSettingsDialog(){
        $this->view->bookingSettingsDialog();
    }
    public function saveBookingSettings(){
        sleep(1);
        $this->model->saveBookingSettings();
    }

    public function editBookingDialog(){
        $this->view->editBookingDialog();
    }

    public function addNewBooking(){
        $this->view->addBookingDialog();
    }

    public function changeBookingRecordStatus(){
        $status = CRequest::getNbr('status');
        $ret = $this->model->changeBookingRecordStatus(CRequest::getNbr('id'), $status);
        echo json_encode(array('result' => $ret, 'color' => CReservationView::statusColor($status)));
    }
    public function deleteBookingRecord(){
        $id = 0;
        $ret = $this->model->deleteBookingRecord($id = CRequest::getNbr('id'));
        echo json_encode(array('result' => $ret));
    }

    public function getAllServices2JSON(){
        $this->model->getAllServices2JSON();        
    }

    public function getOpenCloseHours(){
        return $this->model->getOpenCloseHours();
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
        global $lang;
        $errObj = new stdClass();
        $errObj->error = 0;
        $errObj->field = $key;
        $errObj->text = '';
        switch($key){
            case 'service-ids':
                $re = '/^\d+(?:,\d+)*$/';
                if(!preg_match($re, $value)){
                    $errObj->text = $lang['INVALID_DATA'];
                    return false;
                }
                break;
            case 'service_amount':
            case 'duration':                
                $value = intval($value);                
                if(!is_numeric($value)){                    
                    return false;
                }
                break;
            case 'client_id':
            //case 'staff_id':
                if($value<=0 || !is_numeric($value)){
                    $errObj->text = $lang['FIELD_REQ'];
                    return false;
                }
                break;
            case 'arr_time':            
                $date = DateTime::createFromFormat('m-d-Y H:i', $value);
                if(!$date){
                    $errObj->text = $lang['ERROR_DATE'];
                }

                //check service time if not in open and close hour
                $query = '';
                $ret = $this->model->checkServiceTimeInBussinessHours($date->format('Y-m-d H:i'), $query);
                if(!$ret){
                    $errObj->text = sprintf($lang['TIME_MUST_IN_OPEN_CLOSE_RANGE'], $value);//'Time must be in open and close hour...';
                    $errObj->field = 'start_time';                    
                    return 0;
                }
                /*
                //KHONG KIEM TRA GIO KET THUC - CHI KIEM TRA GIO BAT DAU
                $duration = CRequest::postNbr('duration');
                $date->add(new DateInterval('PT' . $duration . 'M'))->format('Y-m-d H:i');
                $ret = $this->model->checkServiceTimeInBussinessHours($date->format('Y-m-d H:i'), $query);
                if(!$ret){
                    $errObj->text = sprintf($lang['TIME_MUST_IN_OPEN_CLOSE_RANGE'], $date->format('Y-m-d H:i'));//'Time must be in open and close hour...';
                    $errObj->field = 'start_time';                    
                    return 0;
                }*/
                break;
        }
        return true;
    }

    public function updateBookingTime(){
        $this->model->updateBookingTime();
    }
}

?>