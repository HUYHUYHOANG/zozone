<?php
if(!checkloggedin()){
    headerRedirect($link['LOGIN']);exit;
}

require_once('php/ctrls/lib/pagination.lib.php');
require_once('php/ctrls/lib/request.lib.php');
require_once('php/ctrls/lib/codec.lib.php');
require_once('php/ctrls/bo/base.class.php');
require_once('php/ctrls/bo/message-template-ctrl.class.php');

$shopID = $_SESSION['user']['shop_id'];
$ctrl = new CMessageTemplateCtrl($config, $shopID);
$template = 'message-templates.tpl';
$action = CRequest::getStr('d0');
$logsData = false;
if($action=='edit-template'){
    $templateID = CRequest::getNbr('id');
    $templateData = 0;
    if($templateID>0){        
        $templateData = $ctrl->model->getTemplateItem($templateID);
        if(!$templateData){
            header('Location:./message-templates'); exit;
        }
    }else{
        $templateData =array('name'=>'', 'lang_code'=>'de', 'template_type'=>'', 'active'=>1, 'send_via'=>'','title'=>'','content'=>'');
    }

    $template = 'edit-message-template.tpl';    
    $templateData['lang_code'] = 'de'; //default lang code
    $templateTypes = $ctrl->model->getTemplateTypes($templateData['template_type']);
    
    $ptknKey = CBoCtrl::generateSessionKey();
    $languages = $ctrl->model->getLanguages($templateData['lang_code']);
} 
else{
    $logsData = $ctrl->loadTemplates(0,0);
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

$page->SetParameter ('OVERALL_HEADER', create_header($lang['MESSAGE_TEMPLATES']));
//css files
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss);
//for css anf js files, prevent caching
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('READONLY_PERMISSION', CBoCtrl::getUserType()==EMPLOYER ? 1 : 0);

if($action=='edit-template'){    
    $page->SetLoop('TMPL_TYPES', $templateTypes);
    $page->SetLoop('LANGUAGES', $languages);
    $page->SetParameter('PTKN_KEY', $ptknKey);
    $page->SetParameter('THE_ID', $templateID);
    $page->SetParameter('THE_NAME', $templateData['name']);
    $page->SetParameter('THE_LANG_CODE', $templateData['lang_code']);
    $page->SetParameter('THE_TYPE', $templateData['template_type']);
    $page->SetParameter('THE_SEND_VIA', $templateData['send_via']);
    $page->SetParameter('THE_TITLE', $templateData['title']);
    $page->SetParameter('THE_CONTENT', $templateData['content']);
    $page->SetParameter('THE_STATUS', $templateData['active']);
    $page->SetParameter('THE_CHECKED_STATE', $templateData['active']?'checked':'');    
}

$page->CreatePageEcho(0);
?>