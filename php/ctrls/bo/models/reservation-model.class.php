<?php

////*********************************************************************************************************************** */
/// DATA
////*********************************************************************************************************************** */
class CReservationData extends CBoLogicData{
    
    public function __construct(&$config, $shopID){        
        parent::__construct($config, $shopID);        
        $this->tableName = $config['db']['pre'].'reservations';
    }

    public function loadReservations($searchData = 0, $limitItems = 0){
        $itemCount = 0;
        $rowsPerPage = $limitItems>0 ? $limitItems : PAGINATION_ROWS_PER_PAGE; //defined at ctrls/bo/base.class.php

        $cond = $this->_buildSqlCondition($searchData);        
        $sqlCount = 'SELECT COUNT(*) AS items FROM qr_reservations r WHERE r.shop_id='.$this->shopID.$cond . ' AND !r.deleted';
        
        $rows = ORM::for_table($this->config['db']['pre'] . 'reservations')->raw_query($sqlCount)->find_one();
        if($rows) $itemCount = $rows['items'];
        
        $this->pager = new CPager($itemCount, $searchData['page'], $rowsPerPage, 5);
        
        $sql = 'SELECT r.id, r.shop_id, r.client_id AS cust_id, r.service_ids, r.arr_time, r.dep_time, r.duration, r.service_amount, r.recuded_amount as reduced, r.voucher, r.status, c.name AS customer, u.name AS staff 
                FROM qr_reservations r LEFT JOIN qr_customers c ON r.client_id=c.id AND r.shop_id=c.shop_id AND !c.deleted LEFT JOIN qr_user u ON u.id=r.staff_id AND u.shop_id=r.shop_id 
                WHERE !r.deleted AND r.shop_id='.$this->shopID.$cond . ' ORDER BY r.arr_time ASC, r.dep_time ASC LIMIT ' . $this->pager->begin() . ', ' . $rowsPerPage;                
        $this->data = ORM::for_table($this->config['db']['pre'] . 'reservations')->raw_query($sql)->find_many();
        return count($this->data);
    }    

    public function loadStaffs(){        
        if($this->userType!=EMPLOYER){
            $sql = 'SELECT id, name FROM qr_user WHERE shop_id='.$this->shopID.' AND status<>"2" ORDER BY name ASC';
            $rows = ORM::for_table($this->config['db']['pre'] . 'user')->raw_query($sql)->find_many();
            $data = 0;
            if($rows){
                $data = array();
                foreach($rows as $row){
                    $id = $row['id'];
                    $data[$id] = array('id' => $id, 'name' => $row['name']);
                }
            }
        }else{
            $user = CBoCtrl::getUser();
            $data = array($user->id => array('id'=>$user->id, 'name'=>$user->name));
        }
        return $data;
    }

    public function getDateRange(){
        return array($this->searchData['start_date'], $this->searchData['end_date']);
    }

    private function _buildSqlCondition(&$searchData){        
        $cond = '';
        $offset = CRequest::getNbr('page', -1);
        if(!$searchData){            
            $searchData = array(
                'start_date'    => date('Y-m-01', strtotime(date('Y-m')." -1 month")),
                'end_date'      => date('Y-m-d'),
                'staffs'        => 0,
                'status'          => -1,
                'page'          => -1
            );
        }
        
        if($offset < 0){
            //set new search data
            $start = CRequest::getStr('std');
            $end = CRequest::getStr('end');

            $searchData['start_date'] = $start ? $start : date('Y-m-01', strtotime(date('Y-m')." -1 month"));
            $searchData['end_date'] = $end ? $end : date('Y-m-t');
            $searchData['staffs'] = CRequest::getStr('staffs');
            $searchData['status'] = CRequest::getStr('status');
        }else{
            //get old search data, change the page index
            $searchData = $_SESSION['SEARCH_RESERVATION_DATA'];
            $searchData['page'] = $offset;
        }
        
        //save
        $_SESSION['SEARCH_RESERVATION_DATA'] = $searchData;
        $this->searchData = $searchData;

        $data = (object)$searchData;
        if($data->start_date){
            $cond = sprintf(' AND r.arr_time >= "%s 00:00:00"', date('Y-m-d', strtotime($data->start_date)));
        }
        if($data->end_date){
            $cond .= sprintf(' AND r.arr_time <= "%s 23:00:00"', date('Y-m-d', strtotime($data->end_date)));
        }
        if($data->staffs){
            $cond .= sprintf(' AND r.staff_id IN(%s)', $data->staffs);
        }
        if(strlen($data->status)>0){
            $cond .= " AND r.status IN ({$data->status})";
        }
        if($this->isEmployer()){
            $user = CBoCtrl::getUser();
            $cond .= " AND r.staff_id=" . $user->id;
        }

        //echo $cond . '<br/>';
        return $cond;
    }

