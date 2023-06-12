<?php
if(!checkloggedin()){
    headerRedirect($link['LOGIN']);exit;
}

define("LPCTSTR_TOKEN", true);

require_once('php/ctrls/lib/pagination.lib.php');
require_once('php/ctrls/lib/request.lib.php');
require_once('php/ctrls/bo/reservation-ctrl.class.php');

$now = date('m-d-Y');
$shopID = $_SESSION['user']['shop_id'];

$do = CRequest::getStr('d0');
$ctrl = new CReservationCtrl($config, $shopID);

$template = "reservation-listview.tpl";

$listview = 1;

if($do){
    if($do == 'edit-booking'){

    }elseif($do == 'calenderview'){
        $listview = 0;
        $template = "reservations.tpl";
        
    }else{
        $ajax = CRequest::getStr('ajax');        
        if($ajax != true){
            header('Location:./reservations'); exit;
        }
        
        switch($do){
            case 'get-all-services-2json':
            case 'get-booking-feeds':
            case 'get-open-close-hours':
            case 'get-clients-list':
            case 'find-staffs-by-services':
                $func = str_replace('-','', $do);
                
                if(method_exists($ctrl->model, $func)){
                    $ctrl->model->{$func}();
                }        
                break;
            case 'save-booking-record':
                $redirect = 0; $error = 0;
                $result = $ctrl->handlePostAction($do, $redirect, $error);
                
                if(!$result){                    
                }                

                echo json_encode($error);
                break;
        }
        exit;
    }
}


$statuses = CReservationCtrl::getStatuses(-1);
$staffs = $ctrl->model->loadStaffs();
if($listview)
    $resvListData = $ctrl->searchReservation(0);
$dates = $ctrl->model->getDateRange();
    
    
//save common settings
$settings = new stdClass;
$settings->site_url = $config['site_url'];
$settings->lang_code = $config['lang_code'];
$settings->lang = $config['lang'];
$settings->currency_sign = $config['currency_sign'];
$settings->tpl_name = $config['tpl_name'];
$_SESSION['__CURRENT_SETTINGS__'] = $settings;

$openHours = $ctrl->model->getOpenCloseHours();

$customCss = '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/css/bootstrap.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css?t="' . date('ymdhis') . '>                
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/calendar/main.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/reservations-calendar.css?t="' . date('ymdhis') . '>';

$page = new HtmlTemplate ("templates/{$config['tpl_name']}/{$template}");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['RESERVATIONS']));    

//css files
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss);
//for css anf js files, prevent caching
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('TODAY_DATE_RANGE', sprintf('%s - %s', date('M 01, Y'), date('M d, Y')));

if($listview)
    $page->SetParameter('RESV_LIST_DATA', $resvListData);

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('SEARCH_DATES', $dates[0].'|'. $dates[1]);
$page->SetParameter('STATUSES', $statuses);
$page->SetParameter('OPEN_CLOSE_HOURS', $openHours);
$page->SetParameter('READONLY_PERMISSION', CBoCtrl::getUserType()==EMPLOYER ? 1 : 0);
$page->SetLoop('STAFFS', $staffs);
$page->CreatePageEcho(0);
?>