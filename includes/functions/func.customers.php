<?php
$config['lang'] = check_user_lang();
$config['lang_code'] = get_current_lang_code();
$config['tpl_name'] = check_user_theme();


function checkcustomerloggedin($restaurant_id)
{
    global $config;

    // Check if all session variables are set
    if (isset($_SESSION['customer']['id'],
        $_SESSION['customer']['username'],
        $_SESSION['customer']['login_string'])) {

        $user_id = $_SESSION['customer']['id'];
        $login_string = $_SESSION['customer']['login_string'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $result = ORM::for_table($config['db']['pre'].'customers')
            ->where('id', $user_id)
            ->where('restaurant_id',$restaurant_id)
            ->find_one();

        if (!empty($result['id'])) {

            $login_check = hash('sha512', $result['password_hash'] . $user_browser);

            if (hash_equals($login_check, $login_string) ){
                // Logged In!!!!
                return true;
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}

function create_page_customers_address($lang,$config,$restaurant,$customer_id)
{
    $main_image = $restaurant['main_image'];
    $cover_image = $restaurant['cover_image'];
    $name = $restaurant['name'];
    $sub_title = $restaurant['sub_title'];
    $address = $restaurant['address'];
    $slug = $restaurant['slug'];
    $userdata = get_user_data(null, $restaurant['user_id']);
    $phone = $userdata['phone'];
    $gmap_api_key = get_option("gmap_api_key");
    $menu_lang = get_user_option($restaurant['user_id'], 'restaurant_menu_languages', '');
    $menu_lang = explode(',', $menu_lang);

    $customer = ORM::for_table($config['db']['pre'] . 'customers')
    ->where('id', $customer_id)
    ->find_one();
    $customer_name = $customer['name'];
    $customer_phone_number = $customer['phone'];
    $customer_email = $customer['email'];
    $customer_address = $customer['address'];
    $customer_house_number = $customer['house_number'];
    $customer_street_name = $customer['street_name'];
    $customer_city = $customer['city'];
    $customer_zip_code = $customer['zip_code'];

    $language = array();
    if (!empty($menu_lang) && count($menu_lang) > 1) {
        $menu_languages = ORM::for_table($config['db']['pre'] . 'languages')
            ->where('active', 1)
            ->order_by_asc('name')
            ->where_in('code', $menu_lang)
            ->find_many();
        foreach ($menu_languages as $info) {
            $language[$info['id']]['code'] = $info['code'];
            $language[$info['id']]['name'] = $info['name'];
            $language[$info['id']]['file_name'] = $info['file_name'];
        }
    }
    
    // Check if this is an Name availability check from signup page using ajax
$page = new HtmlTemplate ('templates/' . $config['tpl_name'] . '/address.tpl'); //restaurant-templates/classic-theme/address.tpl'
$page->SetParameter('OVERALL_HEADER', create_header($lang['RESTAURANT']));
$page->SetParameter('SITE_TITLE', $config['site_title']);
$page->SetParameter('SHOW_LANGS', count($language));
$page->SetParameter('CUSTOMER_USERNAME', $_SESSION['customer']['username']);
$page->SetLoop('LANGS', $language);       
$page->SetParameter('PAGE_TITLE', $name);
$page->SetParameter('PAGE_LINK', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$page->SetParameter('PAGE_META_KEYWORDS', $config['meta_keywords']);
$page->SetParameter('PAGE_META_DESCRIPTION', $config['meta_description']);
$page->SetParameter('LANGUAGE_DIRECTION', get_current_lang_direction());
$page->SetParameter('RESTRO_ID', $restaurant['id']);
$page->SetParameter('NAME', $name);
$page->SetParameter('SUB_TITLE', $sub_title);
$page->SetParameter('ADDRESS', $address);
$page->SetParameter('PHONE', $phone);   
$page->SetParameter('MAIN_IMAGE', $main_image);
$page->SetParameter('COVER_IMAGE', $cover_image);  
$page->SetParameter('CUSTOMER_NAME', $customer_name);
$page->SetParameter('CUSTOMER_PHONE_NUMBER', $customer_phone_number);
$page->SetParameter('CUSTOMER_EMAIL', $customer_email);
$page->SetParameter('CUSTOMER_ADDRESS', $customer_address);
$page->SetParameter('CUSTOMER_HOUSE_NUMBER', $customer_house_number);
$page->SetParameter('CUSTOMER_STREET_NAME', $customer_street_name);
$page->SetParameter('CUSTOMER_CITY', $customer_city);
$page->SetParameter('CUSTOMER_ZIP_CODE', $customer_zip_code);
$page->SetParameter('CUSTOMER_ID',$customer_id);
$page->SetParameter('SLUG',$slug);
$page->SetParameter('GMAP_API_KEY',$gmap_api_key);
$themecolor = $config['theme_color'];
$colors = array();
list($r, $g, $b) = sscanf($themecolor, "#%02x%02x%02x");
$i = 0.01;
while ($i <= 1) {
    $colors["$i"]['id'] = str_replace('.', '_', $i);
    $colors["$i"]['value'] = "rgba($r,$g,$b,$i)";
    $i += 0.01;
}
$colors[1]['id'] = 1;
$colors[1]['value'] = "rgba($r,$g,$b,1)";


$page->SetLoop('COLORS', $colors);

$classic_boder_color = get_restaurant_option($restaurant['id'], 'restaurant_theme_color',$config['theme_color']);
$classic_border_colors = array();
list($r2, $g2, $b2) = sscanf($classic_boder_color, "#%02x%02x%02x");
$i = 0.01;
while ($i <= 1) {
    $classic_border_colors["$i"]['id'] = str_replace('.', '_', $i);
    $classic_border_colors["$i"]['value'] = "rgba($r2,$g2,$b2,$i)";
    $i += 0.01;
 }
  $classic_border_colors[1]['id'] = 1;
  $classic_border_colors[1]['value'] = "rgba($r2,$g2,$b2,1)";
  $page->setLoop('CLASSIC_COLOR',$classic_border_colors);
  $page->SetParameter('OVERALL_FOOTER', create_footer());
  $page->CreatePageEcho();
}

function customerslogin($email,$password,$restaurant_id)
{
    global $config, $user_id, $username,  $db_password, $where;

    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

    if(!preg_match("/^[[:alnum:]]+$/", $email))
    {
        if(!preg_match($regex,$email))
        {
            return false;
        }
        else{
            //checking in email
            $where = 'email';
        }
    }
    else{
        //checking in username
        $where = 'username';
    }

    $num_rows = ORM::for_table($config['db']['pre'].'customers')
        ->select_many('id', 'status', 'username', 'password_hash')
        ->where($where, $email)
        ->where('restaurant_id',$restaurant_id)
        ->count();

    if ($num_rows >= 1) {
        $info = ORM::for_table($config['db']['pre'].'customers')
            ->where($where, $email)
            ->where('restaurant_id',$restaurant_id)
            ->find_one();

        $user_id = $info['id'];
        $status = $info['status'];
        $username = $info['username'];
        $db_password = $info['password_hash'];
        $name = $info['name'];       
        $phone = $info['phone'];
        $email = $info['email'];
        $address =$info['address'];
        $house_number = $info['house_number'];
        $street_name = $info['street_name'];
        $city = $info['city'];
        $zip_code = $info['zip_code'];

        // If the user exists we check if the account is locked
        // from too many login attempts

        /*if (checkbrute($user_id) == true) {
            // Account is locked
            // Send an email to user saying their account is locked
            return false;
        } else {
            // Check if the password in the database matches
            // the password the user submitted. We are using
            // the password_verify function to avoid timing attacks.

        }*/
        if (password_verify($password, $db_password)) {
            // Password is correct!

            // Login successful.
            $userinfo = array();
            $userinfo['id'] = $user_id;
            $userinfo['status'] = $status;
            $userinfo['username'] = $username;
            $userinfo['password'] = $db_password;
            $userinfo['user_type'] = $info['user_type'];
            $userinfo['name'] = $name;
            $userinfo['phone'] = $phone;
            $userinfo['email'] = $email;
            $userinfo['address'] = $address;
            $userinfo['house_number'] = $house_number; 
            $userinfo['street_name'] = $street_name;
            $userinfo['city'] = $city;
            $userinfo['zip_code'] = $zip_code;
            return $userinfo;

        } else {
            // Password is not correct
            // We record this attempt in the database
            $now = time();
            /*$login_attempts = ORM::for_table($config['db']['pre'].'login_attempts')->create();
            $login_attempts->user_id = $user_id;
            $login_attempts->time = $now;
            $login_attempts->save();*/

            return false;
        }
    } else {
        // No user exists.
        return false;
    }
	
}

function get_customer_data($username=null,$userid=null){

    global $config;

    if($username != null){
        $info = ORM::for_table($config['db']['pre'].'customers')
            ->where('username', $username)
            ->find_one();
    }
    else{
        $info = ORM::for_table($config['db']['pre'].'customers')
            ->where('id', $userid)
            ->find_one();
    }

    if (isset($info['id'])) {
        $userinfo['id'] = $info['id'];
        $userinfo['status'] = $info['status'];
        $userinfo['username'] = $info['username'];
        $userinfo['password'] = $info['password'];
        $userinfo['user_type'] = $info['user_type'];
        $userinfo['name'] =$info['name'];
        $userinfo['phone'] = $info['phone'];
        $userinfo['email'] = $info['email'];
        $userinfo['address'] =$info['address'];
        $userinfo['house_number'] = $info['house_number'];
        $userinfo['street_name'] = $info['street_name'];
        $userinfo['city'] = $info['city'];
        $userinfo['zip_code'] = $info['zip_code'];
  
        return $userinfo;
    }
    else
    {
        return 0;
    }
}

function create_customers_session($loggedin,$slug){
   // $loggedin['id'],$loggedin['username'],$loggedin['password'], $loggedin['user_type']
    $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.

    $user_id = preg_replace("/[^0-9]+/", "", $loggedin['id']); // XSS protection as we might print this value
    $_SESSION['customer']['id']  = $user_id;
    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $loggedin['username']); // XSS protection as we might print this value
    $_SESSION['customer']['username'] = $username;
    $_SESSION['customer']['login_string'] = hash('sha512', $loggedin['password'] . $user_browser);
    $_SESSION['customer']['user_type'] = $loggedin['user_type'];
    $_SESSION['customer']['name'] =  $loggedin['name'];
    $_SESSION['customer']['phone'] = $loggedin['phone'];
    $_SESSION['customer']['email'] = $loggedin['email'];
    $_SESSION['customer']['address'] = $loggedin['address'];
    $_SESSION['customer']['house_number'] = $loggedin['house_number'];
    $_SESSION['customer']['street_name'] = $loggedin['street_name'];
    $_SESSION['customer']['city'] = $loggedin['city'];
    $_SESSION['customer']['zip_code'] = $loggedin['zip_code'];
    $_SESSION['customer']['slug'] = $slug;
}

function get_customer_id_by_email($email){

    global $config;

    $info = ORM::for_table($config['db']['pre'].'customers')
        ->select('id')
        ->where('email', $email)
        ->find_one();

    if(isset($info['id'])){
        return $info['id'];
    }
    else{
        return FALSE;
    }
}
function reset_password_by_email($email)
{
    
}


function check_customer_account_exists($email){

    global $config;

    $count = ORM::for_table($config['db']['pre'].'customers')
        ->where('email', $email)
        ->count();

    // check existing email
    if ($count) {
        return $count;
    } else {
        return 0;
    }
}

function send_customer_forgot_email($to,$id,$pass_new = '')
{
    global $config,$lang,$link;
	$time = time();
	$rand = getrandnum(10);
	$forgot = md5($time.'_:_'.$rand.'_:_'.$to);

    $person = ORM::for_table($config['db']['pre'].'customers')->find_one($id);
    $person->forgot = $forgot;
    $person->save();

    $get_userdata = get_user_data(null,$id);
    $to_name = $get_userdata['name'];

    $page = new HtmlTemplate();
    $page->html = $config['email_sub_customer_forgot_pass'];
    $page->SetParameter ('EMAIL', $to);
    $page->SetParameter ('USER_FULLNAME', $to_name);
    $email_subject = $page->CreatePageReturn($lang,$config,$link);

    $forget_password_link = $config['site_url']."login?forgot=".$forgot."&r=".$rand."&e=".$to."&t=".$time;
    $page = new HtmlTemplate();
    $page->html = $config['email_message_customer_forgot_pass'];
    $page->SetParameter ('FORGET_PASSWORD_LINK', $forget_password_link);
    $page->SetParameter ('PASSWORD_NEW', $pass_new);
    $page->SetParameter ('EMAIL', $to);
    $page->SetParameter ('USER_FULLNAME', $to_name);
    $email_body = $page->CreatePageReturn($lang,$config,$link);

    email($to,$to_name,$email_subject,$email_body);
}


?>