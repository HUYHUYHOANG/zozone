<?php
if(!checkloggedin()){    
    headerRedirect($link['LOGIN']);exit;
}

if(isEmployer()){
    headerRedirect('./reservations'); exit;
}

define('LPCTSTR_TOKEN', 1);
require_once('php/ctrls/lib/request.lib.php');
require_once('php/ctrls/lib/codec.lib.php');

$_SESSION['user']['site_url'] = $config['site_url'];

$shopID = $_SESSION['user']['shop_id'];
$do = CRequest::getStr('d0');
$templateName = 'staffs.tpl';
$staffID = 0;

if($do == 'save-staff'){    
    require_once('php/ctrls/bo/staffs-ctrl.class.php');
    $ctrl = new CStaffsCtrl($config, $shopID);

    $redirect = 0;
    $ajax = CRequest::getStr("ajax");
    if($ajax!=="true" || empty($_POST) || !CBoCtrl::checkSessionKey()){
        header('Location:./staffs?d0=add-staff');
        exit;
    }
    
    $err = 0;
    //$continue = CBoCtrl::keyExists('spec_ids');
    $dataValidation = $ctrl->validateParamArray($_POST, $err);
    
    if(!$dataValidation){
        $err->error = 1;        
        echo json_encode($err);
    }else{        
        $id = $ctrl->model->saveStaff($err->text);
        $err->error = $id ? 0 : 1;
        $err->field = '';
        $err->id = $id;        
        echo json_encode($err);
    }
    exit;
}

if(!empty($do)){
    switch($do){
        case 'add-staff':
        case 'edit-staff':
        case 'view-staff':
        case 'reservations':

            $staffID = CRequest::getNbr('id');
            if($do=='reservations') $templateName = "staff-reservations.tpl";
            else $templateName = "{$do}.tpl";
            $type = CRequest::getStr('t');
            $newClass = 'button disabled';
            $pastClass = 'button ripple-effect button-sliding-icon';
            if($type=='past'){
                $newClass = $pastClass;
                $pastClass = 'button disabled';
                $resvLabelText = $lang['CUSTOMER_PAST_RESERVATIONS'];
            }else $resvLabelText = $lang['CUSTOMER_NEW_RESERVATIONS'];

            if($staffID > 0 && $do != 'add-staff'){                
                require_once('php/ctrls/bo/staffs-ctrl.class.php');
                $shopID = $_SESSION['user']['shop_id'];
                $ctrl = new CStaffsCtrl($config, $shopID);
                if(!$ctrl->model->loadStaff($staffID)){
                    header('Location:./staffs');
                    exit;
                }
            }
            break;
        case 'find-staffs-by-services':
            require_once('php/ctrls/bo/staffs-ctrl.class.php');
            $shopID = $_SESSION['user']['shop_id'];
            $ctrl = new CStaffsCtrl($config, $shopID);
            $ctrl->model->findStaffsByServices();
            exit;
        case 'reservations':
            exit;
    }
}


require_once('php/ctrls/lib/pagination.lib.php');
$shopID = $_SESSION['user']['shop_id'];

$customCss = '<link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/css/bootstrap-datetimepicker.min.css">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/css/bootstrap.min.css" />
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css" />
              <style>
                /*fix caret css isse*/
                .dropup .dropdown-toggle::after,.dropdown-toggle::after{display: none;}
                .dashboard-nav-inner ul li a{font-weight: normal;
                    font-family: Barlow Semi Condensed,nunito, helveticaneue, helvetica neue, Helvetica, Arial, sans-serif;}
                .dashboard-nav-inner ul li a:hover{text-decoration: none;}
                .dashboard-nav-inner ul li a svg.svg-dashboard-nav {top:0px}
                .user-menu-small-nav li a svg.svg-dashboard-nav-small{position:relative;top:-2px;}
            </style>    ';


$page = new HtmlTemplate ("templates/{$config['tpl_name']}/{$templateName}");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['CUSTOMERS']));
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss); //css files
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));//for css anf js files, prevent caching

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('THE_STAFF_ID', $staffID);

if($staffID>0){    
    $staffInfo = isset($_SESSION['__STAFF_INFO__']) ? $_SESSION['__STAFF_INFO__'] : array('id'=>0,'name'=>'');
    $page->SetParameter('THE_STAFF_NAME', $staffInfo['name']);    
}

if(isset($newClass)){
    $page->SetParameter('BTN_NEW_CLASS', $newClass);
    $page->SetParameter('BTN_PAST_CLASS', $pastClass);
}
if(isset($resvLabelText)) $page->SetParameter('RESV_LABEL_TEXT', $resvLabelText);
$page->SetParameter('THE_RESV_TYPE', CRequest::getStr('t'));
$page->CreatePageEcho(1);
?>