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

$restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
->where('slug', $_POST['slug'])
->find_one();

// Check if this is an Name availability check from signup page using ajax
if(isset($_POST["name"])) {
    if(empty($_POST["name"])) {
        $name_error = $lang['ENTER_FULL_NAME'];
        echo "<span class='status-not-available'> ".$name_error."</span>";
        exit;
    }

    $name_length = strlen(utf8_decode($_POST['name']));
    if( ($name_length < 4) OR ($name_length > 21) )
    {
        $name_error = $lang['NAMELEN'];
        echo "<span class='status-not-available'> ".$name_error.".</span>";
        exit;
    }
  

    if(!ctype_alnum($_POST['name']))
    {
        $name_error = $lang['NAMEALPHA'];
        echo "<span class='status-not-available'> ".$name_error." [A-Z,a-z,0-9]</span>";
        exit;
    }
    else{
        echo "success";
        exit;
    }
}

// Check if this is an Username availability check from signup page using ajax
if(isset($_POST["username"])) {

    if(empty($_POST["username"])) {
        $username_error = $lang['ENTERUNAME'];
        echo "<span class='status-not-available'> ".$username_error."</span>";
        exit;
    }


    // if (!ctype_alnum($discount_code)) {
    //     $result['success'] = false;
    //     $result['message'] = $lang['ERROR_TRY_AGAIN'];
    //     die(json_encode($result));
    // }

    if(!ctype_alnum($_POST['username']))
    {
        $username_error = $lang['USERALPHA'];
        echo "<span class='status-not-available'> ".$username_error." [A-Z,a-z,0-9]</span>";
        exit;
    }
    elseif( (strlen($_POST['username']) < 4) OR (strlen($_POST['username']) > 16) )
    {
        $username_error = $lang['USERLEN'];
        echo "<span class='status-not-available'> ".$username_error.".</span>";
        exit;
    }
    else
    {   
            $user_count = check_customers_username_exists($_POST["username"],$restaurant['id']);
            if($user_count>0) {
                $username_error = $lang['USERUNAV'];
                echo "<span class='status-not-available'>".$username_error."</span>";
            }
            else {
                $username_error = $lang['USERUAV'];
                echo "success";
            }
            exit;
    }

}

// Check if this is an Email availability check from signup page using ajax
if(isset($_POST["email"])) {
    $_POST['email'] = strtolower($_POST['email']);

    if(empty($_POST["email"])) {
        $email_error = $lang['ENTEREMAIL'];
        echo "<span class='status-not-available'> ".$email_error."</span>";
        exit;
    }
    elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
    {
        $email_error = $lang['EMAILINV'];
        echo "<span class='status-not-available'> ".$email_error.".</span>";
        exit;
    }
        $user_count = check_customers_account_exists($_POST["email"],$restaurant['id']);
        if($user_count>0) {
            $email_error = $lang['ACCAEXIST'];
            echo "<span class='status-not-available'>".$email_error."</span>";
        }
        else {
            $email_error = $lang['EMAILAVL'];
            echo "success";
        }
        exit;
    
}

// Check if this is an Password availability check from signup page using ajax
if(isset($_POST["password"])) {

    if(empty($_POST["password"])) {
        $password_error = $lang['ENTERPASS'];
        echo "<span class='status-not-available'> ".$password_error."</span>";
        exit;
    }
    elseif( (strlen($_POST['password']) < 4) OR (strlen($_POST['password']) > 20) )
    {
        $password_error = $lang['PASSLENG'];
        echo "<span class='status-not-available'> ".$lang['PASSLENG'].".</span>";
        exit;
    }
    else{
        echo "success";
        exit;
    }

}

?>