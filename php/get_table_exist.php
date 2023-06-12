<?php
require_once('../includes/config.php');
require_once('../includes/sql_builder/idiorm.php');
require_once('../includes/db.php');
require_once('../includes/classes/class.template_engine.php');
require_once('../includes/classes/class.country.php');
require_once('../includes/functions/func.global.php');
require_once('../includes/functions/func.sqlquery.php');
require_once('../includes/functions/func.users.php');
require_once('../includes/functions/func.customers.php');
require_once('../includes/lang/lang_'.$config['lang'].'.php');
require_once('../includes/seo-url.php');
sec_session_start();
require_once('../includes/seo-url.php');
if(isset($_POST["action"])) {
    if($_POST['action'] == "getTableExist")
    {
        if($_POST['slug'] == "admin")
        {
            if (!checkloggedin()) {
                die(json_encode($result));
            }
             $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
                    ->where('user_id', $_SESSION['user']['id'])
                    ->find_one();
        }
        else
        {
            $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('slug', $_POST['slug'])
            ->find_one();
        }
   
        
       $table = ORM::for_table($config['db']['pre'] . 'booking_table')
      ->raw_query("SELECT * FROM ". $config['db']['pre']  ."booking_table  WHERE ((date_from < :datefrom and date_to > :datefrom) OR (date_from < :dateto and date_to > :dateto))  AND restaurant_id = :res_id AND status NOT IN ('completed', 'cancelled', 'missed')", array('datefrom' => $_POST['from'],'dateto' => $_POST['to'],'res_id' => $restaurant->id))->find_many();  
        $arTable= array();
        array_push($arTable,'9999999');
        foreach ($table as $info) 
        {
            array_push($arTable,$info->table_number);
        }
          $table = ORM::for_table($config['db']['pre'] . 'booking_table')
        ->raw_query("SELECT * FROM ". $config['db']['pre']  ."booking_table  WHERE (date_from >= :datefrom and date_to <= :dateto)  AND restaurant_id = :res_id AND status NOT IN ('completed', 'cancelled', 'missed')", array('datefrom' => $_POST['from'],'dateto' => $_POST['to'],'res_id' => $restaurant->id))->find_many(); 
        foreach ($table as $info) 
        {
            if(in_array($info->table_number ,$arTable) == false)
                array_push($arTable,$info->table_number);
        }
       $table_exits = ORM::for_table($config['db']['pre'] .'table')
       ->where('restaurant_id', $restaurant->id)
       ->where_gte('seat_number', $_POST['ticket'])
       ->where_not_in('table_number', $arTable)->find_many();
    $table_tlp = '';
  
  
    foreach ($table_exits as $info_table) {
    $table_tlp .= '<li> <div data-table-number="'. $info_table['table_number'] .'" class="table-element"><figure><img src="templates/restro-theme/images/table.png"/></figure><p>'. $info_table['table_number'] .'</p></div> </li>';
    }
    if(empty($table_tlp))
    {
        $result['success'] = false;
        $result['message'] = $lang['OUT_OF_TABLE'];
        die(json_encode($result));
    }
    $result['success'] = true;
    $result['message'] = $table_tlp;
    die(json_encode($result));
    }
    else
    {
        $result['success'] = false;
        $result['message'] = $lang['ERROR_TRY_AGAIN'];
        die(json_encode($result));
    }
}else die("oooop..");


?>