<?php
defined("LPCTSTR_TOKEN") or die(":-((");
////*********************************************************************************************************************** */
/// DATA
////*********************************************************************************************************************** */
class CCustomersData extends CBoLogicData{
    public $items = 0;
    public $groups = 0;

    public function __construct(&$config, $shopID){        
        parent::__construct($config, $shopID);
        $this->tableName = 'qr_customers';
    }

    public function loadCustomer($id){
        $this->data = ORM::for_table($this->config['db']['pre'] . 'customers')->find_one($id);
        //save customer info in session
        if($this->data){            
            $_SESSION['__CUSTOMER_INFO__'] = $this->data;
            return 1;
        }else $_SESSION['__CUSTOMER_INFO__'] = array('id'=>0,'name'=>'');        
        return 0;
    }

    public function loadCustomers($searchData = 0){
        $itemCount = 0;
        $rowsPerPage = PAGINATION_ROWS_PER_PAGE; //defined at ctrls/bo/base.class.php

        $cond = $this->_buildSqlCondition($searchData);
        $sqlCount = 'SELECT COUNT(*) AS items FROM qr_customers c WHERE c.deleted=0 AND c.shop_id='.$this->shopID.$cond;
        $rows = ORM::for_table($this->config['db']['pre'] . 'customers')->raw_query($sqlCount)->find_one();
        if($rows) $itemCount = $rows['items'];

        $this->pager = new CPager($itemCount, $searchData['page'], $rowsPerPage, 5);

        $sql = 'SELECT c.id, c.name, c.phone, c.email, c.city, c.last_activity, c.newsletter, g.name AS group_name, g.disc_perct, g.description FROM qr_customers c 
                LEFT JOIN qr_cust_groups g ON c.group_id=g.id AND c.shop_id=g.shop_id WHERE c.deleted=0 AND c.shop_id='.$this->shopID . $cond . ' ORDER BY c.name ASC LIMIT ' . $this->pager->begin() . ', ' . $rowsPerPage;
        
        $this->data = ORM::for_table($this->config['db']['pre'] . 'customers')->raw_query($sql)->find_many();
        $this->items = $itemCount;
    }    

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
            $searchData['search'] = CRequest::getStr('customer');
            $searchData['done'] = CRequest::getNbr('done');
        }else{
            //get old search data, change the page index
            $searchData = $_SESSION['SEARCH_CUSTOMER_DATA'];
            $searchData['page'] = $offset;
        }
        
        //save
        $_SESSION['SEARCH_CUSTOMER_DATA'] = $searchData;
        $this->searchData = $searchData;

        $data = (object)$searchData;
        if($data->search){
            $text = $data->search;
            $s = sprintf(' AND ( c.name LIKE "#%s#" OR c.phone LIKE "#%s#" OR c.email LIKE "#%s#" )', $text, $text, $text);
            $cond .= str_replace('#', '%', $s);
        }        
        
        return $cond;
    }

    public function loadCustomerGroups($onlyActive = 0){
        $sql = 'SELECT g.*, COUNT(c.id) AS customers FROM qr_cust_groups g LEFT JOIN qr_customers c ON g.id=c.group_id AND c.shop_id=g.shop_id 
                WHERE g.deleted=0 AND g.shop_id=' . $this->shopID . ($onlyActive ? ' AND active ' : '') . ' GROUP BY g.id ORDER BY g.position ASC';        
        $this->groups = ORM::for_table('qr_cust_groups')->raw_query($sql)->find_many();
    }

    public function loadGroupData($id){
        $this->data = ORM::for_table('qr_cust_groups')->find_one($id);
        if($this->data){
            $r = array('id' => $this->data['id'], 'name' => $this->data['name'], 'disc_perct' => $this->data['disc_perct'],
                       'position' => $this->data['position'], 'active' => $this->data['active'], 
                       'removable' => $this->data['removable'], 'description' => $this->data['description']);
            return $r;
        }
        return array('id' => 0);
    }

    public function saveGroupData($id){
        $name = CRequest::getStr('name');
        $disc_perct = CRequest::getNbr('disc_perct');
        $position = CRequest::getNbr('position');        
        $active = CRequest::getNbr('active');
        $description = CRequest::getStr('description');

        $pdo = ORM::get_db();
        $data = [
            'id' => $id,
            'shop_id' => $this->shopID,
            'name' => $name,
            'disc_perct' => $disc_perct,
            'position' => $position,
            'description' => $description,
            'active' => $active
        ];

        if($id>0){
            $sql = 'UPDATE qr_cust_groups SET name=:name, disc_perct=:disc_perct, position=:position, description=:description, active=:active WHERE id=:id AND shop_id=:shop_id';
            return $pdo->prepare($sql)->execute($data);
        }
        unset($data['id']);
        $data['removable'] = 1;
        $sql = 'INSERT INTO qr_cust_groups(shop_id, name, disc_perct, position, description, removable, active) 
                VALUES(:shop_id, :name, :disc_perct, :position, :description, :removable, :active)';
        $ret = $pdo->prepare($sql)->execute($data);
        if($ret){
            $ret = $pdo->lastInsertId();
        }
        return $ret;
    }

    public function deleteGroup($id){
        $r = ORM::for_table('qr_cust_groups')->find_one($id);
        $r->set('deleted', 1);
        return $r->save();
    }

    public function deleteTheCustomer($id){
        $r = ORM::for_table('qr_customers')->find_one($id);
        //$r->set('deleted', 1);
        $r->delete();
        return $r->save();
    }

    public function dataForCSV(){
        $sql = 'SELECT c.id, c.name, c.phone, c.email, c.address, c.city, c.last_activity, g.name AS group_name, g.disc_perct, g.description FROM qr_customers c 
                LEFT JOIN qr_cust_groups g ON c.group_id=g.id AND c.shop_id=g.shop_id 
                WHERE !c.deleted AND c.shop_id='.$this->shopID. ' ORDER BY c.name ASC';
        $this->data = ORM::for_table('qr_customers')->raw_query($sql)->find_many();        
    }

    public function editCustomerData($id, &$errText=null){
        unset($_POST[$_SESSION['user']['login_string']]);        
        $_POST['shop_id'] = $this->shopID;


         $data = $_POST;
        // var_dump($data);
        // die();
        $data['newsletter'] = 0;
        if(isset($_POST['send_newsletter'])){
            $data['newsletter'] = 1;
            unset($data['send_newsletter']);
        } 

        try{
            $dob = DateTime::createFromFormat('m-d-Y', $data['dob']);
            if($dob){
                $dob = $dob->format('Y-m-d');
                $data['dob'] = $dob;                
            }else{                
                $data['dob'] = null;
            }
        }catch(Exception $e){
            $data['dob'] = null;
        }        
        
        $sql = $this->prepareSQL($data, $id > 0 ? 'update' : 'insert');
        $pdo = ORM::get_db();
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $stmt = $pdo->prepare($sql);        
        unset($data['id']);
        if($ret = $stmt->execute($data)){
            if($id <= 0) $id = $pdo->lastInsertId();
        }else{            
            $errText = ($stmt->errorInfo())[0];
        }
        
        return $ret ? $id : 0;
    }

    public function loadCustomerVouchers($customerID){
        $this->data = ORM::forTable($this->tblPre.'vouchers')->where('cust_id', $customerID)->order_by_desc('expired_date')->findMany();
        return count($this->data);
    }

    public function loadCustomerReservations($id, $type = 'new'){
        $now = date('Y-m-d H:i:s');
        $cond = '';
        if($type=='new') $cond = "AND r.arr_time >= '{$now}'";
        else  $cond = "AND r.arr_time < '{$now}'";
        $sql = "SELECT r.id, r.service_ids, r.arr_time, r.dep_time, r.status, r.duration, u.name AS staff, s.name AS service 
                FROM qr_reservations r LEFT JOIN qr_user u ON u.id=r.staff_id AND u.shop_id=r.shop_id 
                LEFT JOIN qr_menu s ON s.id IN (r.service_ids) AND s.shop_id=r.shop_id
                WHERE r.status<5 AND r.shop_id={$this->shopID} AND r.client_id={$id} {$cond} ORDER BY r.arr_time ASC";        
        
        $this->data = ORM::for_table($this->tableName)->raw_query($sql)->find_many();
        return count($this->data);
    }

    public function loadCustomerReservation($id){        
        $sql = "SELECT r.id, r.client_id, r.service_ids, r.arr_time, r.dep_time, r.status, r.duration, u.name AS staff, s.name AS service 
                FROM qr_reservations r LEFT JOIN qr_user u ON u.id=r.staff_id AND u.shop_id=r.shop_id 
                LEFT JOIN qr_menu s ON s.id IN (r.service_ids) AND s.shop_id=r.shop_id 
                WHERE r.shop_id={$this->shopID} AND r.id={$id}";

        $this->data = ORM::for_table('qr_reservations')->raw_query($sql)->find_one();
        return !empty($this->data);
    }

    public function deleteCustomerReservation($id){
        $record = ORM::for_table('qr_reservations')->find_one($id);
        if($record){
            return $record->delete() ? 1 : 0;
            //$record->set('status', 6);
            //return $record->save() ? $id : 0;
        }
        return 0;
    }

    public function updateReservationStatus($id){
        $state = CRequest::getNbr('state'); 
        if($state<0 || $state>5) $state = 0;
        $sql = "UPDATE {$this->config['db']['pre']}reservations SET status={$state} WHERE id={$id} AND shop_id={$this->shopID}";
        return ORM::get_db()->prepare($sql)->execute() ? $id : 0;
    }

    public function findCustomers(){
        $qry = CRequest::getStr('qry');
        if($qry=='*')
            $rows = ORM::for_table($this->tableName)->select_many('id','name')->where('shop_id', $this->shopID)->order_by_asc('name')->limit(10)->offset(0)->find_many();
        else{
            if(strchr($qry, '*')) $qry = str_replace('*', '%', $qry);
            else $qry = '%'.$qry.'%';   
            $rows = ORM::for_table($this->tableName)->select_many('id','name')->where('shop_id', $this->shopID)->where_like('name', $qry)->order_by_asc('name')->find_many();
        }
        
        if($rows){
        $data = array();
        foreach($rows as $r){
            $data[] = array('id' => $r['id'], 'text' => $r['name']);
        }
        echo json_encode(array("results"=>$data));        
        return 1;
        }
        echo json_encode(array("results"=>null));
    }

    public function findCustomerByEmail($email){        
        $data = null;
        if($email){
            $data = ORM::for_table($this->tableName)->select('id')->where('email', $email)->where('shop_id',$this->shopID)->find_one();
        }
        return $data && isset($data['id']) ? $data['id'] : 0;
    }

    private function _formatResult($text, $qry){
        $replace = "<span class='text-success'>{$qry}</span>";
        return str_ireplace($qry, $replace, $text);
    }
}//DATA class
?>