    public function getBookingFeeds(){
        if(!$this->loadReservations(0, 50)){            
            echo json_encode([]);
            return 0;
        }
        
        $js = array();
        foreach($this->data as $item){
            $start = strtotime($item['arr_time']);
            $end = strtotime($item['dep_time']);

            $description = CReservationView::getBookingDescription($item);

            $js[] = array('groupId' => $item['id'],
                          'title' => sprintf('%d - %s (%s)', $item['id'], $item['customer'], $item['staff']),
                          'start' => sprintf('%sT%s', date('Y-m-d', $start), date('H:i:s', $start)), 
                          'end' => sprintf('%sT%s', date('Y-m-d', $end), date('H:i:s', $end)),
                          'color' => CReservationView::statusColor($item['status']),
                          'constraint' => 'businessHours'
                        );
        }
        echo json_encode($js);
    }

    public function getBookingRecord($id){
        $sql = "SELECT r.id, r.staff_id, r.client_id, r.service_ids, r.res_date, r.arr_time, r.dep_time, r.duration, r.service_amount, r.status, c.name AS client, c.email, c.phone, s.name AS staff
                FROM qr_reservations r LEFT JOIN qr_customers c ON r.client_id=c.id AND !c.deleted AND c.shop_id={$this->shopID}
                LEFT JOIN qr_user s ON r.staff_id=s.id AND !s.deleted 
                WHERE r.shop_id={$this->shopID} AND r.id={$id} AND !r.deleted LIMIT 1";        
        $this->data = ORM::forTable('qr_reservations')->raw_query($sql)->findOne();
        return !empty($this->data['id']);
    }

    public static function getServiceNames($ids){
        $rows = ORM::forTable('qr_menu')->select('name')->where_in('id', explode(',', $ids))->findMany();
        $names = ''; $count = count($rows); $idx = 0;
        foreach($rows as $row){
            $names .= $row['name'];
            if($idx++ < $count-1) $names .= ', ';
        }
        return $names;
    }

    public function getServicesInfo($ids){
        $sql = "SELECT id, name, IF(service_duration, service_duration, 60) AS duration, IF(discount_price<>null OR discount_price<>'', discount_price, price) AS price FROM qr_menu WHERE shop_id={$this->shopID} AND id IN ({$ids}) ORDER BY cat_id ASC";
        $rows = ORM::forTable($this->tblPre . "menu")->rawQuery($sql)->findMany();
        $data = array();        
        if(count($rows)){
            $data = array();
            foreach($rows as $r){
                $r = (object)$r;
                $data[] = array('id' => $r->id, 'name' => $r->name, 'price' => $r->price, 'duration' => $r->duration);
            }
        }
        return $data;
    }

    public function changeBookingRecordStatus($id, $status){
        if($id<=0) return 0;
        if($status<0 || $status>BOOKING_STATUS_DONE) return 0;
       if($status>=0 && $status<=BOOKING_STATUS_DONE) $sql = "UPDATE qr_reservations SET status={$status} WHERE id={$id}";
        else $sql = "UPDATE qr_reservations SET deleted=1 WHERE id={$id}";

        return ORM::get_db()->prepare($sql)->execute() ? $id : 0;
    }

    public function deleteBookingRecord($id){
        if($id<=0) return 0;
        $sql = "UPDATE qr_reservations SET deleted=1 WHERE id={$id}";
        return ORM::get_db()->prepare($sql)->execute() ? 1 : 0;
    }

