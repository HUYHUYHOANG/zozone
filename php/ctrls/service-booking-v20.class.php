<?php
defined("LPCTSTR_TOKEN") or die(":-((");

require_once("ctrls/booking-cart.class.php");

class CServiceBookingV20{    
    const PAYMENT_ACCESS_TOKEN = "PAYMENT_ACCESS_TOKEN";
    private $tblPre;
    private $shopId=0;
    private $cart = 0;

    private $showStaffSettting = 0;
    private $bookableStaffs = 1;

    public function __construct($tblPre){
        $this->tblPre = $tblPre;
        /*$timezone = isset($_SESSION['DEFAULT_TIME_ZONE']) ? $_SESSION['DEFAULT_TIME_ZONE'] : 'Europe/Berlin';
        date_default_timezone_set($timezone);*/
        //date_default_timezone_set('Europe/Berlin');
        $this->shopId = $_SESSION['SHOP_ID'];

        $this->showStaffSettting = $this->getShopOtion('booking_show_staffs_list', 0);
        $this->bookableStaffs = $this->getShopOtion('booking_total_bookable_staffs', 1);
        
        $this->cart = new TheBookingC2rt($this->shopId);
    }

    public function add2cart(){
        global $config;

        $id = CRequest::postStr('item');
        $json = new stdClass;
        $json->error = 0;
        $json->msg = '';

        if($id<=0){
            $json->error = 1;
            echo json_encode($json);
            return 0;
        }

        $sql = "SELECT id, name, service_duration, translation, is_discount, IF(discount_price, discount_price, price) AS price, IF(discount_price, price - discount_price, 0) AS discount_price FROM qr_menu WHERE id={$id}";
        $item = ORM::forTable('')->rawQuery($sql)->findOne();
        if(!$item){
            $json->error = 1; $json->msg = 'NOT FOUND';
            echo json_encode($json);
        }
        
        $item = (object)$item;
        $langCode = CRequest::postStr('langCode');
        if(!$langCode){
            $langCode = isset($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : (isset($config['lang_code']) ? $config['lang_code'] : 'de');
        }

        $json2 = json_decode($item->translation);
        if(isset($json2->$langCode->title)) $name = $json2->$langCode->title;
        else $name = $item->name;
        $data = array('id'=> $item->id, 'name' => $name, 'duration' => $item->service_duration, 'price' => $item->price, 'discount' => $item->discount_price);
        $this->cart->add($id, $data);

        $totalDuration = 0; $subAmt = 0;
        foreach($this->cart->items as $item){
            $subAmt += $item['price'];
            $totalDuration += $item['duration'];
        }
        
        $json->items = $this->cart->count();
        $json->subAmt = number_format($subAmt, 2, '.', ',') . '&euro;';
        $json->totalDuration = $totalDuration;
        $json->error = $json->items ? 0 : 1;
        echo json_encode($json);
    
    }

    public function removeC2rtItems(){
        $id = CRequest::postNbr('item');
        $this->cart->remove($id);

        $totalDuration = 0; $subAmt = 0;
        foreach($this->cart->items as $item){
            $subAmt += $item['price']; 
            $totalDuration += $item['duration'];
        }
        
        $json = new stdClass;
        $json->error = 0;        
        $json->items = $this->cart->count();
        $json->subAmt = number_format($subAmt, 2, '.', ',') . '&euro;';
        $json->totalDuration = $totalDuration;
        $json->error = $json->items ? 0 : 1;

        echo json_encode( $json );
    }

    public function getTotalDuration(){
        $totalDuration = 0;
        foreach($this->cart->items as $item){
            $totalDuration += $item['duration'];
        }
        return $totalDuration;
    }

    public function getC2rtItems(){
        echo json_encode( array( 'count' => $this->cart->count, 'items' => array_values($this->cart->items)) );
    }

    public function listTimeSlots(){
        $tolerance = 5;
        $startDate = CRequest::postStr('dt');
        $staffId = CRequest::postNbr('staff');
        
        $this->_buildTimeSlots($startDate, $staffId);
    }

    private function &loadStaffsList($staffId=0, $date=null){
        $sql = "SELECT DISTINCT u.id, u.name, u.image FROM qr_user u WHERE u.shop_id={$this->shopId} " . ($staffId>0 ? "AND u.id={$staffId}" : "") . " AND !u.deleted ORDER BY u.id ASC";
        $rows = ORM::for_table('')->raw_query($sql)->find_many();          
        $itemCount = count($rows);
        if(!$itemCount){
            return false;
        }        
        $data = array();
        foreach($rows as $row){
            $id = $row['id'];
            $data[$id]['id'] = $id;
            $data[$id]['name'] = $row['name'];
            $data[$id]['image'] = $row['image'];
            $data[$id]['work_times'] = $date ? $this->getStaffWorkTimeSlots($id, $date) : false;
        }
        return $data;
    }

    private function &getStaffWorkTimeSlots($staffId, $date){
        $times = null;
        //BOOKING_STATUS_CONFIRMED = 2, BOOKING_STATUS_IN_SERVICE = 4
        $sql = "SELECT staff_id, arr_time, dep_time, duration, status FROM qr_reservations WHERE staff_id={$staffId} AND date(arr_time)='{$date}' AND !deleted AND (status!=1 && status!=3) order by arr_time ASC";        
        
        $rows = ORM::forTable('')->rawQuery($sql)->findMany();
        if(!$rows) return $times;
        $times = array();
        foreach($rows as $row){
            $times[] = array( 'start' => $row['arr_time'], 'end' => $row['dep_time'], 'duration' =>$row['duration'], 'status' => $row['status'] );
        }
        return $times;
    }

    private function _buildTimeSlots($startDate, $staffId=0){        
        $shopId = $this->shopId;
        $duration = 0;
        $today = new DateTime(date("m/d/Y"));
        $d = new DateTime($startDate);        
        $availableSlots = 0; $naSlots = 0;        
        $avaiDates = array();        

        for($i=1; $i<=1; ++$i){            
            $hours = 0; $closeHour = ''; $startHour = '';
            if($i==1 && $today==$d){
                $startHour = date('H:00');
            }
            if($closeHour = $this->_getHourRanges($shopId, $d->format('l'), $startHour, $hours)){                                                
                $avaiDates[] = array('dow' => $d->format('l'), 'displayDate' => $d->format('l, F d'), 'date' => $d->format('Y-m-d'), 'closeHour'=>$closeHour, 'hours' => $hours);
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

        if($this->showStaffSettting){
            $staffsList = $this->loadStaffsList($staffId, $startDate);
            if(!$staffsList) return;        
            foreach($staffsList as $staff){
                $this->showTimeSlots($avaiDates[0]['hours'], $staff['id'], $staff['name'], $startDate, $staff['work_times']);
            }
        }else{            
            //SHOWING STAFF IS TURN OFF, SO WE JUST GET ONLY 1 TIME TABLE
            global $lang;
            $this->showTimeSlots(isset($avaiDates[0]) ? $avaiDates[0]['hours'] : false, $staffId, $lang['TIME'], $startDate);
        }//        
    }//_buildTimeSlots

    private function showTimeSlots($hours, $staffId, $headerText, $startDate, $aStaffWorkTimes=false){
        echo sprintf('<div><div class="row staff-timeslot-wrap"><div class="col-12 staff-header"><a class="btn no-click">%s</a></div>', $headerText);        
        if(isset($hours) && is_array($hours)){
            $count = count($hours);
            $colClass = 'col-xl-1';
            switch($count){
                case 1: $colClass = 'col-xl-12'; break;
                case 2: $colClass = 'col-xl-6'; break;
                case 3: $colClass = 'col-xl-4'; break;
                case 4: $colClass = 'col-xl-3'; break;
                case 5:
                case 6: $colClass = 'col-xl-2'; break;
            }
            
            $totalDuration=$this->getTotalDuration();
            foreach($hours as $item){
                if($this->showStaffSettting)
                    $flag = $this->checkTimeSlot($aStaffWorkTimes, $item['tm'], $totalDuration);
                else 
                    $flag = $this->checkTimeSlotWithAllBookableStaffs($startDate, $item['tm'], $totalDuration);

                $disabled = $flag ? '' : 'disabled';
                $btnClass = $flag ? 'btn clickable time-slot toggle' : 'btn no-click disabled';
                echo "<div class='{$colClass} col-md-3 col-sm-4 col-4'><a href='javascript:void(0);' data-staff='{$staffId}' class='{$btnClass}' {$disabled}>{$item['tm']}</a></div>";
            }
        }else{
            global $lang;
            echo "<div class='col-12 text-center text-danger font-weight-bold' style='font-size:18px;margin:35px auto;'>{$lang['OUT_OF_SERVICE']}</div>";
        }
        echo '</div></div>';
    }

    //IF $checkMode = 1 we have to check a timeslot with all staff's bussiness hour
    //ELSE --> DO NOT CHECK
    private function checkTimeSlot($atimes, $slot, $totalDuration){
        if(!$atimes || !is_array($atimes)) return true;
        foreach($atimes as $time){
            $slot1 = date('H:i', strtotime($slot));
            $start = date('H:i', strtotime($time['start']));
            $end = date('H:i', strtotime($time['end']));

            if($slot1>=$start && $slot1<=$end){
                return ($time['status']==1 || $time['status']==2);
            }

            if($totalDuration){
                $slot2 = $this->addTime($slot, $totalDuration);                
                if(($slot2>=$start && $slot2<=$end) || ($slot<=$start && $slot2>=$end)){ 
                    return ($time['status']==1 || $time['status']==2);
                }
            }            
        }
        return 1;
    }

    //CHECK ALL TIMES SLOT WITH ALL STAFFS
    private function checkTimeSlotWithAllBookableStaffs($date, $slot, $duration){
        //$this->bookableStaffs
        /*
        SET @thedate = '2022-10-21';
        SET @slot = '2022-10-21 10:00';
        SET @duration = 60;
        SET @slotEnd = TIMESTAMPADD(MINUTE, @duration, @slot);
        SELECT r.id, r.status, r.staff_id, u.name AS staff_name, r.status, r.arr_time, r.dep_time, @slot, @slotEnd
        FROM qr_reservations r LEFT JOIN qr_user u ON r.staff_id=u.id AND u.bookable 
        WHERE r.shop_id=1 AND !r.deleted AND u.shop_id=1 AND !u.deleted AND r.status NOT IN(1,3,5) AND DATE(r.arr_time)=@thedate 
        AND (
            (@slot >= r.arr_time AND @slot < r.dep_time) OR (@slotEnd > r.arr_time AND @slotEnd < r.dep_time) OR (@slot < r.arr_time AND @slotEnd > r.dep_time)
        )
        ORDER BY r.arr_time ASC
        */
        
        $slotStart = sprintf("'%s %s'", $date, $slot);
        $slotEnd = sprintf("TIMESTAMPADD(MINUTE, %d, %s)", $duration, $slotStart);
        $sql = "SELECT COUNT(*) AS count FROM qr_reservations r 
                WHERE r.shop_id={$this->shopId} AND !r.deleted AND r.status NOT IN(1,2) AND DATE(r.arr_time)='{$date}'
                AND ( (@slot >= r.arr_time AND @slot < r.dep_time) OR (@slotEnd > r.arr_time AND @slotEnd <= r.dep_time) OR (@slot < r.arr_time AND @slotEnd > r.dep_time) )";
        
        $sql = str_replace(array('@slotEnd', '@slot'), array($slotEnd, $slotStart), $sql);
        //if($slot=='20:00') echo $sql;
        $row = ORM::forTable('')->rawQuery($sql)->findOne();
        $count = $row->count;
        
        if($count>=$this->bookableStaffs){
            return 0;
        }
        return 1;

    }//checkTimeSlotWithAllBookableStaffs

    private function addTime($time, $minutes){
        $atimes = explode(':', $time, 2);
        $addHours = intval($minutes/60);
        $addMinutes = $minutes%60;
        $atimes[0] += $addHours;
        $atimes[1] += $addMinutes;
        if($atimes[1] >= 60){
            ++ $atimes[0]; $atimes[1] = $atimes[1] % 60;
        }
        return $atimes[0].':'.$atimes[1];
    }

    private function _getHourRanges($shopId, $dayOfWeek, $startHour, &$hoursOut){
        $hours = 0;
        $hours = ORM::for_table($this->tblPre . 'open_close_hour')->where(array('shop_id' => $shopId, 'day_of_week' => $dayOfWeek))->find_one();            
        
        if(!$hours){
            return 0;
        }
        
        $closeHour = '';
        $now = false;

        if($hours['close_hour']=='00:00') $hours['close_hour'] = '24:00';
        if(!empty($hours['close_hour_2']) && $hours['close_hour_2']=='00:00') $hours['close_hour_2'] = '24:00';
        
        if(!empty($startHour)){
            $h1 = new DateTime($startHour);
            $h2 = new DateTime($hours['open_hour']);            
            if($h1 >= $h2){
                $now = $h1;
                $tmph = intval($h1->format('H'));
                if($tmph < intval($hours['close_hour'])){
                    //$hours['open_hour'] = "{$tmph}:" . $h1->format('i');
                    $hours['open_hour'] = $h1->format('H:i');
                }else{                    
                    if(!empty($hours['close_hour_2'])){
                        if($tmph < intval($hours['close_hour_2'])-1){
                            if($tmph > intval($hours['open_hour_2']))
                                $hours['open_hour'] = "{$tmph}:" . $h1->format('i');
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
            $start = $date->format('H'); $startMin = intval($date->format('i'));
            
            $end = (new DateTime($h['close_hour']))->format('H');
            $start = intval($start);
            $end = intval($end);
            if(!$end) $end = 24;
            
            if($startMin>=0 && $startMin<30){
                if($now){
                    $startMin = intval(date('i'));                    
                } 
                
                if($startMin<30){
                    $hoursOut[] = array('status'=>1, 'tm' => $start . ':' . (intval($startMin/10) . ''.($startMin%10)));                
                    $hoursOut[] = array('status'=>1, 'tm' => $start . ':30');
                }else{
                    $hoursOut[] = array('status'=>1, 'tm' => $start . ':' . (intval($startMin/10) . ''.($startMin%10)));                
                }
            }

            $endMin = (new DateTime($h['close_hour']))->format('i');
            $endMinIntval = intval($endMin);
            for($i = $start+1 ; $i < $end ; ++$i){                
                $hoursOut[] = array('status'=>1, 'tm' => $i . ':00');
                if($i<$end-1)
                    $hoursOut[] = array('status'=>1, 'tm' => $i . ':30');
                else{
                    $hoursOut[] = array('status'=>1, 'tm' => $i . ':30');
                }
            }
        }        
        return $closeHour;
    }//hour ranges    
    
    public function getVoucherReducedAmt($customerId, $voucherCode, $invoiceAmount){
        $sql = "SELECT * FROM qr_vouchers WHERE (cust_id={$customerId} OR cust_id=-1) AND code='{$voucherCode}' AND shop_id={$this->shopId} AND (status='ready') AND !deleted AND expired_date>=DATE(NOW()) AND issued_date<=DATE(NOW()) ";
        $data = ORM::forTable('')->rawQuery($sql)->findOne();

        if(!$data) return 0;

        if($data->sale_type !='price' && $data->sale_type!='percent') $data->sale_type = 'price';
        
        $reduced = 0;
        if($data->sale_type=="price"){
            if($data->value <= $invoiceAmount){
                $reduced = $data->value;
            }            
        }else{
            $reduced = ($invoiceAmount * $data->value) /100;
        } 
        return $reduced;
    }

    public function applyVouch3r(){
        $code=CRequest::postStr('code');
        if(empty($code)) return;

        global $config, $lang;
        require_once('customer-service.class.php');
        $theCustomer = new CCustomerService($this->tblPre);
        $customerId = 0;
        if($theCustomer->checkLoggedIn()){
            $customerId = $theCustomer->data->id;
        }

        $json = new stdClass;
        $json->error = 0;
        $json->message = '';

        $sql = "SELECT * FROM qr_vouchers WHERE code='{$code}' AND shop_id={$this->shopId} AND (status='ready') AND !deleted AND expired_date>=DATE(NOW()) AND issued_date<=DATE(NOW()) ";
        if($customerId){
            $sql .= " AND (cust_id={$customerId} OR cust_id=-1)";
        }else $sql .= " AND cust_id=-1 ";

        $data = ORM::forTable('')->rawQuery($sql)->findOne();
        //$json->query = $sql;
        if($data){
            $amt = floatval(CRequest::postStr("sub-amt"));
            $json->code = $data->code;
            $json->type = $data->sale_type;
            $json->value = $data->value;
            $error = 0;
            if($amt>0){
                if($data->sale_type !='price' && $data->sale_type!='percent') $data->sale_type = 'price';
                if($data->sale_type=="price"){
                    if($data->value > $amt){
                        $error = 1;
                    }else{
                        $reduced = $data->value;
                    }
                    
                }else{
                    $reduced = $amt * ($data->value/100);
                } 
                if(!$error){
                    $amt -= $reduced;
                    $json->subAmt = $amt;
                    $json->recuded = $reduced;
                    $json->currency = $config['currency_sign'];
                    $json->recudeFormat = ' - ' . number_format($reduced, 2, '.', '') . ' '. $json->currency;
                    $json->amtFormat = number_format($amt, 2, '.', '') . ' '. $json->currency;
                }else{
                    $json->error = 1; 
                    $json->message = $lang['VOUCHER_VALUE_LESS_THAN_AMT'];
                }
            }
        }else{
            $json->error = 1; $json->message = $lang['INVALID_VOUCHER_CODE'];

        } 
        echo json_encode($json);
    }

    public function addBooking(&$customer, &$bookingData, &$returnObj, &$theCustomerObj){
        global $config, $lang;        
        $error = 0; $message = '';
        $payment = CRequest::postStr('payment-type');
        $date = CRequest::postStr('date');
        $time = CRequest::postStr('time');
        $staffId = CRequest::postNbr('staff-id');
        $returnObj->message_3434 = "777";
          
        $startDate = DateTime::createFromFormat('m/d/Y', $date);
        if($startDate){
            $date = $startDate->format('Y-m-d') . ' ' . $time;            
        }else{
            ++$error;
            $message = $lang['INVALID_DATE'] . " " . $startDate . ' ' . $time;
        }

        if(!$error){
            $amt = 0; $duration = 0; $ids = array();
            foreach($this->cart->items as $item){
                array_push($ids, $item['id']);
                $amt += $item['price'];
                $duration += $item['duration'];
            }            

            $sql = '';
            if(!$this->checkAvailableTimeSlotOfStaff($staffId, $date, $duration, $sql)){
                ++$error; 
                $message = sprintf($lang['TIME_NOT_AVAILABLE'], $date);                
            }
        }
        
        if(!$error){

            $voucher = CRequest::postStr('vcc');
            $theday = new DateTime($date);            
            $insertData = ORM::for_table($this->tblPre.'reservations')->create();

            $insertData->shop_id = $this->shopId;
            $insertData->staff_id = $staffId;
            $insertData->client_id = $customer->id;
            $insertData->service_ids = implode(',', $ids);
            $insertData->res_date = date('Y-m-d H:i:s');
            $insertData->arr_time = $date;
            $insertData->dep_time = $theday->add(new DateInterval('PT' . $duration . 'M'))->format('Y-m-d H:i:s');
            $insertData->duration = $duration;
            $insertData->service_amount = $amt;
            
            //updated at 2022-10-20, 09:18 AM
            //add 2 fields in reservations table
            $insertData->recuded_amount = $this->getVoucherReducedAmt($customer->id, $voucher, $amt);
            $insertData->voucher = $voucher;
            //end updated

            $insertData->payment_type = $payment;
            $insertData->status = 0; //pending            
            
            $returnObj->payment = $payment;
            $insertData->save();            
            if($id = $insertData->id()){
                //add voucher transaction                
                if(!$this->addVoucherTransaction($id, $customer->id, $voucher)) $voucher = '';
                $message = $lang['BOOKING'] . ' '. $lang['SUCCESSFUL'];
                
                //send booking email
                $theCustomerObj->sendBookingEmail($this->buildCartContent($customer, $voucher, $payment, $amt, $insertData->recuded_amount, $date));

             
                
                //$this->prepareDataForOnlinePayment($id, $amt, $customer, $voucher, $payment, $returnObj);

                if($payment=='paypal'){
                    $this->prepareDataForOnlinePayment($id, $amt, $customer, $voucher, $payment, $returnObj);
                }
                if (get_shop_option($this->shopId, 'quickorder_enable', 0)) {
                        $whatsapp_number = get_shop_option($this->shopId, 'whatsapp_number');      
                        $whatsapp_message = 'Buchungsdetails' . "\n";
                        $today = date("m-d-Y H:i A");
                        $serviceDate = date("m-d-Y H:i A", strtotime($date));
                        $whatsapp_message .= "Datum: " . $serviceDate . "\n";
                        $rows = '';
                        $totalDuration = 0; $subAmt = 0; $idx = 1;          
                        foreach($this->cart->items as $item){
                            $subAmt += $item['price'];
                            $totalDuration += $item['duration'];        
                            $itemPrice = number_format($item['price'], 2, '.', ',');
                            $row = $item['name'] . '(' . $item['duration'] . ')' . ':' . $itemPrice . "\n";
                            $rows .= $row;
                            ++$idx;
                        }
                        $whatsapp_message .= $rows;
                        $totalAmount = $amt - $insertData->recuded_amount;                     
                        $footer = "";                          
                        if($voucher && $insertData->recuded_amount){
                            $str = number_format($insertData->recuded_amount, 2, '.', ',');
                            $footer = "Gutschein: " . $voucher . '( -' . $str . ')' . "\n";                     
                        }

                        $str = number_format($totalAmount, 2, '.', ',');
                        $footer .= "Gesamt: " . $totalDuration . '(' . $str . ')';
                        $whatsapp_message .= $footer;    
                        $whatsApp_url = 'https://api.whatsapp.com/send?phone=' . $whatsapp_number . '&text=' . urlencode($whatsapp_message);                          
                }

            }else{
                ++$error;
                $message = $lang['RESERVATION_ERROR_MSG'];
            }            
        }
        //clean up cart
        $this->cart->clear();

        $returnObj->error = $error;
        $returnObj->message = $message;
       // $returnObj->whatsApp_url = json_encode($whatsApp_url);
        return $error = 0;

    }

    private function checkAvailableTimeSlotOfStaff($staffId, $arrTime, $duration, &$outStr){
        /*
        SET @dt = '2022-10-27 08:30:00';
        SET @tolerance = 5;
        SET @drt = 90 - @tolerance;
        SET @ts = TIMESTAMPADD(MINUTE, @drt, @dt);
        */
        if($this->showStaffSettting){
            $sql = "SELECT id, staff_id, arr_time, dep_time, status, @ts 
                    FROM qr_reservations WHERE !deleted AND staff_id={$staffId} AND DATE('@dt')=DATE(arr_time)
                    AND status NOT IN (1,3,5) 
                    AND ( '@dt' BETWEEN arr_time AND dep_time  OR @ts BETWEEN arr_time AND dep_time OR ('@dt'<=arr_time AND @ts>=dep_time))";
            $ts = "TIMESTAMPADD(MINUTE, {$duration}, '{$arrTime}')";
            $sql = str_replace(array("@dt", "@ts"), array($arrTime, $ts), $sql);       
            $row = ORM::forTable('')->rawQuery($sql)->findOne();
            $outStr = $sql;
            return isset($row['id']) ? 0 : 1;
        }else{
            $date = date('Y-m-d', strtotime($arrTime));
            $slot = date('H:i:s', strtotime($arrTime));
            return $this->checkTimeSlotWithAllBookableStaffs($date, $slot, $duration);
        }
        return 0;
    }

    private function prepareDataForOnlinePayment($bookingId, $amount, $customer, $voucherCode, $paymentType, &$jsonObj){
        /*$jsonObj->paymentType = $paymentType;
        $jsonObj->amount = $amount;
        $jsonObj->email = $customer->email;
        $jsonObj->name = $customer->name;*/        
        $accessToken = md5($bookingId . '_:_' . $customer->email);
        $_SESSION[self::PAYMENT_ACCESS_TOKEN] = $accessToken;
        $_SESSION[$accessToken] = array(
            'payment' => $paymentType, 'amount' => $amount, 'email' => $customer->email, 'name' => $customer->name, 'cust_id' => $customer->id, 'booking_id' => $bookingId, 'voucher_code'=>$voucherCode
        );

        global $link;        
        $jsonObj->redirect = CCodec::encode($link['PAYMENT'] . '/?access_token=' . $accessToken);
    }

    public function addVoucherTransaction($bookingId, $customerId, $voucherCode){
        $sql = "SELECT id FROM qr_vouchers WHERE code='{$voucherCode}' AND shop_id={$this->shopId} AND (status='ready') AND !deleted AND expired_date>=DATE(NOW()) ";
        if($customerId){
            $sql .= " AND (cust_id={$customerId} OR cust_id=-1)";
        }else return 0;

        $findVoucher = ORM::forTable('')->rawQuery($sql)->findOne();        
        if(!$findVoucher) return false;

        $trans = ORM::for_table($this->tblPre.'voucher_transactions')->create();
        $trans->shop_id = $this->shopId;
        $trans->voucher_id = $findVoucher->id;
        $trans->cust_id = $customerId;
        $trans->invoice_id = $bookingId;
        $trans->trans_time = date('Y-m-d H:i:s');
        if($trans->save()){
            //update voucher status to in-use
            $sql = "UPDATE qr_vouchers SET status='in-use' WHERE id={$findVoucher->id}";
            return ORM::get_db()->prepare($sql)->execute();
        }
        return 0;
    }

    private function getShopOtion($option, $default = null){
        $option = trim($option);
        if ( empty($option) )
            return $default;
        global $config;
        $result = ORM::for_table($this->tblPre.'shop_options')->where('option_name', $option)->where('shop_id', $this->shopId)->find_one();    
        if( isset($result['option_value']))
            return $result['option_value'];
        return $default;
    }

    private function buildCartContent($customer, $voucher, $payment, $amount, $reducedAmount, $date){
        global $lang, $config, $link;

        $html = '';
        $rows = '';
        $totalDuration = 0; $subAmt = 0; $idx = 1;
        $line = "<tr><td colspan='4' style='border-top:1px solid #EEE;'></td></tr>";

        foreach($this->cart->items as $item){
            $subAmt += $item['price'];
            $totalDuration += $item['duration'];

            $itemPrice = number_format($item['price'], 2, '.', ',');
            $row = "<tr><td style='width:30px;text-align:center'>{$idx}</td>
                        <td>{$item['name']}</td><td>{$item['duration']}</td><td>{$itemPrice}</td></tr>";
            $rows .= $row . $line;
            ++$idx;
        }

        $totalAmount = $amount - $reducedAmount;
        
        $footer = "";
        
        if($voucher && $reducedAmount){
            $str = number_format($subAmt, 2, '.', ',');
            $footer = "<tr><td></td><td colspan='3' style='text-align:right;'>{$str}</td></tr>";
            $str = number_format($reducedAmount, 2, '.', ',');
            $footer .= "<tr><td></td><td>" . $lang['VOUCHER'] . " : {$voucher}</td><td style='text-align:right;'>- {$str}</td></tr>";
        }

        $str = number_format($totalAmount, 2, '.', ',');
        $footer .= "<tr><td></td><td>" . $lang['TOTAL'] . "</td><td>{$totalDuration}</td><td style='text-align:right;'>{$str}</td></tr>";

        $today = date("m-d-Y H:i A");
        $serviceDate = date("m-d-Y H:i A", strtotime($date));        

        $html = "<table width='100%' border='0' style='border:1px solid #DDE;font-family:Tahoma,Arial'>
                    <thead><tr><td colspan='2'>" . $lang['BOOKING'] . " : " . $today . "</td><td colspan='2' style='text-align:right;'>{$lang['DATE']}: {$serviceDate}</td></tr>{$line}</thead>"
                . "<tr style='background-color:#EEE;min-height:26px;'><td>#</th><td>" . $lang['SERVICE'] . "</td><td>{$lang['DURATION']} ({$lang['MINUTES']})</td><td>" . $lang['PRICE'] . " (&euro;)</td></tr>" . $line
                . "<tbody>" . $rows . $footer . "</tbody></table>";
        return $html;
    }
}//class
?>