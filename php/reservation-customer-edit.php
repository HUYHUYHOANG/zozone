<?php

// require_once('php/ctrls/lib/pagination.lib.php');
// require_once('php/ctrls/lib/request.lib.php');
 //require_once('php/ctrls/bo/reservation-ctrl.class.php');
$now = date('m-d-Y');
$bookingID = $_GET['id'];
$reservation = ORM::for_table($config['db']['pre'] . 'reservations')
->where('id', $bookingID)->where('status',0)->find_one(); 
if(empty($reservation))
return;

$shop = ORM::for_table($config['db']['pre'] . 'shop')
->where('id', $reservation['shop_id'])->find_one();


if (!empty($_GET['service-name'])){
    $cancel_reason_text = $_GET['cancel_reason'];
    if ($cancel_reason_text == "other") $cancel_reason_text = $_GET['cancel_reason_other'];

    //start cancel booking
    $reservation_update = ORM::for_table($config['db']['pre'] . 'reservations')
      ->where('id', $bookingID)
      ->find_one();
    $reservation_update->set('status', 2);
    $reservation_update->set('cancel_reason_text', $cancel_reason_text);
    $reservation_update->save();

    $reservation = ORM::for_table($config['db']['pre'] . 'reservations')
    ->where('id', $bookingID)->find_one(); 

    $reservations_staff = "";
    if ($reservation['staff_id'] != 0){
        $staff = ORM::for_table($config['db']['pre'].'user')->find_one($reservation['staff_id']);
        $reservations_staff = $staff['name'];
    }

    //send mail
    $main_image = $config['site_url']."storage/shop/logo/".$shop['main_image'];
    $shop_telephone = $shop['phone_number'];
    $shop_address = $shop['address'];
    $shop_name = $shop['name'];

    
 
    $client = ORM::for_table($config['db']['pre'].'customers')->find_one($reservation['client_id']);
    $datum = date("d.m.Y H:i", strtotime($reservation['res_date']));
    $rabatt_code = '';
    $rabatt_cost = '';
    $payment_methoad = '';
    if (!empty($reservation['voucher'])) {
        $rabatt_code = $reservation['voucher'];
        $rabatt_cost = number_format($reservation->recuded_amount,2,',','.');
    }

    if($reservation->payment_type!='paypal'){
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
    $totalAmount = $reservation->service_amount - $reservation->recuded_amount; 
    $totalAmount = number_format($totalAmount, 2, ',', '.') . ' ( ' . $totalDuration . ' Minute)';

    $page = new HtmlTemplate($config['site_url'] . "templates/" . $config['tpl_name'] . "/template_email_reservation.tpl");
    $result = ORM::for_table('qr_shop_options')->where('option_name', 'shop_theme_color')->where('shop_id', $shop['id'])->find_one();    
    $classic_boder_color = $result['option_value'];
    $status = "Abgesagt"; // Hủy cuộc hẹn
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
    $page->SetParameter('RESERVATIONS_STATUS_CODE', 2); // none display cancel link
    $page->SetParameter("RESERVATIONS_CANCEL_REASON_TEXT", $cancel_reason_text);
    $page->SetParameter('DATE_BOOKING', $datum);
    $page->SetParameter('RABATT_CODE', $rabatt_code);
    $page->SetParameter('RABATT_COST', $rabatt_cost);
    $page->SetParameter('PAYMENT_METHOAD', $payment_methoad);
    $page->SetParameter('RESERVATIONS_DETAIL', $tpl);
    $page->SetParameter('RESERVATIONS_STAFF',$reservations_staff);
    
    $email_body = $page->CreatePageReturn($lang, $config, $link);
    $email_subject = "Termin stornieren";
   try {
    email($client['email'],$client['name'],$email_subject,$email_body);
    //send email to shop
    email($shop['email'],$shop['name'],$email_subject,$email_body);

    } catch (Exception $e) {

    }
}

$customer =  ORM::for_table($config['db']['pre'] . 'customers')
->where('id', $reservation['client_id'])->find_one();

$customer_care =  ORM::for_table($config['db']['pre'] . 'customer_care')
->where('resv_id', $reservation['id'])->find_one();
$service_ids = $customer_care['service_ids'];

$DURATION = $reservation['duration'] . ' ( ' . $lang['MINUTE'] . ')';
$AMOUNT = number_format($reservation['service_amount'],2, ',', '.');
$VOUCHER_CODE = $reservation['voucher'];
$VOUCHER_VALUE = (empty($VOUCHER_CODE) ? '' : number_format($reservation['recuded_amount'],2, ',','.'));
$RES_DATE = date('d.m.Y', strtotime($reservation['res_date']));
$START_TIME = date('d.m.Y H:i:s', strtotime($reservation['arr_time']));

$sql = "SELECT id, `name` FROM qr_menu WHERE active='1' AND id IN(". $service_ids .")";
$items = ORM::forTable('')->rawQuery($sql)->find_many();
$LIST_SERVICES = '';

foreach ($items as $item) {
    $LIST_SERVICES .=  (empty($LIST_SERVICES) ? $item['name'] : ', ' . $item['name']);
}

$customCss = '  <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/css/bootstrap.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css?t="' . date('ymdhis') . '>                
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/calendar/main.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/reservations-calendar.css?t="' . date('ymdhis') . '>';    
        

$page = new HtmlTemplate ("templates/{$config['tpl_name']}/reservation-customer-edit.tpl");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['RESERVATIONS']));    

//css files
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss);
//for css anf js files, prevent caching
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
$page->SetParameter('LIST_SERVICES' , $LIST_SERVICES);
$page->SetParameter('DURATION' , $DURATION);
$page->SetParameter('AMOUNT', $AMOUNT);
$page->SetParameter('VOUCHER_CODE', $VOUCHER_CODE);
$page->SetParameter('VOUCHER_VALUE',$VOUCHER_VALUE);
$page->SetParameter('RES_DATE', $RES_DATE);
$page->SetParameter('START_TIME', $START_TIME);
$page->SetParameter('RESERVATION_ID', $_GET['id']);
$page->SetParameter('RESERVATION_STATUS',$reservation['status']);
$page->SetParameter('TODAY_DATE_RANGE', sprintf('%s - %s', date('M 01, Y'), date('M d, Y')));

//$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('READONLY_PERMISSION', CBoCtrl::getUserType()==EMPLOYER ? 1 : 0);

//$page->SetParameter('THE_ID', $bookingID);

$page->CreatePageEcho(0);
?>