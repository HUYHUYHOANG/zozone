<?php
if(!checkloggedin()){
    headerRedirect($link['LOGIN']);exit;
}
if(isEmployer()){
    headerRedirect('./reservations'); exit;
}

require_once('php/ctrls/lib/request.lib.php');
$do = CRequest::getStr('d0');
$templateName = 'customers.tpl';
$customerID = 0;

if($do == 'csv-export' || $do == 'printable-customers-list'){
    $tk = $_SESSION['user']['login_string'];

    if(isset($_GET[$tk])){
        define('LPCTSTR_TOKEN', 1);        
        require_once('php/ctrls/bo/customers-ctrl.class.php');
        
        $shopID = $_SESSION['user']['shop_id'];
        $ctrl = new CCustomersCtrl($config, $shopID);
        if($do == 'csv-export') $ctrl->csvExport();
        else{            
            ?>
            <html>
            <title><?php echo $lang['BO_MENU_CUSTOMERS'] ?></title>
            <link rel="stylesheet" type="text/css" href="<?php echo $config['site_url']?>templates/<?php echo $config['tpl_name']?>/plugins/bootstrap/css/bootstrap.min.css" />
            <link rel="stylesheet" type="text/css" href="<?php echo $config['site_url']?>templates/<?php echo $config['tpl_name']?>/css/pages/ccl-styles.css" />
            <link rel="shortcut icon" href="<?php echo "{$config['site_url']}storage/logo/{$config['site_favicon']}"?>">
            <style>
                .table td{vertical-align: middle;line-height: 26px;}
                .table th{background-color:#fafafa;}
            </style>
            <body>
                <div class="container row" style="margin:20px auto;">
                    <div class="col-lg-12 col-sm-12">
                        <?php $ctrl->printableCustomersList(); ?>
                    </div>
                </div>
            </body>
            <script type="text/javascript">
                window.print();
            </script>
            </html>
            <?php
        } 
        exit;
    }
}else{
    define('LPCTSTR_TOKEN', 1);
    switch($do){
        case 'add-customer':
        case 'edit-customer':
        case 'view-customer':
        case 'customer-reservations':
        case 'customer-vouchers':    
            $customerID = CRequest::getNbr('id');
            $templateName = "{$do}.tpl";
            $type = CRequest::getStr('t');
            $newClass = 'button ripple-effect button-sliding-icon';
            $pastClass = 'button ripple-effect button-sliding-icon';
            if($type=='past'){
                $newClass = $pastClass;
                $pastClass = 'button disabled';
                $resvLabelText = $lang['CUSTOMER_PAST_RESERVATIONS'];
            }elseif($type=='new'){
                $newClass = 'button disabled';
                $resvLabelText = $lang['CUSTOMER_NEW_RESERVATIONS'];
            }else $resvLabelText = $lang['VOUCHERS'];
            if($customerID > 0 && $do != 'add-customer'){                
                require_once('php/ctrls/bo/customers-ctrl.class.php');
                $shopID = $_SESSION['user']['shop_id'];
                $ctrl = new CCustomersCtrl($config, $shopID);
                if(!$ctrl->model->loadCustomer($customerID)){
                    header('Location:./customers');
                    exit;
                }
            }
            break;
        case 'save-customer':
            $redirect = 0;
            $ajax = CRequest::getStr("ajax");
            require_once('php/ctrls/bo/customers-ctrl.class.php');
            
            if($ajax!=="true" || empty($_POST) || !CBoCtrl::checkSessionKey()){
                header('Location:./customers');
                exit;
            }
            $shopID = $_SESSION['user']['shop_id'];
            $ctrl = new CCustomersCtrl($config, $shopID);
            $err = 0; $errText = '';
            $dataValidation = $ctrl->validateParamArray($_POST, $err);            
            if(!$dataValidation){
                $err->error = 1;        
                echo json_encode($err);
            }else{        
                $id = $ctrl->editCustomerData($errText);
                $err->error = $id ? 0 : 1;
                $err->field = '';
                $err->id = $id;
                $err->text = $errText;
                echo json_encode($err);
            }
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

//die($templateName);
$page = new HtmlTemplate ("templates/{$config['tpl_name']}/{$templateName}");
$page->SetParameter ('OVERALL_HEADER', create_header($lang['CUSTOMERS']));
$page->SetParameter ('CUSTOM_CSS_FILES', $customCss); //css files
$page->SetParameter ('JS_CSS_TIMESTAMP', date('ymdhis'));//for css anf js files, prevent caching

$rightMenu = '';
$page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
$page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);

$page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
$page->SetParameter('THE_CUSTOMER_ID', $customerID);
$page->SetParameter('THE_RESV_TYPE', CRequest::getStr('t'));


if($customerID>0){
    $custInfo = isset($_SESSION['__CUSTOMER_INFO__']) ? $_SESSION['__CUSTOMER_INFO__'] : array('id'=>0,'name'=>'');
    $page->SetParameter('THE_CUSTOMER_NAME', $custInfo['name']);
}

if(isset($newClass)){
    $page->SetParameter('BTN_NEW_CLASS', $newClass);
    $page->SetParameter('BTN_PAST_CLASS', $pastClass);
}
if(isset($resvLabelText)) $page->SetParameter('RESV_LABEL_TEXT', $resvLabelText);

$page->CreatePageEcho(1);
?>