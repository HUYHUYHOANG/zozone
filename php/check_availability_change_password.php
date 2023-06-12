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
// Check if this is an Password availability check from signup page using ajax
if(isset($_POST["password"])) {

    if(empty($_POST["password"])) {
        $password_error = $lang['ENTERPASS'];
        echo $password_error;
        exit;
    }
    elseif( (strlen($_POST['password']) < 4) OR (strlen($_POST['password']) > 21) )
    {
        $password_error = $lang['PASSLENG'];
        echo $password_error;
        exit;
    }
    else{
        echo "success";
        exit;
    }

}

if(isset($_POST['oldpassword']))
{
$loggedin =false; //customerslogin($_POST['email'],$_POST['oldpassword']);
if($loggedin == false)
{
    $password_error = $lang['PASSWORD_INCORRECT'];
   echo $password_error;
    exit;
}
else
{
    echo "success";
    exit();
}
}

?>