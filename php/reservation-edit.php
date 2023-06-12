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
$bookingID = CRequest::getNbr("id");

$customCss = '  <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/css/bootstrap.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css?t="' . date('ymdhis') . '>                
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/calendar/main.min.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?t="' . date('ymdhis') . '>
                <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/reservations-calendar.css?t="' . date('ymdhis') . '>';                

$page = new HtmlTemplate ("templates/{$config['tpl_name']}/reservation-edit-ios.tpl");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['RESERVATIONS']));    

//css files
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss);
//for css anf js files, prevent caching
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('TODAY_DATE_RANGE', sprintf('%s - %s', date('M 01, Y'), date('M d, Y')));

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('READONLY_PERMISSION', CBoCtrl::getUserType()==EMPLOYER ? 1 : 0);

$page->SetParameter('THE_ID', $bookingID);

$page->CreatePageEcho(0);
?>