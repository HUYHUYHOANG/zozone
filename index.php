<?php
session_start();

//sec_session_start();

// Path to root directory of app.
define("ROOTPATH", dirname(__FILE__));

// Path to app folder.
define("APPPATH", ROOTPATH."/php/");

// Check if SSL enabled
if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
    $protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https" ? "https://" : "http://";
else
    $protocol = !empty($_SERVER['HTTPS']) && $_SERVER["HTTPS"] != "off" ? "https://" : "http://";

// Define APPURL
$site_url = $protocol
    . $_SERVER["HTTP_HOST"]
    . (dirname($_SERVER["SCRIPT_NAME"]) == DIRECTORY_SEPARATOR ? "" : "/")
    . trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");

define("SITEURL", $site_url);

$config['app_url'] = SITEURL."/php/";
//$config['site_url'] = SITEURL."/";

require_once ROOTPATH . '/includes/classes/AltoRouter.php';

// Start routing.
$router = new AltoRouter();
 
$bp = trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");
$router->setBasePath($bp ? "/".$bp : "");

/* Setup the URL routing. This is production ready. */
// Main routes that non-customers see
$router->map('GET|POST','/', 'home.php');
$router->map('GET|POST','/home/[a:lang]?/?', 'home.php');
$router->map('GET|POST','/signup/?', 'signup.php');
$router->map('GET|POST','/login/?', 'login.php');
$router->map('GET|POST','/logout/?', 'logout.php');
$router->map('GET|POST','/customer-logout/?', 'customer-logout.php');
$router->map('GET|POST','/forgot/?', 'forgot.php');
$router->map('GET|POST','/transaction/?', 'transaction.php');
$router->map('GET|POST','/account-setting/?', 'account-setting.php');
$router->map('GET|POST','/contact/?', 'contact.php');
$router->map('GET|POST','/faq/?', 'faq.php');
$router->map('GET|POST','/feedback/?', 'feedback.php');
$router->map('GET|POST','/report/?', 'report.php');
$router->map('GET|POST','/add-restaurant/?', 'add-restaurant.php');
//$router->map('GET|POST','/services/?', 'services.php');
$router->map('GET|POST','/menu/[i:id]?/?', 'menu-edit.php');
$router->map('GET|POST','/qr-builder/?', 'qr-builder.php');
$router->map('GET|POST','/dashboard/?', 'dashboard.php');
$router->map('GET|POST','/webhook/[*:i]?/?', 'webhook.php');
$router->map('GET|POST','/invoice/[i:id]?/?', 'invoice.php');
$router->map('GET|POST','/test/?', 'test.php');
$router->map('GET|POST','/allegie/?', 'allegie.php');
$router->map('GET|POST','/edit-service/?', 'edit-service.php');
$router->map('GET|POST','/additives/?', 'additives.php');
$router->map('GET|POST','/menu-properties/?', 'menu-properties.php');	
$router->map('GET|POST','/restro-terms-and-conditions/?', 'restro-terms-and-conditions.php');	

$router->map('GET|POST', '/agb-kunden/?', 'agb-kunden.php');
$router->map('GET|POST', '/agb-restaurants/?', 'agb-restaurants.php');
$router->map('GET|POST', '/data-protection-kunden/?', 'data-protection-kunden.php');
$router->map('GET|POST', '/data-protection-restaurants/?', 'data-protection-restaurants.php');
$router->map('GET|POST', '/impressum-kunden/?', 'impressum-kunden.php');
$router->map('GET|POST', '/impressum-restaurants/?', 'impressum-restaurants.php');

$router->map('GET|POST','/edit-shop-info/?', 'edit-shop-info.php');	

$router->map('GET|POST','/services/?', 'services.php');
$router->map('GET|POST','/vouchers/?', 'vouchers.php');
$router->map('GET|POST','/reservations/?', 'reservations.php');
$router->map('GET|POST','/reservations-report/?', 'reservations-report.php');
$router->map('GET|POST','/customer-care/?', 'customer-care-logs.php');
$router->map('GET|POST','/customers/?', 'customers.php');
$router->map('GET|POST','/staffs/?', 'staffs.php');
$router->map('GET|POST','/website/?', 'website.php');
$router->map('GET|POST','/message-templates/?', 'message-templates.php');
$router->map('GET|POST','/advanced-website-settings/?', 'advanced-website-settings.php');
//for IOS only
$router->map('GET|POST','/reservation-edit/?', 'reservation-edit.php');

