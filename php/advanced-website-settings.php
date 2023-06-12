<?php
if(!checkloggedin()){
    headerRedirect($link['LOGIN']);exit;
}
if(isEmployer()){
    headerRedirect('./reservations'); exit;
}

$templateName = 'advanced-website-settings.tpl';
$shopID = $_SESSION['user']['shop_id'];

$customCss = '<link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?v={VERSION}&t=' . date('ymdhis') . '">              
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css" />
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/flaticon/flaticon.css" />
              <style>
                /*fix caret css isse*/
                .dropup .dropdown-toggle::after,.dropdown-toggle::after{display: none;}
                .dashboard-nav-inner ul li a{font-weight: normal;
                    font-family: Barlow Semi Condensed,nunito, helveticaneue, helvetica neue, Helvetica, Arial, sans-serif;}
                .dashboard-nav-inner ul li a:hover{text-decoration: none;}
                .dashboard-nav-inner ul li a svg.svg-dashboard-nav {top:6px !important;}
                .user-menu-small-nav li a svg.svg-dashboard-nav-small{position:relative;top:-2px;}
            </style>    ';

$addCss = 'a.flat-icon-wrap{margin:1px;height:32px;width:36px;display:inline-block;}     
i.flat-icon{    
    width:100%;
    margin:2px;
    min-width:36px;
    height:32px;
    display:block;
    border:1px solid #EEE;
    border-radius: 4px;    
    text-align:center;
    position: relative;    
    font-style:normal;
}
i.flat-icon:after{
    font-family: "Flaticon";
    position: absolute;
    left: 0px;
    top: 2px;
    width: 100%;
    height: 25px;
    font-size: 25px;
    color: var(--classic-color-1);
    line-height: 25px;
    opacity: 1;
    font-weight: 400;        
    transition: all 500ms ease;
}

i.flat-icon:hover{background: var(--classic-color-0_5);}
i.flat-icon.active, i.flat-icon.active:hover{background: var(--classic-color-1) !important;}
i.flat-icon.active:after, i.flat-icon:hover:after{
    color: #FFF !important;
}';

$iconCss = '';
for($i = 256; $i<=300; ++$i){
    $hex = dechex($i);
    $iconCss .= " i.flat-icon.icon-{$i}:after{ content: '\\f{$hex}';} ";
}

$customCss = $customCss . "<style>" . $addCss . $iconCss . "</style>";

$page = new HtmlTemplate ("templates/{$config['tpl_name']}/{$templateName}");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['ADVANCED_SETTINGS']));
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss); //css files
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));//for css anf js files, prevent caching

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);

$page->SetParameter('SHOP_THEME_COLOR', get_shop_option($shopID, 'shop_theme_color', $config['theme_color']));
$page->SetParameter('SHOP_FORE_COLOR',  get_shop_option($shopID, 'shop_fore_color', '#ffffff'));

$page->CreatePageEcho(0);
?>