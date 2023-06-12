<?php
defined("LPCTSTR_TOKEN") or die(":-((");
////*********************************************************************************************************************** */
/// DATA
////*********************************************************************************************************************** */
class CStaffsData extends CBoLogicData{
    public $items = 0;
    public $groups = 0;
    public $serviceGroups = 0;

    public function __construct(&$config, $shopID){        
        parent::__construct($config, $shopID);
        $this->tableName = $config['db']['pre'].'user';
    }

    public function findStaffByEmail($email){
        $data = ORM::for_table($this->tableName)->select('id')->where('email', $email)->find_one();
        return $data && isset($data['id']) ? $data['id'] : 0;
    }

    public function findStaffByUid($uid){
        $data = ORM::for_table($this->tableName)->select('id')->where('username', $uid)->find_one();
        return $data && isset($data['id']) ? $data['id'] : 0;
    }

    public function loadStaff($id){
        $this->data = ORM::for_table($this->tableName)->find_one($id);
        //save staff info in session
        if($this->data){            
            $_SESSION['__STAFF_INFO__'] = $this->data;
            return 1;
        }else $_SESSION['__STAFF_INFO__'] = array('id'=>0,'name'=>'');        
        return 0;
    }

    public function loadStaffs($searchData = 0){
        $itemCount = 0;
        $rowsPerPage = PAGINATION_ROWS_PER_PAGE; //defined at ctrls/bo/base.class.php

        $cond = $this->_buildSqlCondition($searchData);
        $sqlCount = 'SELECT COUNT(*) AS items FROM ' . $this->config['db']['pre'] . 'user c WHERE c.deleted=0 AND c.shop_id='.$this->shopID.$cond;        
        $rows = ORM::for_table('qr_user')->raw_query($sqlCount)->find_one();
        if($rows) $itemCount = $rows['items'];
        
        $this->pager = new CPager($itemCount, $searchData['page'], $rowsPerPage, 5);

        $sql = 'SELECT c.id, c.name, c.phone, c.email, c.city, c.lastactive, c.username, c.user_type, c.spec_ids, g.group_name FROM ' . $this->config['db']['pre'] . 'user c 
                LEFT JOIN ' . $this->config['db']['pre'] . 'usergroups g ON c.group_id=g.group_id AND c.shop_id=g.shop_id 
                WHERE c.deleted=0 AND c.shop_id='.$this->shopID . $cond . ' ORDER BY c.name ASC LIMIT ' . $this->pager->begin() . ', ' . $rowsPerPage;
        
        $this->data = ORM::for_table('qr_user')->raw_query($sql)->find_many();
        $this->items = count($this->data);
        
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
            $searchData['search'] = CRequest::getStr('staff');
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

    public function findStaffs(){
        $this->loadStaffs();
        $data = array();
        if($this->data){
            foreach($this->data as $item){
                $data[] = array('id' => $item['id'], 'text' => $item['name']);
            }
        }
        echo json_encode(array('results' => $data));
    }

    public function loadServiceGroups(){        
        $this->serviceGroups = ORM::for_table($this->config['db']['pre'] . 'catagory_main')
                                ->select_many('cat_id', 'cat_name')
                                ->where('shop_id', $this->shopID)->order_by_asc('cat_order')->find_many();
    }

    public function loadStaffGroups(){
        $sql = 'SELECT g.*, COUNT(c.id) AS staffs FROM ' . $this->config['db']['pre'] . 'usergroups g LEFT JOIN ' . $this->config['db']['pre'] . 'user c ON g.group_id=c.group_id AND c.shop_id=g.shop_id 
                WHERE g.is_staff_group=1 AND g.deleted=0 AND g.shop_id=' . $this->shopID . ' GROUP BY g.group_id ORDER BY g.position ASC';
        $this->groups = ORM::for_table($this->config['db']['pre'] . 'usergroups')->raw_query($sql)->find_many();
    }

    public function loadGroupData($id){
        $this->data = ORM::for_table($this->config['db']['pre'] . 'usergroups')->where('group_id', $id)->find_one();        
        if($this->data){            
            $r = array('id' => $this->data['group_id'], 'name' => $this->data['group_name'], 'commission' => $this->data['commission'],
                       'position' => $this->data['position'], 'active' => $this->data['active'], 
                       'removable' => $this->data['group_removable']);
            $r['name'] = html_entity_decode($r['name']);
            return $r;
        }
        return array('id' => $id);
    }

    public function saveGroupData($id){
        $name = CRequest::getStr('name');
        $commission = CRequest::getNbr('commission');
        $position = CRequest::getNbr('position');        
        $active = CRequest::getNbr('active');        

        $pdo = ORM::get_db();
        $data = [
            'id' => $id,
            'shop_id' => $this->shopID,
            'name' => $name,
            'commission' => $commission,
            'position' => $position,
            'active' => $active
        ];

        if($id>0){
            $sql = 'UPDATE ' . $this->config['db']['pre'] . 'usergroups SET group_name=:name, commission=:commission, position=:position, active=:active WHERE group_id=:id AND shop_id=:shop_id';
            return $pdo->prepare($sql)->execute($data);
        }
        unset($data['id']);
        $data['removable'] = 1;
        $data['is_staff_group'] = 1;

        $sql = 'INSERT INTO ' . $this->config['db']['pre'] . 'usergroups(shop_id, group_name, commission, position, group_removable, is_staff_group, active) 
                VALUES(:shop_id, :name, :commission, :position,  :removable, :is_staff_group, :active)';
        $ret = $pdo->prepare($sql)->execute($data);
        if($ret){
            $ret = $pdo->lastInsertId();
        }
        return $ret;
    }

    public function deleteGroup($id){
        $r = ORM::get_db()->prepare("UPDATE {$this->config['db']['pre']}usergroups SET deleted=1 WHERE group_id=$id")->execute();
        return $r ? 1 : 0;
    }

    public function deleteTheStaff($id){
        $r = ORM::for_table($this->config['db']['pre'] . 'user')->find_one($id);
        $r->set('deleted', 1);
        return $r->save();
    }

    public function loadStaffReservations($id, $type = 'new'){
        $now = date('Y-m-d H:i:s');
        $cond = '';
        if($type=='new') $cond = "AND r.arr_time >= '{$now}'";
        else  $cond = "AND r.dep_time <= '{$now}'";
        
        $sql = "SELECT r.id, r.service_ids, r.arr_time, r.dep_time, r.status, r.duration, c.name AS customer, s.name AS service FROM " 
              . $this->config['db']['pre'] . "reservations r LEFT JOIN " . $this->config['db']['pre'] . "customers c ON c.id=r.client_id AND c.shop_id=r.shop_id 
                LEFT JOIN " . $this->config['db']['pre'] . "menu s ON s.id IN (r.service_ids) AND s.shop_id=r.shop_id
                WHERE !r.deleted AND r.shop_id={$this->shopID} AND r.staff_id={$id} {$cond} ORDER BY r.arr_time ASC";        
                        
        $this->data = ORM::for_table($this->tableName)->raw_query($sql)->find_many();
        return count($this->data);
    }

    public function loadStaffReservation($id){        
        $sql = "SELECT r.id, r.client_id, r.service_ids, r.arr_time, r.dep_time, r.status, r.duration, c.name AS customer, c.phone, c.email, s.name AS service 
                FROM " . $this->config['db']['pre'] . "reservations r LEFT JOIN " . $this->config['db']['pre'] . "customers c ON c.id=r.client_id AND c.shop_id=r.shop_id 
                LEFT JOIN " . $this->config['db']['pre'] . "menu s ON s.id IN (r.service_ids) AND s.shop_id=r.shop_id 
                WHERE r.shop_id={$this->shopID} AND r.id={$id}";
        
        $this->data = ORM::for_table($this->config['db']['pre'] . 'reservations')->raw_query($sql)->find_one();
        return !empty($this->data);
    }

    public function deleteStaffReservation($id){
        return $this->updateReservationStatus($id, 6);
    }

    public function updateReservationStatus($id, $state=-1){
        if($state==-1) $state = CRequest::getNbr('state'); 
        $sql = "UPDATE {$this->config['db']['pre']}reservations SET status={$state} WHERE id={$id}";
        $ret = ORM::get_db()->prepare($sql)->execute();
        return $ret ? 1 : 0;
    }

    public function saveStaff(&$errText){        
        $pwd = $_POST['secret'];
        unset($_POST['secret']);
        unset($_POST[$_SESSION['user']['login_string']]);

        $id = CRequest::postNbr('id');        
        if($id<=0){
            $_POST['created_at'] = date('Y-m-d H:i:s');
            $_POST['updated_at'] = $_POST['created_at'];            
        }else{
            $_POST['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $data = &$_POST;
        $data['shop_id'] = $this->shopID;
        $data['spec_ids'] = CRequest::postStr('spec_ids');
        $data['status'] = 1;
        
        $sql = $this->prepareSQL($data, $id > 0 ? 'update' : 'insert');
        $pdo = ORM::get_db();
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        
        unset($_POST['id']);
        $stmt = $pdo->prepare($sql);

        if($ret = $stmt->execute($data)){
            if($id <= 0) $id = $pdo->lastInsertId();
        }else $errText = $stmt->errorInfo();

        if($id && $pwd){
            $pwd = CCodec::decode($pwd);
            $pwd_hash = password_hash($pwd, PASSWORD_DEFAULT);
            $user = ORM::for_table($this->config['db']['pre'].'user')->find_one($id);
            $user->set('password_hash', $pwd_hash);
            $user->save();
        }
        if($ret && $id){
            $user = $_SESSION['user'];
            if($user['id']==$id){
                $user['name'] = $data['name'];
                $_SESSION['user'] = $user;
            }

            $this->uploadImage($id, $errText);
        }
        return $ret ? $id : 0;
    }

    private function uploadImage($id, &$errText){
        if(!isset($_FILES['staff_image'])) return;
        $file = $_FILES['staff_image'];
        $filename = $file['name'];
        if(!is_uploaded_file($file['tmp_name'])) return;
        
        global $lang;        
        
        $mime_type = mime_content_type($file['tmp_name']);    
        $allowed_file_types = ['image/png', 'image/jpeg'];
        if(!in_array($mime_type, $allowed_file_types)) {
            $errText = $lang['ONLY_JPG_ALLOW']; return;
        }
    
        // Set up destination of the file
        $destination = realpath('./storage/profile') . DIRECTORY_SEPARATOR;
        $newFileName = uniqid(time()) . '-' . $filename;

        if(!$this->resizeImage(200, $destination.$newFileName, $file['tmp_name'])) return;

        //get old image
        $r = ORM::for_table($this->tblPre . 'user')->select('image')->find_one($id);
        if($r && !empty($r['image']) && $r['image']!='default_user.png'){
            $image = $r['image'];
            $errText = $destination.$image;
            @unlink($destination.$image);
        }
        
        $staff = ORM::for_table($this->tblPre . 'user')->find_one($id);
        $staff->image = $newFileName;
        $staff->save();

        /*if(@move_uploaded_file($file['tmp_name'] , $destination . $newFileName)) {
            $errText = $destination;
        }else $errText = $lang['ERROR_IMAGE'];*/
    }

    private function resizeImage($newwidth, $filename, $uploadedfile) {
        $info = getimagesize($uploadedfile);
        $ext = $info['mime'];
    
        list($width,$height)=getimagesize($uploadedfile);
    
        $newheight=($height/$width)*$newwidth;
        $tmp=imagecreatetruecolor($newwidth,$newheight);
    
        switch( $ext ){
            case 'image/jpeg':
                $src = imagecreatefromjpeg($uploadedfile);
                @imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                imagejpeg($tmp, $filename, 100);
                @imagedestroy($src);
                break;
    
            case 'image/png':
                $src = imagecreatefrompng( $uploadedfile );
                imagealphablending( $tmp, false );
                imagesavealpha( $tmp, true );
                imagecopyresampled( $tmp, $src, 0, 0, 0, 0, $newwidth,$newheight,$width,$height);
                imagepng($tmp, $filename, 5);
                @imagedestroy($src);
                break;
        }
        @imagedestroy($tmp);
        return true;
    }

    public function findStaffsByServices(){
        $services = CRequest::getStr('services');
        $start = DateTime::createFromFormat('m-d-Y H:i', CRequest::getStr('start'));
        $duration = CRequest::getStr('duration');
        $staffID = CRequest::getStr('staff');
        $arrTime = '';
        if($start) $arrTime = $start->format('Y-m-d H:i');
        
        $ts = sprintf('TIMESTAMPADD(MINUTE, %d, "%s")', $duration, $arrTime);
        $sql = "SELECT u.id, u.name, u.sex, u.phone, u.image, SUBSTR(u.name, CHAR_LENGTH(u.name) - LOCATE(' ', REVERSE(u.name))+1 ) AS lname  FROM qr_user u
                WHERE u.shop_id={$this->shopID} AND !u.deleted AND u.id NOT IN 
                (SELECT DISTINCT staff_id FROM qr_reservations 
                    WHERE shop_id={$this->shopID} AND !deleted AND (('{$arrTime}' BETWEEN arr_time AND dep_time) OR ({$ts} BETWEEN arr_time AND dep_time))
                ) ORDER BY lname ASC";
        
        $rows = ORM::forTable('qr_reservations')->rawQuery($sql)->findMany();        
        $staffs = array();
        foreach($rows as $r){
            $r = (object)$r;
            $staffs[] = array('id' => $r->id, 'name' => $r->name);
        }
        echo json_encode(array('staffs' => $staffs));
    }

}//DATA class

?>