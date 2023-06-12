<?php
if(checkloggedin())
{    
    if($_SESSION['user']['user_type'] == 'employer'){
        headerRedirect('./reservations'); exit;
    }
    
    CSysTools::fixDB();
    
    $start = date('Y-m-01');
    $end = date('Y-m-t');

    $days = $scans = [];
    $total_scans = $total_categories = $total_menus = $pending_orders = 0;

    $period = new \DatePeriod( date_create($start), \DateInterval::createFromDateString( '1 day' ), date_create($end) );
    /** @var \DateTime $dt */
    foreach ( $period as $dt ) {
        $days[] = date('d M', $dt->getTimestamp() );
        $scans[date('d M', $dt->getTimestamp() )] = 0;
    }

    $shop_id = $_SESSION['user']['shop_id'];
    
    $shop = ORM::for_table($config['db']['pre'].'shop')
        ->where('id', $shop_id)
        ->find_one();
    
    if(isset($shop['id'])) {
        $sql = "SELECT DATE(arr_time) AS created, COUNT(1) AS scans FROM {$config['db']['pre']}reservations WHERE !deleted AND shop_id = {$shop['id']} AND DATE(arr_time) BETWEEN '{$start}' AND '{$end}' GROUP BY DATE(arr_time)";        
        $result = ORM::for_table($config['db']['pre'] . 'reservations')
            ->raw_query($sql)
            ->find_many();

        foreach ($result as $data) {
            $scans[date('d M', strtotime($data['created']))] = $data['scans'];
        }

        $month = date('m');
        $sql = "SELECT COUNT(*) AS items FROM {$config['db']['pre']}reservations WHERE !deleted AND shop_id={$shop['id']} AND MONTH(arr_time)={$month}";
        $row = ORM::for_table($config['db']['pre'].'reservations')->raw_query($sql)->find_one();
        if($row) $total_scans = $row->items;

        $total_menus = ORM::for_table($config['db']['pre'].'menu')->where(array('shop_id'=>$_SESSION['user']['shop_id'], 'active'=>'1'))->count();

        $ses_userdata = get_user_data($_SESSION['user']['username']);
        $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');

        // get orders
        $sql = "SELECT COUNT(*) AS items FROM {$config['db']['pre']}reservations WHERE shop_id={$shop['id']} AND status IN(0) AND !deleted";        
        $row = ORM::for_table('')->raw_query($sql)->find_one();
        if($row) $pending_orders = $row->items;
    }    
    $classic_color = get_shop_option($shop['id'], 'shop_theme_color', $config['theme_color']);

    $page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/dashboard.tpl');
    $page->SetParameter ('OVERALL_HEADER', create_header($lang['DASHBOARD']));
    $page->SetParameter ('CUSTOM_CSS_FILES', ''); //css files
    $rightMenu = '';
    
    $page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
    
    $page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
    $page->SetParameter ('SCANS', json_encode(array_values($scans)));
    $page->SetParameter ('DAYS', json_encode(array_values($days)));
    $page->SetParameter ('PENDING_ORDERS', $pending_orders);
    $page->SetParameter ('CLASSIC_COLOR', $classic_color);
    $page->SetParameter ('TOTAL_SCANS', $total_scans);
    $page->SetParameter ('TOTAL_CATEGORIES', $total_categories);
    $page->SetParameter ('TOTAL_MENUS', $total_menus);
    $page->SetParameter ('OVERALL_FOOTER', create_footer());
    $page->CreatePageEcho();
}
else{
    headerRedirect($link['LOGIN']);
}

//========================================================================================================================================
//fix expired data
//========================================================================================================================================
class CSysTools{

    public static function fixDB(){
        $go = true;
        if(isset($_SESSION['__FIX_EXPIRED_DATA__'])){
            $data = $_SESSION['__FIX_EXPIRED_DATA__'];
            $now = strtotime(date('d-m-Y h:i:s'));
            $lastScanned = strtotime($data->lastScanned);
            $go = ($now - $lastScanned) > 7200;
        }
        
        if($go){
            global $config;

            $pre = $config['db']['pre'];
            $shopID = $_SESSION['user']['shop_id'];
            $now = date('Y-m-d');
            $pdo = ORM::get_db();

            $pdo->prepare("update {$pre}languages SET deleted=1 where instr('ur, tr, th, hi, bn, ar, zh, ja, he', code) ")->execute();

            //*****************************************/
            //delete all deleted records
            //*****************************************/
            //01 - BOOKING
            $pdo->prepare("DELETE FROM {$pre}reservations WHERE deleted=1")->execute();
            
            //02 - CUSTOMERS
            $pdo->prepare("DELETE FROM {$pre}customers WHERE deleted=1")->execute();            
            //03 - CUSTOMER GROUPS
            $pdo->prepare("DELETE FROM {$pre}cust_groups WHERE deleted=1")->execute();
            //04 - CUSTOMER CARE LOGS
            $pdo->prepare("DELETE FROM {$pre}customer_care WHERE deleted=1")->execute();
            //05 - USER GROUPS
            $pdo->prepare("DELETE FROM {$pre}usergroups WHERE deleted=1")->execute();
            //06 - USERS
            $pdo->prepare("DELETE FROM {$pre}user WHERE deleted=1")->execute();
            //07 - VOUCHERS
            $pdo->prepare("DELETE FROM {$pre}vouchers WHERE deleted=1")->execute();
            //08 - UPDATE missed-duration services
            $pdo->prepare("update {$pre}_menu set service_duration=60 WHERE service_duration=0")->execute();
            

            //*****************************************/
            //SET NON-EXPIRED VOUCHERS IN THE PAST TO EXPIRED
            $sql = "UPDATE {$pre}vouchers SET status='expired' WHERE shop_id={$shopID} AND expired_date<'{$now}'";            
            $pdo->prepare($sql)->execute();

            //*****************************************/
            //UPDATE THE PAST BOOKING ReCORDS STATUS            
            //01. booking - cancelled
            $sql = "UPDATE {$pre}reservations SET status=1 WHERE !deleted AND status=0 AND shop_id={$shopID} AND arr_time<'{$now}'";
            $pdo->prepare($sql)->execute();

            //02. booking - not come
            $sql = "UPDATE {$pre}reservations SET status=3 WHERE !deleted AND status>=2 AND status<=4 AND shop_id={$shopID} AND arr_time<'{$now}'";
            $pdo->prepare($sql)->execute();

            $data = new stdClass;
            $data->lastScanned = date('d-m-Y h:i:s');
            $_SESSION['__FIX_EXPIRED_DATA__'] = $data;
        }
    }
}
?>