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
// Check if this is an Name availability check from signup page using ajax
$result['success'] = false;
$result['message'] = $lang['ERROR_TRY_AGAIN'];

$restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
->where('slug', $_POST['slug'])
->find_one();

if(isset($_POST["name"])) {
    if(empty($_POST["name"])) {
        die(json_encode($result));
        exit;
    }

    $name_length = strlen(utf8_decode($_POST['name']));
    if( ($name_length < 4) OR ($name_length > 21) )
    {
        die(json_encode($result));
        exit;
    }
    if(!ctype_alnum($_POST['name']))
    {
        die(json_encode($result));
        exit;
    }
}

// Check if this is an Username availability check from signup page using ajax
if(isset($_POST["username"])) {

    if(empty($_POST["username"])) {
        die(json_encode($result));
        exit;
    }

    if(!ctype_alnum($_POST['username']))
    {
        die(json_encode($result));
        exit;
    }
    elseif( (strlen($_POST['username']) < 4) OR (strlen($_POST['username']) > 16) )
    {
        die(json_encode($result));
        exit;
    }
    else
    {   
            $user_count = check_customers_username_exists($_POST["username"],$restaurant['id']);
            if($user_count>0) {
                die(json_encode($result));
            }
    }

}

// Check if this is an Email availability check from signup page using ajax
if(isset($_POST["email"])) {
    $_POST['email'] = strtolower($_POST['email']);

    if(empty($_POST["email"])) {
        die(json_encode($result));
        exit;
    }
    elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    {
        die(json_encode($result));
        exit;
    }
        $user_count = check_customers_account_exists($_POST["email"],$restaurant['id']);
        if($user_count>0) {
            die(json_encode($result));
        }  
}

// Check if this is an Password availability check from signup page using ajax
if(isset($_POST["password"])) {

    if(empty($_POST["password"])) {
        die(json_encode($result));
        exit;
    }
    elseif( (strlen($_POST['password']) < 4) OR (strlen($_POST['password']) > 20) )
    {
        die(json_encode($result));
        exit;
    }
}
$result['success'] = true;
$result['message'] = '';
die(json_encode($result));

?>