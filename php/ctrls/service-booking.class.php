<?php
defined("LPCTSTR_TOKEN") or die(":-((");

class CServiceBooking{    
    private $tblPre;
    private $shopId=0;
    public function __construct($tblPre){
        $this->tblPre = $tblPre;
        $timezone = isset($_SESSION['DEFAULT_TIME_ZONE']) ? $_SESSION['DEFAULT_TIME_ZONE'] : 'Europe/Berlin';
        date_default_timezone_set($timezone);        
        //parent::__construct();
    }

    public function listNailSt2ffs(){
        $tbl_shop = $this->tblPre.'shop';
        $tbl_user = $this->tblPre.'user';

        $shopId = CRequest::getNbr('shid');
        $specIds = CRequest::getStr('specIds'); 
        $d = strtotime(CRequest::getStr('dt'));
        $resDate =  date("Y-m-d", $d);
        $now = date('Y-m-d');        
        
        $data = array('shop_id'=>$shopId, 'specIds' => $specIds);
        $this->_saveBookingRecord($data);

        $cond = $this->_buildStaffsConditionBySpec($specIds);

        $sql = 'select u.id, u.name, u.sex, u.phone, u.image from qr_user u where !u.deleted AND u.shop_id = ' . $shopId . $cond;        

        $rows = ORM::for_table($this->tblPre . 'user')->raw_query($sql)->find_many();  
        $itemCount = count($rows);
        if(!$itemCount){
            //$this->showStaff(array('id'=>'0', 'name' => 'Anyone', 'image' => 'default_user.png'));            
            global $lang;
            echo "<p class='error text-danger'><strong>" . $lang['STAFF_NOT_FOUND'] . "</strong></p>";
            return;
        }
        //$this->showStaff(array('id'=>'0', 'name' => 'Anyone', 'image' => 'default_user.png'));
        $staffs = 0;  $idx = 0; $count = $itemCount;
        if($rows){
            foreach($rows as $row){                
                $staffName = $row['id'] . '. ' . $row['name'];
                $this->showStaff($row);
            }
        }   
    }

    public function listTimeSlots(){
        $tolerance = 5;
        $startDate = CRequest::getStr('dt');
        $d = strtotime($startDate);
        $dayOfWeek = date("l", $d);
        $serviceDuration = CRequest::getNbr('dr');
        $shopId = CRequest::getNbr('shid');
        $staffId = CRequest::getNbr('staff'); 
        $staffName = CRequest::getStr('st2ffname');
        $serviceIds = CRequest::getStr('sids');

        $data = array(
                    'shop_id'=>$shopId, 'staff'=>$staffId, 'staff_name'=>$staffName, 
                    'date'=>$startDate, 'weekDate' => date('l, F-d', $d), 'duration'=>$serviceDuration, 'sids' => $serviceIds
                );

        $sessData = unserialize($_SESSION['BOOKING_TMP_RECORD']);        
        $this->_saveBookingRecord(array_merge($sessData, $data));

        $this->_buildTimeSlots($startDate, $shopId, $serviceDuration - $tolerance, $staffId);
    }

