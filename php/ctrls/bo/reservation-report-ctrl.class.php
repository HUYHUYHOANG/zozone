<?php
////*********************************************************************************************************************** */
/// CONTROL
////*********************************************************************************************************************** */
class CReservationReportCtrl extends CBoCtrl{
    
    public function __construct (&$config, $shopID){
        parent::__construct($config, $shopID);
        $this->model = new CCReservationReportData($config, $shopID);
        $this->view = new CCReservationReportView($this->model);
    }

    public function loadBookingReport(){
        $this->view->runBookingReport();
    }
}

////*********************************************************************************************************************** */
// DATA
////*********************************************************************************************************************** */
class CCReservationReportData extends CBoLogicData{

    public function __construct($config, $shopID){
        parent::__construct($config, $shopID);
        $this->tableName = $this->config['db']['pre'] . 'reservations';
    }
    
    public function getReportData($showPagination = 1){        
        $searchData = 0;
        $cond = $this->_buildSqlCondition($searchData);
        $rowsPerPage = PAGINATION_ROWS_PER_PAGE; //defined at ctrls/bo/base.class.php

        $sql = "SELECT COUNT(*) AS items FROM
                (SELECT DISTINCT DATE(r.arr_time) FROM {$this->tblPre}reservations r 
                WHERE r.shop_id={$this->shopID} AND !r.deleted {$cond}) a";
        
        $items = ORM::for_table("{$this->tblPre}reservations")->rawQuery($sql)->findOne();
        $itemCount = $items['items'];        
        
        $this->data = null;
        if(!$itemCount){
            return 0;
        }
        

        $this->pager = new CPager($itemCount, $searchData['page'], $rowsPerPage, 5);
        $sql = "SELECT DISTINCT DATE(r.arr_time) AS bk_date FROM qr_reservations r 
                WHERE r.shop_id={$this->shopID} AND !r.deleted {$cond} ORDER BY bk_date ASC";        
        
        if($showPagination) $sql .= ' LIMIT ' . $this->pager->begin() . ', ' . $rowsPerPage;
        
        $this->data = ORM::for_table('')->rawQuery($sql)->findMany();        
        return count($this->data);
    }//getReportData

    private function _buildSqlCondition(&$searchData){
        $cond = '';
        $offset = CRequest::getNbr('page', -1);
        if(!$searchData){            
            $searchData = array(
                'search' => '',
                'page'   => -1
            );
        }
        
        if($offset < 0){
            //set new search data
            $from = CRequest::getStr('from');
            $to = CRequest::getStr('to');
            $staffs = CRequest::getStr('staffs');            
            if(!$from || !($from = DateTime::createFromFormat('m-d-Y', $from))){            
                $first = date('Y-m-01');
                $from = DateTime::createFromFormat('Y-m-d', $first);
            } 
            if(!$to || !($to = DateTime::createFromFormat('m-d-Y', $to))) $to = false;
            
            $searchData['from'] = $from->format('Y-m-d');
            $searchData['to'] = $to ? $to->format('Y-m-d 23:59:59') : false;
            $searchData['staffs'] = $staffs;
        }else{
            //get old search data, change the page index
            $searchData = $_SESSION['SEARCH_CUSTOMER_DATA'];
            $searchData['page'] = $offset;
        }
        
        //save
        $_SESSION['SEARCH_CUSTOMER_DATA'] = $searchData;
        $this->searchData = $searchData;

        $data = (object)$searchData;
        if($data->from) $cond = " AND r.arr_time>='{$data->from}'";
        if($data->to) $cond .= " AND r.arr_time<='{$data->to}'";
        if($data->staffs) $cond .= " AND r.staff_id IN({$data->staffs})";        
        
        return $cond;
    }

    public function &getTheStaffsList(){
        $rows = parent::getTheStaffsList();
        if(!$rows) return 0;        
        $data = array();        
        foreach($rows as $r){            
            $data[$r['id']] = array('id'=>$r['id'], 'name'=>$r['name']);
        }
        return $data;
    }

    public function getBookingNameAndTime($staffID, $arrDate){
        $sql = "SELECT service_ids, arr_time AS start_time, dep_time AS end_time FROM {$this->tblPre}reservations WHERE DATE(arr_time)='{$arrDate}' AND staff_id={$staffID} AND shop_id={$this->shopID}";
        $rows = ORM::forTable('')->rawQuery($sql)->order_by_asc('start_time')->findMany();
        if(!$rows) return null;
        $services = ""; $times = "";
        $count = count($rows); $idx = 0;
        foreach($rows as $r){
            $startTime = $r['start_time'];
            $endTime = $r['end_time'];
            $times .= "<span class='time-item'>" . sprintf("%s - %s", date('H:i', strtotime($startTime)), date('H:i', strtotime($endTime))) . "</span>";
            $services .= "<span class='services-item'>" . self::getServiceNames($r['service_ids']) . "</span>";
        }
        return array($services, $times);
    }

    public function getBookingsByDate($date){
        $cond = '';
        $data = (object)$this->searchData;
        if($data->from) $cond = " AND r.arr_time>='{$data->from}'";
        if($data->to) $cond .= " AND r.arr_time<='{$data->to}'";
        if($data->staffs) $cond .= " AND r.staff_id IN({$data->staffs})";

        $sql = "SELECT r.id, r.staff_id, u.name, r.service_ids, r.arr_time, r.dep_time FROM qr_reservations r LEFT JOIN qr_user u ON r.staff_id=u.id
            WHERE !r.deleted AND r.shop_id={$this->shopID} AND DATE(r.arr_time)='{$date}' {$cond} ORDER BY r.staff_id ASC, arr_time ASC";        
        return ORM::forTable('')->rawQuery($sql)->findMany();
    }
}//end data class

////*********************************************************************************************************************** */
// VIEW
////*********************************************************************************************************************** */
class CCReservationReportView extends CBoHtmlView{    
    public function runBookingReport(){
        global $lang;
        $items = $this->model->getReportData();
        if(!$items){
            echo '<p class="text-danger">' . $lang['RECD_NOT_FOUND'] . '</p>';
            return;
        }
        global $lang;
        include(__DIR__.DIRECTORY_SEPARATOR.'templates/report.booking.table.php');    
    }
}//view
?>