    public function getOpenCloseHours(){
        $table = $this->tblPre.'open_close_hour';
        $sql = "SELECT ( CASE WHEN day_of_week='sunday' then 0 WHEN day_of_week='monday' then 1 WHEN day_of_week='tuesday' then 2 
                        WHEN day_of_week='wednesday' then 3 WHEN day_of_week='thursday' then 4 WHEN day_of_week='friday' then 5 
                        WHEN day_of_week='saturday' then 6 END ) as day_nbr, day_of_week, open_hour, close_hour, open_hour_2, close_hour_2 
                FROM {$table} WHERE shop_id={$this->shopID} ORDER by day_nbr ASC";

        $rows = ORM::forTable($table)->rawQuery($sql)->findMany();
        $hours = array();
        foreach($rows as $r){
            $r = (object)$r;
            if($r->close_hour=='00:00') $r->close_hour='24:00';
            if($r->close_hour_2=='00:00') $r->close_hour_2='24:00';
            $hours[] = array('daysOfWeek' => $r->day_nbr, 'startTime' => $r->open_hour, 'endTime' => $r->close_hour);
            if($r->open_hour_2 && $r->close_hour_2){
                $hours[] = array('daysOfWeek' => $r->day_nbr, 'startTime' => $r->open_hour_2, 'endTime' => $r->close_hour_2);
            }
        }