    private function _buildTimeSlots($startDate, $shopId, $duration, $staffId=0){
        $today = new DateTime(date("m/d/Y"));
        $d = new DateTime($startDate);        
        $availableSlots = 0; $naSlots = 0;        
        $avaiDates = array();
        $data = $this->_getBookingRecord();

        $staffCondition = $staffId>0 ? sprintf(' AND u.id=%d', $staffId) : '';        
        $staffCondition .= $this->_buildStaffsConditionBySpec($data['specIds']);
        
        for($i=1; $i<=7; ++$i){            
            $hours = 0; $closeHour = ''; $startHour = '';
            if($i==1 && $today==$d){
                $startHour = date('H:00');                
            }
            if($closeHour = $this->_getHourRanges($shopId, $d->format('l'), $startHour, $hours)){
                $hidx = 0;                
                ////status: 0           1           2         3       4
                ////        pending, confirmed, in-progress, done, deleted
                foreach($hours as &$h){
                    $ts = sprintf('TIMESTAMPADD(MINUTE, %d, "%s %s")', $duration, $d->format('Y-m-d'), $h['tm']);
                    $dt = sprintf('%s %s', $d->format('Y-m-d'), $h['tm']);
                    $sql = 'SELECT COUNT(u.id) AS items FROM qr_user u 
                            WHERE !u.deleted AND u.shop_id=' . $shopId . $staffCondition . ' AND status<=3 AND u.id NOT IN
                            (SELECT DISTINCT staff_id FROM qr_reservations WHERE !deleted AND ("' . $dt . '" >= arr_time AND "' . $dt . '" < dep_time) 
                            OR (' . $ts . ' BETWEEN arr_time AND dep_time) OR ("' . $dt . '" < arr_time AND ' . $ts . '>dep_time))';
                    
                    if($h['tm']==8){
                        //echo $sql; return;
                    }

                    $rows = ORM::for_table($this->tblPre . 'user')->raw_query($sql)->find_one();  
                    $itemCount = $rows['items'];

                    /*$d1 = new DateTime($startDate . ' ' . $closeHour);
                    $d2 = new DateTime($startDate . ' ' . $h['tm']);
                    $d2->add(new DateInterval('PT' . $duration . 'M'));
                    $h['status'] = $itemCount && $d1>$d2;*/
                    $h['status'] = $itemCount;
                }
                $avaiDates[$d->format('l')] = array('dow' => $d->format('l'), 'displayDate' => $d->format('l, F d'), 'date' => $d->format('Y-m-d'), 'closeHour'=>$closeHour, 'hours' => $hours);
            }
            $d->modify('+1 day');            
        }
        
        //*************************************************************** */
        //clear disabled time slots        
        foreach($avaiDates as $k=>$days){            
            $idx = 0;            
            $count = count($days['hours']);
            foreach($days['hours'] as $i => $hour){
                if(!$hour['status']) unset($avaiDates[$k]['hours'][$i]);
            }
        }

        $_COLS = 6;
        $idx = 0;
        //echo '<div class="accordion" id="avai-date-list">
        //        <div data-toggle="buttons">';
        foreach($avaiDates as $days){
            $count = count($days['hours']);
            if(!$count) continue;
            $thePanelID = 'thepanel-' . str_replace('-','', $days['date']);
            $theHeadingID = 'heading-'.$days['date'];
            $theCollapseID = 'collapse-'.$days['date'];
            ?>
            <div class="accordion" id="avai-date-list">
                <div data-toggle="buttons">
                    <div class="card">
                        <div class="card-header" id="<?php echo $theHeadingID;?>" style="padding:0.15rem">
                            <a class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?php echo $theCollapseID?>" aria-expanded="true" aria-controls="<?php echo $theCollapseID?>">
                                <b><?php echo $days['displayDate']; ?></b>
                            </a>
                        </div>
                        <div id="<?php echo $theCollapseID?>" class="collapse<?php echo $idx++?'':' show' ?>" aria-labelledby="<?php echo $theHeadingID;?>" data-parent="#avai-date-list">
                            <div class="card-body book-time btn-group" style="display:block" data-selected-time='' data-selected-date=''>
                            <?php
                            $count = count($days['hours']);
                            $j = 0;
                            foreach($days['hours'] as $item){
                                if($j % 6 == 0){
                                    if($j) echo '</div>';
                                    echo '<div class="row d-flex">';
                                }
                                echo '<label class="flex-fill col-lg-2 col-md-2 col-sm-6 col-xs-6 btn ' . ($item['status'] ? '':'disabled') . '" data-selected-date="' . $days['date'] . '">' . $item['tm'] 
                                        . '<input type="radio" name="time-slots[]" value="' . $item['tm'] . '"' . ($item['status'] ? '' : ' disabled="true"') . '></label>';
                                if($j++ == $count - 1) echo '</div>';
                            }                    
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        //echo '</div></div>';
    }//_buildTimeSlots

    private function _getHourRanges($shopId, $dayOfWeek, $startHour, &$hoursOut){
        $hours = 0;
        $hours = ORM::for_table($this->tblPre . 'open_close_hour')->where(array('shop_id' => $shopId, 'day_of_week' => $dayOfWeek))->find_one();            
        
        if(!$hours){
            return 0;
        }
        
        $closeHour = '';
        
        if($hours['close_hour']=='00:00') $hours['close_hour'] = '24:00';
        if(!empty($hours['close_hour_2']) && $hours['close_hour_2']=='00:00') $hours['close_hour_2'] = '24:00';
        
        if(!empty($startHour)){
            $h1 = new DateTime($startHour);
            $h2 = new DateTime($hours['open_hour']);            
            if($h1 > $h2){                
                $tmph = intval($h1->format('H')) + 1;                
                if($tmph < intval($hours['close_hour'])){
                    $hours['open_hour'] = "{$tmph}:00";
                }else{                    
                    if(!empty($hours['close_hour_2'])){
                        if($tmph < intval($hours['close_hour_2'])-1){
                            if($tmph > intval($hours['open_hour_2']))
                                $hours['open_hour'] = "{$tmph}:00";
                            else $hours['open_hour'] = $hours['open_hour_2'];

                            $hours['close_hour'] = $hours['close_hour_2'];
                            unset($hours['open_hour_2']);
                            unset($hours['close_hour_2']);
                        }else{
                            return 0;
                        }
                    }else{
                        if($tmph >= intval($hours['close_hour'])) return 0;
                    }
                }                
            }else{
                //echo $h1->format('H'); echo $h2->format('H');
            }
        }

        $hls[] = array('open_hour'=>$hours['open_hour'], 'close_hour'=>$hours['close_hour']);
        $closeHour = $hours['close_hour'];
        if($hours['open_hour_2'] && $hours['close_hour_2']){            
            $hls[] = array('open_hour'=>$hours['open_hour_2'], 'close_hour'=>$hours['close_hour_2']);
            $closeHour = $hours['close_hour_2'];
        }
        
        if(!count($hls)){
            return 0;
        }
        
        $hoursOut = array();
        $i = 0;
        foreach($hls as $h){
            $date = new DateTime($h['open_hour']);
            $start = $date->format('H'); $startMin = $date->format('i');
            $end = (new DateTime($h['close_hour']))->format('H');
            $start = intval($start);
            $end = intval($end);
            if(!$end) $end = 24;
            $hoursOut[$i++] = array('status'=>1, 'tm' => $start . ':' . $startMin);
            for($i = $start+1 ; $i < $end ; ++$i){                
                $hoursOut[] = array('status'=>1, 'tm' => $i . ':00');
            }
        }        
        return $closeHour;
    }//hour ranges
    
    public function bookingD3tailsForm(){        
        $data = unserialize($_SESSION['BOOKING_TMP_RECORD']);
        $bookDate = CRequest::getStr('rdat3');
        $bookTime = CRequest::getStr('rtim3');

        $sql = 'select id, name, if(discount_price>0, discount_price, price) as price FROM qr_menu WHERE active AND id IN('.$data['sids'].')';
        $rows = ORM::for_table($this->tblPre . 'qr_menu')
                ->raw_query($sql)->find_many();
        if(!$rows){
            return 0;
        }

        $servicesName = ''; $subAmt = 0; $count = count($rows); $idx = 0;
        foreach($rows as $row){
            $servicesName .= sprintf('%s', $row['name']);
            if(++$idx < $count) $servicesName .= ' / ';

            $subAmt += $row['price'];
        }
        
        $data['date'] = $bookDate;
        $data['bookTime'] = $bookTime;
        $data['bookTimeDisplay'] = $bookTime . ' - ' . date("H:i", strtotime('+'.$data['duration'].' minutes', strtotime($bookTime)));
        $data['serviceName'] = $servicesName;
        $data['subAmt'] = $subAmt . ' EUR';
        $data['weekDate'] = date('l, F d', strtotime($bookDate));
        $_SESSION['BOOKING_TMP_RECORD'] = serialize($data);
        echo json_encode($data);
    }

    public function findFr3eStaffByTim3(){
        $duration = 60; //sample service duration, in minutes
        $d = strtotime(CRequest::getStr('dt'));
        $resDate =  date("Y-m-d H:i:s", $d);
        $resHour =  date("H:i:s", $d);
        $dayOfWeek = date("l", $d);
        $shopId = CRequest::getNbr('shid');

        if(!$this->checkOpenCloseHourRange($shopId, $resDate, $dayOfWeek, $resHour)){
            echo '{TIME OUT OF RANGE}';
            return;
        }
        
        //TO DO: CHECK THE USER IS ACTIVE
        $ts = sprintf('TIMESTAMPADD(MINUTE, %d, "%s")', $duration, $resDate);
        $sql = sprintf('SELECT u.id, u.name, u.sex, u.phone, u.image FROM qr_user u
                WHERE !u.deleted AND u.shop_id=%d AND u.id NOT IN 
                (SELECT DISTINCT staff_id FROM qr_reservations 
                    WHERE shop_id=%d AND (("%s" BETWEEN arr_time AND dep_time) OR (%s BETWEEN arr_time AND dep_time))
                )', $shopId, $shopId, $resDate, $ts);
        
        $rows = ORM::for_table($this->tblPre . 'user')
                        ->raw_query($sql)->find_many();  
        $itemCount = count($rows);
        if(!$itemCount){
            $this->showStaff(array('id'=>'0', 'name' => 'Anyone', 'image' => 'default_user.png'));
            return;
        }
        $this->showStaff(array('id'=>'0', 'name' => 'Anyone', 'image' => 'default_user.png'));
        $staffs = 0; 
        if($rows){
            foreach($rows as $row){
                $staffName = $row['id'] . '. ' . $row['name'];
                $this->showStaff($row);
            }
        }        
    }//findFreeStaffByTime

    public function verifyC6stInfo(){
        $data = unserialize($_SESSION['BOOKING_TMP_RECORD']);
        $name = CRequest::getStr('name');
        $phone = CRequest::getStr('phone');
        $email = CRequest::getStr('email');

        if(!$name || !$phone || !CRequest::validateEmail($email)){
            die('-505ERR');
        }

        $customer = array('name' => $name, 'phone' => $phone, 'email' => $email);
        $data['customer'] = $customer;
        $this->_saveBookingRecord($data);
    }

    public function c0mpl3teR3serv2tion(){
        $payment = CRequest::getNbr('p2ym3nt');
        $data = unserialize($_SESSION['BOOKING_TMP_RECORD']);
        $data['payment'] = $payment;
        $data = (object)$data;
        $now = date('Y-m-d H:i:s');

        $clientId = $this->findCli3ntBy3mail($data->customer['email'], 0);

        if(!$clientId){
            $client = ORM::for_table($this->tblPre.'customers')->create();
            $client->shop_id = $data->shop_id;
            $client->name   = $data->customer['name'];
            $client->phone  = $data->customer['phone'];
            $client->email  = $data->customer['email'];
            $client->created_at = $now;
            $client->updated_at = $now;
            $client->last_activity = $now;
            $client->save();
            $clientId = $client->id();
        }else{
            $client = ORM::for_table($this->tblPre.'customers')->where('shop_id', $data->shop_id)->find_one($clientId);
            $client->set('name', $data->customer['name']);
            $client->set('phone', $data->customer['phone']);            
            $client->updated_at = $now;
            $client->last_activity = $now;
            $client->save();
        }

        if(!$clientId){
            echo json_encode(array('status' => 0, 'error' => '{ADD_CLIENT_RECORD_ERROR}'));
            return;
        }

        $reserv = ORM::for_table($this->tblPre.'reservations')->create();
        $reserv->shop_id = $data->shop_id;
        $reserv->staff_id = $data->staff;
        $reserv->client_id = $clientId;
        $reserv->service_ids = $data->sids;
        $reserv->res_date = $now;
        $reserv->arr_time = $data->date.' '.$data->bookTime;
        //$reserv->dep_time = $data->date.' '.$data->bookTime;
        $reserv->duration = $data->duration;
        $reserv->service_amount = $data->subAmt;
        //$reserv->payment_date = '';
        $reserv->payment_type = $data->payment;
        $reserv->status = 0;
        
        $error = '';
        $reserv->save();
        if(!($reservId = $reserv->id())){
            $error = '{ADD_RESERVATION_RECORD_ERROR}';
            //$client->delete();
        }else{
            $sql = "UPDATE {$this->tblPre}reservations SET dep_time=TIMESTAMPADD(MINUTE,{$reserv->duration},'{$reserv->arr_time}') WHERE id={$reservId}";
            ORM::get_db()->prepare($sql)->execute();
        }
        echo json_encode(array('status' => $reservId ? 1 : 0, 'error' => $error));
    }

    private function showStaff($row){
        $staffName = $row['id'] . '. ' . $row['name'];
        ?>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6" style="padding:2px 4px;">
            <label class="btn" style="display:table;width:100%;background:#f5f5f5;border:1px solid #ddd;">
                <input type="radio" name="staffs" value="<?php echo $row['id']?>" data-name="<?php echo $row['name']?>">
                <img src="./storage/profile/<?php echo $row['image']?>" style="width:40px;height:40px;border-radius:50%;vertical-align:middle;"/>
                <div style="display:table-cell;text-align:left;vertival-align:middle;width:70%;"><b><?php echo $staffName; ?></b></div>
            </label>
        </div>
        <?php
    }//showstaff

    private function checkOpenCloseHourRange($shopId, $resDate, $dayOfWeek, $timeIn, $duration=0){
        $sql = sprintf('SELECT COUNT(*) AS items FROM qr_open_close_hour WHERE shop_id=%d AND day_of_week="%s" AND "%s">NOW() 
                        AND (("%s" between open_hour and close_hour) OR if(open_hour_2 is not null, "%s" between open_hour_2 and close_hour_2, 1))',
                       $shopId, $dayOfWeek, $resDate, $timeIn, $timeIn);
        
        $rows = ORM::for_table($this->tblPre . 'open_close_hour')
                        ->raw_query($sql)->find_many();
        return $rows[0]['items'];
    }//checkOpenCloseHourRange

    private function _buildStaffsConditionBySpec($specIds, $tbl = 'u'){
        if(!$specIds) return '';
        $theids = explode(',', $specIds);
        $cond = '';
        if(($count = count($theids)) > 1){
            $idx = 0; $preId = -1;
            foreach($theids as $id){
                if($preId==$id) continue;
                $preId = $id;
                if($idx && $idx<$count) $cond.= ' AND ';
                $cond .= sprintf('INSTR(%s.spec_ids,%d)', $tbl, $id);
                ++$idx;
            }
            $cond = ' AND ('.$cond.')';

        }else{
            if($specIds) $cond = sprintf(' AND INSTR(%s.spec_ids,%d)', $tbl, $specIds);
        }
        return $cond;
    }

    private function _saveBookingRecord($data){        
        $_SESSION['BOOKING_TMP_RECORD'] = serialize($data);
    }

    private function _getBookingRecord(){
        if(isset($_SESSION['BOOKING_TMP_RECORD'])) return unserialize($_SESSION['BOOKING_TMP_RECORD']);
        return 0;
    }

    public function findCli3ntBy3mail($email = '', $echoResult = 1){
        $email = !empty($email) ? $email : CRequest::getStr('em');        
        $data = unserialize($_SESSION['BOOKING_TMP_RECORD']);        
        $sql = "SELECT id, name, phone, deleted FROM {$this->tblPre}customers WHERE email='{$email}' AND shop_id={$data['shop_id']}";
        $rows = ORM::for_table($this->tblPre . 'customers')->raw_query($sql)->find_one();
        if($rows){
            $found = 1;
            if($rows['deleted']){
                ORM::get_db()->prepare("UPDATE qr_customers SET deleted=0 WHERE id={$rows['id']}")->execute();                
            }
            if($echoResult) echo json_encode(array('found'=>$found, 'name'=>$rows['name'], 'phone'=>$rows['phone']));
            return $rows['id'];
        }else{
            if($echoResult) echo json_encode(array('found'=>0));
        }
        return 0;
    }
}//class
?>