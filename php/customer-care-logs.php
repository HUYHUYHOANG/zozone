<?php
if(!checkloggedin()){
    headerRedirect($link['LOGIN']);exit;
}

///print_r($config); die;

require_once('php/ctrls/lib/pagination.lib.php');
require_once('php/ctrls/lib/request.lib.php');
require_once('php/ctrls/bo/base.class.php');
require_once('php/ctrls/bo/customer-care-log-ctrl.class.php');

$shopID = $_SESSION['user']['shop_id'];
$ctrl = new CCustomerCareLogCtrl($config, $shopID);
$template = 'customer-care-logs.tpl';
$action = CRequest::getStr('d0');
$logsData = false;
if($action=='send-message') $template = 'customer-care-send-message.tpl';
else{
    $logsData = $ctrl->loadTheLogs(0,0);
}

$customCss = '<link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/css/bootstrap-datetimepicker.min.css">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/css/bootstrap.min.css" />
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/ccl-styles.css" />
              <style>
                /*fix caret css isse*/
                .dropup .dropdown-toggle::after,.dropdown-toggle::after{display: none;}
                .dashboard-nav-inner ul li a{font-weight: normal;
                    font-family: Barlow Semi Condensed,nunito, helveticaneue, helvetica neue, Helvetica, Arial, sans-serif;}
                .dashboard-nav-inner ul li a:hover{text-decoration: none;}
                .dashboard-nav-inner ul li a svg.svg-dashboard-nav {top:0px}
                .user-menu-small-nav li a svg.svg-dashboard-nav-small{position:relative;top:-2px;}
            </style>    ';


$page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/' . $template);

$page->SetParameter ('OVERALL_HEADER', create_header($lang['BO_MENU_CUSTOMER_CARE']));
//css files
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss);
//for css anf js files, prevent caching
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter ('LIST_LOGS_STATUS', $ctrl->view->getLogStatus());
$page->SetParameter ('LIST_LOGS_DATA', $logsData);
$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('READONLY_PERMISSION', CBoCtrl::getUserType()==EMPLOYER ? 1 : 0);
$page->SetLoop ('CCL_STATUS', $cclStatus);
$page->CreatePageEcho(1);
?>