$router->map('GET|POST','/reservation-customer-edit/?', 'reservation-customer-edit.php');

//cron jobs
$router->map('GET|POST','/mailing-list/?', 'mailing-list.php');

// Special (GET processing, etc)

$router->map('GET|POST','/page/[*:id]?/?', 'html.php');
$router->map('GET|POST','/membership/[a:change_plan]?/?', 'membership.php');
$router->map('GET|POST','/ipn/[a:i]?/[*:id]?/?', 'ipn.php');
$router->map('GET|POST','/payment/[*:token]?/[a:status]?/[*:message]?/?', 'payment.php');
$router->map('GET','/sitemap.xml/?', 'xml.php');
$router->map('GET|POST','/testimonials/?', 'testimonials.php');
$router->map('GET|POST','/blog/?', 'blog.php');
$router->map('GET|POST','/blog/category/[*:keyword]/?', 'blog-category.php');
$router->map('GET|POST','/blog/author/[*:keyword]/?', 'blog-author.php');
$router->map('GET|POST','/blog/[i:id]?/[*:slug]?/?', 'blog-single.php');
$router->map('GET|POST','/whatsapp-ordering/?', 'whatsapp-ordering.php');
$router->map('GET|POST','/address/?', 'address.php');
$router->map('GET|POST','/change-password/?', 'change-password.php');
$router->map('GET|POST','/demo-google/?', 'translate_demo.php'); 

$router->map('GET|POST','/shop/[i:id]?/[*:slug]?/?','shop.php'); // for old urls
$router->map('GET|POST','/[*:slug]?/?','shop.php');

// API Routes
/* Match the current request */
$match=$router->match();
if($match) {

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $_GET = array_merge($match['params'],$_GET);
    }

    require_once ROOTPATH . '/includes/config.php';

    if(!isset($config['installed']))
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        $site_url = $protocol . $_SERVER['HTTP_HOST'] . str_replace ("index.php", "", $_SERVER['PHP_SELF']);
        header("Location: ".$site_url."install/");
        exit;
    }

    require_once ROOTPATH . '/includes/lib/HTMLPurifier/HTMLPurifier.standalone.php';
    require_once ROOTPATH . '/includes/sql_builder/idiorm.php';
    require_once ROOTPATH . '/includes/db.php';
    require_once ROOTPATH . '/includes/classes/class.template_engine.php';
    require_once ROOTPATH . '/includes/classes/class.country.php';
    require_once ROOTPATH . '/includes/functions/func.global.php';
    require_once ROOTPATH . '/includes/lib/password.php';
    require_once ROOTPATH . '/includes/functions/func.users.php';
    require_once ROOTPATH . '/includes/functions/func.customers.php';
    require_once ROOTPATH . '/includes/functions/func.sqlquery.php';
    require_once ROOTPATH . '/includes/functions/func.tlp.php';
    require_once ROOTPATH . '/includes/classes/GoogleTranslate.php';
    require_once ROOTPATH .'/plugins/google-translate/vendor/autoload.php';

    if(isset($_GET['lang'])) {
        if ($_GET['lang'] != ""){
            change_user_lang($_GET['lang']);
        }
    }
    $cron_time = isset($config['cron_time']) ? $config['cron_time'] : time();
$cron_exec_time = isset($config['cron_exec_time']) ? $config['cron_exec_time'] : "86400";
if((time()-$cron_exec_time) > $cron_time) {
   // run_cron_job();
}
    require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
    require_once ROOTPATH . '/includes/seo-url.php';

    //sec_session_start();
    $mysqli = db_connect();

    require APPPATH.$match['target'];

    
    session_write_close();

}
else {
	
   header("HTTP/1.0 404 Not Found");
   require APPPATH.'404.php';
}