        return json_encode($hours);
    }

    public function getAllServices2JSON(){
        $qry = CRequest::getStr('qry');
        $condition = '';
        if($qry){
            $condition .= " AND name LIKE '%{$qry}%'";
        }
        $sql = "SELECT id, name, service_duration AS duration, IF(discount_price<>null OR discount_price<>'', discount_price, price) AS price FROM qr_menu WHERE shop_id={$this->shopID} {$condition} ORDER BY cat_id ASC";
        
        $rows = ORM::forTable("{$this->tblPre}menu")->rawQuery($sql)->findMany();
        $data = array();
        
        if(count($rows)){
            $data = array();
            foreach($rows as $r){
                $r = (object)$r;
                $data[] = array('id' => $r->id, 'name' => $r->name, 'price' => $r->price, 'duration' => $r->duration);
            }
        }

        $jsonData = json_encode(array('results' => $data), JSON_UNESCAPED_UNICODE);
        
        if(empty($qry)){
            $file = __DIR__.DIRECTORY_SEPARATOR.'/../data/services.json';        
            if(!file_exists($file)){
                file_put_contents($file, $jsonData);
                echo $jsonData;
                return;
            }
            
            $diff = time() - filemtime($file);
            $days = round($diff/86400);
            if($days>=1){
                //refresh 
                file_put_contents($file, $jsonData);
                echo $jsonData;
                return;
            }        
            //otherwise, read the file the output        
            echo file_get_contents($file);
        }else echo $jsonData;
    }

    public function &getClientsList(){
        $qry = CRequest::getStr('qry');
        $sql = "SELECT id, name, email, phone FROM qr_customers WHERE shop_id={$this->shopID} AND deleted=0 ";
        if($qry) $sql .= " AND name LIKE '%{$qry}%' OR phone LIKE '%{$qry}%'";
        $sql .= ' ORDER BY name ASC';        
        $rows = ORM::forTable('qr_customers')->rawQuery($sql)->findMany();

        $data = array();
        if(count($rows) == 0){
            echo json_encode(array('results' => $data)); return;
        }
        
        foreach($rows as $r){
            $r = (object)$r;
            $data[] = array( 'id' => $r->id, 'name' => $r->name, 'email' => $r->email, 'phone' => $r->phone);
        }
        
        $jsonData = json_encode(array('results' => $data));
        
        if(empty($qry)){
            $file = __DIR__.DIRECTORY_SEPARATOR.'/../data/clients.json';
            if(!file_exists($file)){
                file_put_contents($file, $jsonData);
                echo $jsonData;
                return;
            }
            
            $diff = time() - filemtime($file);
            $days = round($diff/86400);
            if($days>=1){
                //refresh 
                file_put_contents($file, $jsonData);
                echo $jsonData;
                return;
            }        
            //otherwise, read the file the output        
            echo file_get_contents($file);
        }else echo $jsonData;
    }

    public function saveBookingRecord(&$errObj){
        
        $id = CRequest::postNbr('id');
        
        $_POST['shop_id'] = $this->shopID;
        $_POST['service_ids'] = $_POST['service-ids'];
        
        $data = &$_POST;        
        unset($_POST['service-ids']);
        unset($_POST[$_SESSION['user']['login_string']]);

        $data['duration'] = intval($data['duration']);

        $arr_time = DateTime::createFromFormat('m-d-Y H:i', $data['arr_time'])->format('Y-m-d H:i');
        $dep_time = DateTime::createFromFormat('m-d-Y H:i', $data['dep_time'])->format('Y-m-d H:i');
        $data['res_date'] = date("Y-m-d H:i:s");
        $data['arr_time'] = $arr_time;
        $data['dep_time'] = $dep_time;

        $data['duration'] = intval($data['duration']);
        $data['service_amount'] = intval($data['service_amount']);

       // print_r($data);die;
        
        $query = '';        
        
        //check service date again
        $ret = $this->checkServiceTimeOfTheStaff($data['id'], $data['staff_id'], $data['duration'], $data['arr_time'], $query);
        
        if(!$ret){
            global $lang;
            $errObj->text = sprintf($lang['STAFF_NOT_AVAILABLE_IN_TIME'], $data['arr_time']);
            $errObj->field = 'arr_time';
            //$errObj->text = $query;
            return 0;
        }

        $id = $data['id'];
        $sql = $this->prepareSQL($data, $id ? 'update' : 'insert', $this->tableName);
        unset($data['id']);        

        $pdo = ORM::get_db();
        $stmt = $pdo->prepare($sql);

        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $ret = $stmt->execute($data);   

        if($ret){
            if($id<=0) $id = $pdo->lastInsertId();
            $errObj->color = CReservationView::statusColor($data['status']);
            $errObj->duration = $data['duration'];

            // update set BOOKING_STATUS_CANCELLED and send email


            // if($data['status']==2){
            //  $this->sendCancelEmail($id);
            // }
            // elseif ($data['status']==0)
            // {
            //  $this->sendEmail($id, $data, $errObj);
            // }
            $this->sendEmailToCustomer($id,$data['status']);
            
        }else{            
            $errorInfo = $stmt->errorInfo();
            $errObj->text = $errorInfo[0];
        }
        return $ret ? $id : 0;
    }

    public function checkServiceTimeOfTheStaff($recordId, $staffId, $duration, $arrTime, &$sql){
        $sql = "SELECT id, staff_id, arr_time, dep_time, status, @ts 
                FROM qr_reservations WHERE !deleted AND staff_id={$staffId} AND DATE('@dt')=DATE(arr_time)
                AND status NOT IN (1,2) 
                AND ( '@dt' BETWEEN arr_time AND dep_time  OR @ts BETWEEN arr_time AND dep_time OR ('@dt'<=arr_time AND @ts>=dep_time))";
        $ts = "TIMESTAMPADD(MINUTE, {$duration}, '{$arrTime}')";
        $sql = str_replace(array("@dt", "@ts"), array($arrTime, $ts), $sql);
        $row = ORM::forTable('')->rawQuery($sql)->findOne();
        if(isset($row['id'])){            
            return $row['id'] == $recordId;
        }
        return 1;
    }

    public function checkServiceTimeInBussinessHours($arrTime, &$sql){
        $arrTime = sprintf("'%s'", $arrTime);
        $sql = "SELECT day_of_week, open_hour, close_hour, open_hour_2, close_hour_2
                FROM qr_open_close_hour  WHERE shop_id={$this->shopID} AND dayname($arrTime) = day_of_week 
                AND ( TIME($arrTime) BETWEEN TIME(open_hour) AND TIME(IF(close_hour!='00:00', close_hour, '24:00'))
                OR ( IF(LENGTH(open_hour_2) AND LENGTH(close_hour_2), TIME($arrTime) BETWEEN TIME(open_hour_2) AND TIME(IF(close_hour_2!='00:00', close_hour_2, '24:00')), 0 ) )  )";
        $rows = ORM::forTable('')->rawQuery($sql)->find_many();
        return $rows && count($rows);
    }

    public function updateBookingTime(){
        $id = CRequest::getNbr('id');
        $arr_time = CRequest::getStr('start');
        $dep_time = CRequest::getStr('end');
        if($id<=0 || !CBoLogicData::isDateTime($arr_time) || !CBoLogicData::isDateTime($dep_time)){
            echo json_encode(array('result' => 0, 'id' => $id)); return;
        }
        
        $info = $this->getBookingInfo($id);
        if(!$info){
            echo json_encode(array('result' => 0, 'id' => $id, 'error'=>'not found')); return;
        }

        $query = '';
        if(!$this->checkServiceTimeOfTheStaff($id, $info->staff_id, $info->duration, $info->arr_time, $query)){
            echo json_encode(array('result' => 0, 'query' => $query));
            return;
        }

        $data = array('id' => $id, 'arr_time' => $arr_time, 'dep_time' => $dep_time);        
        $sql = $this->prepareSQL($data, 'update', $this->tableName);
        unset($data['id']);
        $ret = ORM::get_db()->prepare($sql)->execute($data);
        echo json_encode(array('result' => $ret ? 1 : 0, 'id' => $id));
    }

    private function getBookingInfo($id){
        $data = ORM::forTable($this->tblPre.'reservations')->select_many('id', 'staff_id', 'client_id', 'status', 'duration', 'arr_time')->where('id', $id)->find_one();
        return $data;
    }

    public function loadBookingSettings(){
        require_once(__DIR__.'/../shop-options-ctrl.class.php');
        require_once(__DIR__.'/../message-template-ctrl.class.php');
        
        global $config;
        $msgData = new CMessageTemplateData($config, $this->shopID);
        $templates = $msgData->getAllTemplates('email', 'comeback_shop_remind');
        $activeLangCodes = $this->getLanguages('de');
        
        $shopModel = new CShopOptionsData($config, $this->shopID);
        $template = $shopModel->getShopOtion($this->shopID, 'shop_booking_template', 1);
        $paypal = $shopModel->getShopOtion($this->shopID, 'shop_pay_via_paypal', 0);
        $stripe = $shopModel->getShopOtion($this->shopID, 'shop_pay_via_stripe', 0);
        
        $booking_reminder_by_a_week = $shopModel->getShopOtion($this->shopID, 'booking_reminder_by_a_week', 0);
        $booking_reminder_by_a_day = $shopModel->getShopOtion($this->shopID, 'booking_reminder_by_a_day', 0);

        $booking_reminder_msg_template = $shopModel->getShopOtion($this->shopID, 'booking_reminder_msg_template', 0);
        $booking_reminder_msg_langcode = $shopModel->getShopOtion($this->shopID, 'booking_reminder_msg_langcode', 'de');

        $booking_show_staffs_list = $shopModel->getShopOtion($this->shopID, 'booking_show_staffs_list', 0);
        $booking_total_bookable_staffs = $shopModel->getShopOtion($this->shopID, 'booking_total_bookable_staffs', 1);

        $settings = array('template' => $template>=1&&$template<=2?$template:1, 'paypal' => $paypal, 'stripe' => $stripe,
                         'booking_reminder_msg_template' => $booking_reminder_msg_template, 
                         'booking_reminder_msg_langcode' => $booking_reminder_msg_langcode,
                         'booking_reminder_by_a_day' => $booking_reminder_by_a_day,
                         'booking_reminder_by_a_week' => $booking_reminder_by_a_week,
                         'booking_show_staffs_list' => $booking_show_staffs_list,
                         'booking_total_bookable_staffs' => $booking_total_bookable_staffs,
                         'messageTemplates' => $templates, 'activeLangCodes' => $activeLangCodes);
        return $settings;        
    }

    public function saveBookingSettings(){
        $paypal = CRequest::postNbr('shop_pay_via_paypal');
        $stripe = CRequest::postNbr('shop_pay_via_stripe');
        $template = CRequest::postStr('shop_booking_template');

        $booking_show_staffs_list = CRequest::postStr('booking_show_staffs_list') ? 1 : 0;
        $booking_total_bookable_staffs = CRequest::postNbr('total_bookable_staffs');
        if($booking_total_bookable_staffs < 0) $booking_total_bookable_staffs = 0;

        $booking_reminder_by_a_week = CRequest::postStr('booking_reminder_by_a_week');
        $booking_reminder_by_a_day = CRequest::postStr('booking_reminder_by_a_day');
        $booking_reminder_msg_template = CRequest::postStr('booking_reminder_msg_template');
        $booking_reminder_msg_langcode = CRequest::postStr('booking_reminder_msg_langcode');

        require_once('shop-options-ctrl.class.php');
        global $config;
        $shopModel = new CShopOptionsData($config, $this->shopID);
        $json = array('error' => 0, 'msg' => '');
        $shopModel->updateShopOption($this->shopID, 'shop_booking_template', $template);
        $shopModel->updateShopOption($this->shopID, 'shop_pay_via_paypal', $paypal);
        $shopModel->updateShopOption($this->shopID, 'shop_pay_via_stripe', $stripe);
        $shopModel->updateShopOption($this->shopID, 'booking_reminder_by_a_week', $booking_reminder_by_a_week);
        $shopModel->updateShopOption($this->shopID, 'booking_reminder_by_a_day', $booking_reminder_by_a_day);
        $shopModel->updateShopOption($this->shopID, 'booking_reminder_msg_template', $booking_reminder_msg_template);
        $shopModel->updateShopOption($this->shopID, 'booking_reminder_msg_langcode', $booking_reminder_msg_langcode);

        $shopModel->updateShopOption($this->shopID, 'booking_show_staffs_list', $booking_show_staffs_list);
        if(!$booking_show_staffs_list)
            $shopModel->updateShopOption($this->shopID, 'booking_total_bookable_staffs', $booking_total_bookable_staffs);
        echo json_encode( $json );
    }

    public function sendEmailToCustomer($bookingID){
        global $config, $lang, $link;
        CShopInfo::getInfo($this->shopID);
        $main_image = CShopInfo::$data->logo;
        $shop_telephone = CShopInfo::$data->phoneNumber;
        $shop_address = CShopInfo::$data->address;
        $shop_name = CShopInfo::$data->name;

        $reservations_staff = "";
        $reservations = ORM::for_table($config['db']['pre'].'reservations')->find_one($bookingID);
        if(empty($reservations)){
              return 0;
        }  
        if ($reservations['staff_id'] != 0){
        $staff = ORM::for_table($config['db']['pre'].'user')->find_one($reservations['staff_id']);
        $reservations_staff = $staff['name'];
        }
        $client = ORM::for_table($config['db']['pre'].'customers')->find_one($reservations['client_id']);
        $datum = date("d.m.Y H:i", strtotime($reservations['res_date']));
        $rabatt_code = '';
        $rabatt_cost = '';
        $payment_methoad = '';
        if (!empty($reservations['voucher'])) {
            $rabatt_code = $reservations['voucher'];
            $rabatt_cost = number_format($reservations->recuded_amount,2,',','.');
        }
    
        if($reservations->payment_type!='paypal'){
            $payment_methoad = 'Bar';
        }
        else
        {
           $payment_methoad = 'Paypal';
           $payment_methoad .= ' (Bezahlt)';
        }
     
        $tpl = '';
        $totalDuration = 0;
        $customer_care = ORM::for_table('qr_customer_care') ->where('resv_id', $bookingID)->find_one();
        $service_ids = $customer_care['service_ids'];

        $sql = "SELECT id, name, service_duration AS duration, description, IF(discount_price, discount_price, price) AS price, IF(discount_price,price-discount_price, 0) AS discount FROM qr_menu WHERE active='1' AND id IN(". $service_ids .")";
        $items = ORM::forTable('')->rawQuery($sql)->find_many();
    
        foreach ($items as $item) {
            $itemData = ORM::for_table('qr_menu')
            ->where('id', $item['id'])
            ->find_one();
            $total_price_item = 0;
            $itemPrice = number_format($item['price'], 2, ',', '.');
            $tpl .= '<tr><td class="menu_title" height="40">' .  $itemData['name'] . '<br>';
            $tpl .= '</td>';
            $tpl .= '<td height="40" class="menu_price"> <div align="right">' . $itemPrice . '</div></td>';
            $tpl .= '<td height="40" class="menu_total_price"><div  align="right">' . $item['duration'] . '</div></td></tr>';
           $totalDuration += $item['duration']; 
        }
        $totalAmount = $reservations->service_amount - $reservations->recuded_amount; 
        $totalAmount = number_format($totalAmount, 2, ',', '.') . ' ( ' . $totalDuration . ' Minute)';
    
        $page = new HtmlTemplate($config['site_url'] . "templates/" . $config['tpl_name'] . "/template_email_reservation.tpl");
        $result = ORM::for_table('qr_shop_options')->where('option_name', 'shop_theme_color')->where('shop_id', $this->shopID)->find_one();    
        $classic_boder_color = $result['option_value'];

        $status = "";
        $subject = "";
        switch ($reservations['status']) {
            case '0':
                $status = "Bestätigt";
                $subject = "New reservations";
                break;
            case '1':
                //cảm ơn, chưa có template
                break;
            case '2':
                $status = "Abgesagt";
                $subject = "Termin stornieren"; 
                break;   
            default:
                $status = "Bestätigt";
                $subject = "New reservations";
                break;
        }

        $LINK_CANCELLED_BOOKING = "<a href='". $config['site_url'] . 'reservation-customer-edit?id=' . $reservations['id']  ."'>Link zur Terminabsage</a>";
     
        $page->SetParameter('BACKGROUND', $classic_boder_color);
        $page->SetParameter('SHOP_TELEPHONE', $service_ids);
        $page->SetParameter('MAIN_IMAGE', $main_image);
        $page->SetParameter('SHOP_ADDRESS', $shop_address);
        $page->SetParameter('SHOP_NAME', $shop_name);
        $page->SetParameter('RESERVATIONS_STATUS_TEXT', $status);
        $page->SetParameter('CUSTOMER_NAME', $client['name']);
        $page->SetParameter('CUSTOMER_TELEPHONE',$client['phone']);
        $page->SetParameter('CUSTOMER_EMAIL', $client['email']);
        $page->SetParameter('TOTAL_SUM', $totalAmount);
        $page->SetParameter('RESERVATIONS_STATUS_CODE', $reservations['status']); // none display cancel link
        $page->SetParameter('DATE_BOOKING', $datum);
        $page->SetParameter('RABATT_CODE', $rabatt_code);
        $page->SetParameter('RABATT_COST', $rabatt_cost);
        $page->SetParameter('RESERVATIONS_STAFF',$reservations_staff);
        $page->SetParameter('PAYMENT_METHOAD', $payment_methoad);
        $page->SetParameter('RESERVATIONS_DETAIL', $tpl);
        $page->SetParameter('LINK_CANCELLED_BOOKING', $LINK_CANCELLED_BOOKING);
        
        $body = $page->CreatePageReturn($lang, $config, $link);
       
        require_once(__DIR__.'/../mail-list-ctrl.class.php');
        $thectrl = new CMailListCtrl($config, $this->shopID);               
        $thectrl->view->initEmailEngine();
        $thectrl->view->mailer->SetFrom(CShopInfo::$data->shop_smtp_user, CShopInfo::$data->name);
        $ret = $thectrl->view->emailCustomer($client['email'],$client['name'], $subject, $body, null, CShopInfo::$data->email, CShopInfo::$data->name);    
    }

    private function sendThanksYouEmail($bookingID, &$postData, &$outObj)
    {
        // chưa làm :V
    }
    private function sendConfirmationEmail($bookingID, &$postData, &$outObj){
        global $config;
        
        $sql = "SELECT email, name FROM {$this->tblPre}customers WHERE id={$postData['client_id']} AND shop_id={$this->shopID}";
        $info = ORM::forTable("")->rawQuery($sql)->findOne();
        if(!$info) return false;
        
        //get the email content
        $sql = "SELECT title, content  FROM {$this->tblPre}message_templates WHERE shop_id={$this->shopID} AND !deleted AND template_type='booking_confirmation' AND send_via='email' AND active";
        $themsg = ORM::forTable("{$this->tblPre}message_templates")->rawQuery($sql)->findOne();
        if(!$themsg) return false;
        
        $subject = html_entity_decode($themsg->title);
        $body = html_entity_decode($themsg->content);        

        $data = null;
        $serviceTable = $this->buildServicesContent($bookingID, $data);
        if(!$serviceTable) return false;

        if(!CShopInfo::getInfo($this->shopID)) return false;

        $body = str_replace(array('{CUSTOMER_NAME}', '{SERVICE_TIME}', '{BOOKING_CONTENT}', '{SHOP_NAME}'), 
                            array($info->name, date("m-d-Y H:i A", strtotime($data->arr_time)), $serviceTable, CShopInfo::$data->name), $body);
        $body .= CShopInfo::emaiFooter();
        
        
        require_once(__DIR__.'/../mail-list-ctrl.class.php');
        $thectrl = new CMailListCtrl($config, $this->shopID);        
        
        $thectrl->view->initEmailEngine();
        $thectrl->view->mailer->SetFrom(CShopInfo::$data->shop_smtp_user, CShopInfo::$data->name);
        $ret = $thectrl->view->emailCustomer($info->email, $info->name, $subject, $body, null, CShopInfo::$data->email, CShopInfo::$data->name);        
        $outObj->text = $ret ? "SENT {$info->email}" : $config['email_result_message'];
    }

    private function buildServicesContent($bookingID, &$data){        
        global $lang;
        //get the booking record info
        $data = ORM::for_table("{$this->tblPre}reservations")->findOne($bookingID);
        if(!$data) return false;        
        
        $html = "";
        $sql = "SELECT id, name, service_duration AS duration, description, IF(discount_price, discount_price, price) AS price, IF(discount_price,price-discount_price, 0) AS discount FROM {$this->tblPre}menu WHERE active='1' AND id IN({$data->service_ids})";
        $rows = ORM::forTable('')->rawQuery($sql)->findMany();
        if(!$rows) return false;

        $idx = 1; $srow = "";
        foreach($rows as $r){
            $r = (object)$r;
            $sprice = $this->getPrices($r->price, $r->discount);
            $srow .= "<tr><td style='text-align:center;'>{$idx}</td><td>{$r->name}</td><td>{$r->duration}</td><td>{$sprice}</td></tr>";
            ++$idx;
        }

        if($data->recuded_amount && $data->voucher){
            $srow .= "<tr style='background:#FAFAF5'><td></td><td>{$lang['VOUCHER']}</td><td>{$data->voucher}</td><td>" . $this->toPrice($data->recuded_amount) . "</td></tr>";
        }
        $srow .= "<tr style='background:#FAFAF5'><td></td><td style='font-weight:bold;'>{$lang['TOTAL']}</td><td><strong>{$data->duration}</strong></td><td><strong>" . $this->toPrice($data->service_amount - $data->recuded_amount) . "</strong></td></tr>";

        $html = "<table width='100%' style='margin:15px;' cellspacing='2' cellpadding='12'><tr style='font-weight:bold;background-color:#FAF5F5;'><td width='20px' style='text-align:center'>#</td>
                    <td width='30%'>{$lang['SERVICE']}</td><td width='30%'>{$lang['DURATION']} ({$lang['MINUTE']})</td><td width='30%'>{$lang['PRICE']}</td></tr>" . $srow . "</table>";
        return $html;
    }

    private static function get_shop_smtp_info(){
        global $config;
        $info = ORM::for_table($config['db']['pre'].'shop')->select_many('shop_smtp_user', 'shop_smtp_secret')->find_one($_SESSION['user']['shop_id']);
        if($info){
            $config['smtp_username'] = $info->shop_smtp_user;            
            $config['smtp_password'] = $info->shop_smtp_secret;
        }        
    }

    private function toPrice($nbr){
        return number_format($nbr, 2, '.', ',');
    }

    private function getPrices($price, $discount){
        $html = "";
        if($discount){
            $html = "<span style='margin-right:12px;text-decoration:line-through;'>" . number_format($price + $discount, 2, '.', ',') . "</span>";
        }
        $html = "<span style=''>" . number_format($price, 2, '.', ',') . "</span>";
        return $html;
    }
}//DATA class
?>