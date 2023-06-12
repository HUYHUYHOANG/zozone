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
require_once('php/ctrls/lib/pagination.lib.php');

$templateName = 'vouchers.tpl';
$shopID = $_SESSION['user']['shop_id'];
$do = CRequest::getStr('d0');
$voucherID = 0;

if(!empty($do)){
    require_once('php/ctrls/bo/vouchers-ctrl.class.php');
    $redirect = 0; $result = 0; $error = 0;
    $ctrl = new CVouchersCtrl($config, $shopID);
    switch($do){
        case 'add-voucher':
            break;
        case 'edit-voucher':
            $voucherID = CRequest::getNbr('id');            
            if(!$ctrl->model->getVoucher($voucherID)) $redirect = 1;
            else{
                if($ctrl->model->data['deleted'] || in_array($ctrl->model->data['status'], array('in-use','used'))) $redirect = 1;
            }
            if($redirect){
                header('Location:./vouchers'); exit;
            }
            $templateName = $do . '.tpl';
            break;
        case 'view-pdf-with-qr-codes':            
            $ctrl->downloadPDFWithQRCode();
            exit;
        case 'save-voucher':
        case 'generate-vouchers':
            $result = $ctrl->handlePostAction($do, $redirect, $error);
            if(!$result){
                if($redirect){
                    header('Location:./vouchers'); exit;
                }
            }
            echo json_encode($error);
            exit;
        default: break;
    }
}


$customCss = '<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/datepicker/css/bootstrap-datetimepicker.min.css">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/plugins/bootstrap/css/bootstrap.min.css" />
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css" />';


$page = new HtmlTemplate ("templates/{$config['tpl_name']}/{$templateName}");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['VOUCHERS']));
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss); //css files
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));//for css anf js files, prevent caching

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('THE_VOUCHER_ID', $voucherID);

$page->CreatePageEcho(1);
?>