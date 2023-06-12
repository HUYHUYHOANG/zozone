<?php
load_all_option_in_template($config);
$timezone = get_option("timezone");
date_default_timezone_set($timezone);
$date = new DateTime("now", new DateTimeZone($timezone));
$timenow = date('Y-m-d H:i:s');
if(isset($config['quickad_debug']) && $config['quickad_debug'] == 1){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}else{
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}

function getNextIDOrders($restaurant_id)
{
    global $config;
     $sRet = "";
    $sPrefix = $restaurant_id . '-' . '%';
    //2021-07-08              
    $sDate  = date("Y-m-d");
    $order = ORM::for_table($config['db']['pre'] . 'orders')
    ->where_gte('created_at', $sDate . ' 00:00:00')
    ->where_lte('created_at', $sDate . ' 23:59:59')
    ->where_like('id', $sPrefix)->order_by_desc('id')
    ->find_one();
    if(empty($order->id))
    {
        $sRet = $restaurant_id . "-" . date('dmY'). "-0001";
    }
    else
    {
        $sPrefix = $restaurant_id . '-';
        if (strpos($order->id, $sPrefix) !== false) 
        {
            $iTemp  = substr($order->id, -4);
            $sRet = $restaurant_id . "-" . date('dmY') . "-" . substr("0000" . ((int)($iTemp) + 1), -4);
        }
        else
        {
            $sRet = $restaurant_id . "-" . date('dmY'). "-0001";
        }
     
    }   
     Return $sRet;
}
function getNextIDOrdersReserve($restaurant_id)
{
    global $config;
     $sRet = "";
    $sPrefix = $restaurant_id . '-' . '%';
    //2021-07-08              
    $sDate  = date("Y-m-d");
    $order = ORM::for_table($config['db']['pre'] . 'reserve')
    ->where_gte('created_at', $sDate . ' 00:00:00')
    ->where_lte('created_at', $sDate . ' 23:59:59')
    ->where_like('id', $sPrefix)->order_by_desc('id')
    ->find_one();
    if(empty($order->id))
    {
        $sRet = $restaurant_id . "-" . date('dmY'). "-0001";
    }
    else
    {
        $sPrefix = $restaurant_id . '-';
        if (strpos($order->id, $sPrefix) !== false) 
        {
            $iTemp  = substr($order->id, -4);
            $sRet = $restaurant_id . "-" . date('dmY') . "-" . substr("0000" . ((int)($iTemp) + 1), -4);
        }
        else
        {
            $sRet = $restaurant_id . "-" . date('dmY'). "-0001";
        }
     
    }   
     Return $sRet;
}

function get_content($URL)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $URL);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function get_current_shop(){
    global $config;
    $shop = ORM::for_table($config['db']['pre'] . 'shop')->select('slug')->where('id', $_SESSION['user']['shop_id'])->find_one();
    return $shop ? $shop['slug'] : '';
}

function create_header($page_title='',$meta_desc = '',$meta_image = '',$meta_article = false,$langding_page = false)
{
    global $config,$lang,$link;
    checkinstall();
    if($langding_page)
    {
        $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/overall_header_langding_page.tpl");
    }
    else
    {
        $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/overall_header.tpl");
    }
    $shop = ORM::for_table($config['db']['pre'] . 'shop')
    ->where('id', $_SESSION['user']['shop_id'])
    ->find_one();
    $main_image = $shop['main_image'];
    $page->SetParameter('PAGE_TITLE', $page_title);
    
    $page->SetParameter('PAGE_LINK', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    $page->SetParameter('PAGE_META_KEYWORDS', $config['meta_keywords']);
    $page->SetParameter('PAGE_META_DESCRIPTION', ($meta_desc == '')?$config['meta_description']:$meta_desc);
    $page->SetParameter('GMAP_KEY', $config['gmap_api_key']);
    $page->SetParameter('ONLY_ON_TABLE', $config['only_on_table']);
    $page->SetParameter('SHOP_MAIN_IMAGE', $main_image);
    if($meta_article){
        $page->SetParameter('META_CONTENT', 'article');
        if(!empty($meta_image)){
            $page->SetParameter('META_IMAGE', $meta_image);
        }
        else
        {
            $meta_image = $config['site_url'].'storage/logo/'.$config['site_logo'];
        }
    }else{
        $meta_image = $config['site_url'].'storage/logo/'.$config['site_logo'];
        $page->SetParameter('META_CONTENT', 'website');
        $page->SetParameter('META_IMAGE', $meta_image);

    }
    if(isset($_SESSION['user']['id']))
    {
        $get_userdata = get_user_data($_SESSION['user']['username']);
        $page->SetParameter ('USERSTATUS', $get_userdata['status']);
        $page->SetParameter ('USEREMAIL', $get_userdata['email']);
        $page->SetParameter ('FULLNAME', $get_userdata['name']);
        $page->SetParameter ('USERPIC', $get_userdata['image']);
        $page->SetParameter ('EMAILDOMAIN', get_domain($get_userdata['email']));
    }
    else
    {
        $page->SetParameter ('USEREMAIL', '');
    }
    $page->SetParameter ('LANG_SEL', $config['userlangsel']);
    $page->SetLoop ('LANGS', get_language_list('',$selected_text='selected',true));
    $page->SetParameter('LANGUAGE_DIRECTION', get_current_lang_direction());

    $themecolor = $config['theme_color'];
    $colors = array();
    list($r, $g, $b) = sscanf($themecolor, "#%02x%02x%02x");
    $i = 0.01;
    while($i <= 1){
        $colors["$i"]['id'] = str_replace('.','_',$i);
        $colors["$i"]['value'] = "rgba($r,$g,$b,$i)";
        $i += 0.01;
    }
    $colors[1]['id'] = 1;
    $colors[1]['value'] = "rgba($r,$g,$b,1)";
    $page->SetLoop('COLORS',$colors);

    $shop = ORM::for_table($config['db']['pre'] . 'shop')
    ->where('id', $_SESSION['user']['shop_id'])
    ->find_one();

    $classic_boder_color = get_shop_option($shop['id'], 'shop_theme_color',$config['theme_color']);
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
  $_SESSION['user']['default_color'] = $classic_border_colors['1']['value'];    
    return $page->CreatePageReturn($lang,$config,$link);
}

function sidebar_add_custom_menu_items(&$rightMenu=null){
    define('LOAD_BO_SIDEBAR_TEMPL_FROM_FUNCTION', 1);
    require_once('./php/ctrls/bo/sidebar-custom-items.class.php');
    $items = '';
    new CBOSidebarItems($items, $rightMenu);
    return $items;
}

function create_footer($langding_page = false)
{
  global $config,$lang,$link;
  if($langding_page)
  {
    $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/overall_footer_langding_page.tpl");
  }
  else
  {
    $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/overall_footer.tpl");
  }
    $page->SetLoop ('HTMLPAGE', get_html_pages());
    $page->SetParameter('SITE_TITLE', $config['site_title']);
    $page->SetParameter('SITE_LOGO', $config['site_logo']);
    $page->SetParameter('PHONE', $config['contact_phone']);
    $page->SetParameter('ADDRESS', $config['contact_address']);
    $page->SetParameter('EMAIL', $config['contact_email']);
    $page->SetParameter ('SWITCHER', $config['color_switcher']);
    $page->SetParameter ('REF_URL', $_SERVER['REQUEST_URI']);

    return $page->CreatePageReturn($lang,$config,$link);
}

function get_the_value($link){
    //If it's not empty
    if (!empty($link)) {
        //If it begins with https...
        if (preg_match('/^https/', $link)) {
            //...then we'll set the $url_prefix variable to https://
            $url_prefix = 'https://';
        } else {
            //If it does not begin with https we'll use http
            $url_prefix = 'http://';
        }
        //Get rid of the http:// or https://
        $link = str_replace(array('http://', 'https://'), '', $link);
        return check_www_in_url($link);
    }
    return $link;
}

function check_www_in_url($link){
    $params = array();
    //If it's not empty
    if (!empty($link)) {
        $params = explode('.', $link);

        if($params[0] == 'www') {
            // www exists
        }else{
            // non www
        }
        //Get rid of the www.
        return  str_replace("www.", '', $link);
    }
    return $link;
}

function get_site_url($site_url){
    //If it's not empty
    if (!empty($site_url)) {
        // Check if SSL enabled
        if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
            $protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"] == "https" ? "https://" : "http://";
        else
            $protocol = !empty($_SERVER['HTTPS']) && $_SERVER["HTTPS"] != "off" ? "https://" : "http://";

        $link = get_the_value($site_url);

        $params = explode('.', $_SERVER["HTTP_HOST"]);

        if($params[0] == 'www') {
            // www exists
            $link = "www.".$link;
        }else{
            // non www
        }

        return $site_url = $protocol.$link;
    }
    return $site_url;
}

function load_all_option_in_template(&$config){

    $info = ORM::for_table($config['db']['pre'].'options')
        ->find_many();

    foreach ($info as $data){

        $key = $data['option_name'];
        $value = $data['option_value'];
        if($key == 'lang')
            $config['default_lang'] = $value;

        if($key == 'site_url'){
            $value = get_site_url($value);
        }
        if($key == 'app_url'){
            $site_url = get_site_url($value);
            $value = $site_url."php/";
        }
        $config[$key] = ($value);
    }
}

function add_option($option, $value = '') {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $option_id = ORM::for_table($config['db']['pre'].'options')->create();
    $option_id->option_name = $option;
    $option_id->option_value = $value;
    $option_id->save();

    return $option_id->id();
}

function get_option($option,$default=null) {

    global $config;

    $option = trim($option);
    if(isset($config[$option])){
        return $config[$option];
    }else{
        load_all_option_in_template($config);
        if(!isset($config[$option])){
            return $default;
        }
        return $config[$option];
    }
}

function check_option_exist($option) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $num_rows = ORM::for_table($config['db']['pre'].'options')
        ->where('option_name',$option)
        ->count();
    if($num_rows == 1)
        return true;
    else
        return false;
}

function get_restaurant_id_by_user_id($user_id)
{
    global $config;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
    ->table_alias('r')
    ->join($config['db']['pre'] . 'user_restaurant', array('r.id', '=', 'ur.restaurant_id'), 'ur')
    ->where('ur.user_id', $user_id)
    ->find_one();
    return $restaurant->id;
}

function update_option($option,$value) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    if(check_option_exist($option)){
        $pdo = ORM::get_db();
        $data = [
            'option_value' => $value,
            'option_name' => $option
        ];
        $sql = "UPDATE ".$config['db']['pre']."options SET option_value=:option_value WHERE option_name=:option_name";
        $query_result = $pdo->prepare($sql)->execute($data);

        if (!$query_result)
            return false;
        else
            return true;
    }
    else{
        add_option($option,$value);
        return true;
    }
}

function delete_option($option) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $result = ORM::for_table($config['db']['pre'].'options')
        ->where_equal('option_name', $option)
        ->delete_many();

    if ( ! $result )
        return false;
    else
        return true;
}

function generate_email_booking($shop_id, $booking_id,$from_name,$from_email, $email_to, $subject)
{
    global $config, $lang, $link;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->find_one($restro_id);
    $userdata = get_user_data(null, $restaurant['user_id']);
    $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
    $main_image = $restaurant['main_image'];
    $restaurant_telephone = $restaurant['phone_number'];
    $restaurant_address = $restaurant['address'];
    $restaurant_name = $restaurant['name'];

    $customer_info = ORM::for_table($config['db']['pre'] . 'order_customer_info')
        ->where('order_id', $order_id)
        ->find_one();
    $customer_name = $customer_info['customer_name'];
    $customer_address = $customer_info['address'];
    $customer_telephone = $customer_info['phone_number'];
    $customer_email = $customer_info['email'];

    $order = ORM::for_table($config['db']['pre'] . 'orders')
        ->where('id', $order_id)
        ->find_one();
    $total_sum = price_format($order['amount'], $currency, false);
    $message = $order['message'];
    $date_takeaway_delivery = date("d-m-Y H:i", strtotime($order['takeaway_delivery_time']));
    // Output to template
    $order_type = '';
    $delivery_fee = '';
    $rabatt_code = '';
    $rabatt_cost = '';
    $payment_methoad = '';
    if ($order['type'] == "delivery") {
        $order_type = 'Lieferung';
        $delivery_fee =  price_format($order['shipping_fee'], $currency, false);
    } else if ($order['type'] == "takeaway") {
        $order_type = 'Abholen';
    }

    if (!empty($order['coupons_code'])) {
        $rabatt_code = $order['coupons_code'];
        $rabatt_cost = price_format(-$order['include_total_discount_value'], $currency, false);
    }
    if ($order['payment_gateway'] == 'cash') {
        $payment_methoad = 'Bar';
    } else {
        $payment_methoad = ucfirst($order['payment_gateway']);
    }
    if ($order['is_paid'] == 1) {
        $payment_methoad .= ' (Bezahlt)';
    }
    // get order items
    $order_items = ORM::for_table($config['db']['pre'] . 'order_items')
        ->table_alias('oi')
        ->select_many('oi.*')
        ->where(array(
            'order_id' => $order['id']
        ))
        ->join($config['db']['pre'] . 'menu', array('oi.item_id', '=', 'm.id'), 'm')
        ->order_by_desc('id')
        ->find_many();
    $tpl = '';
    foreach ($order_items as $order_item) {
        $total_price_item = 0;
        $order_item_name = $order_item['name'];
        $order_item_price = price_format($order_item['amount'], $currency);
        $total_price_item = $order_item['total_amount'];
        $order_item_name = $order_item['quantity'] . ' x ' . $order_item_name;
        $tpl .= '<tr><td class="menu_title" height="40">' . $order_item_name . '<br>';
        // get order extras
        $order_item_extras = ORM::for_table($config['db']['pre'] . 'order_item_extras')
            ->table_alias('oie')
            ->select_many('oie.*', 'me.title', 'me.price')
            ->where(array(
                'order_item_id' => $order_item['id']
            ))
            ->join($config['db']['pre'] . 'menu_extras', array('oie.extra_id', '=', 'me.id'), 'me')
            ->order_by_desc('id')
            ->find_many();
        $print_tpl_extra = '';
        if ($order_item_extras->count()) {
            foreach ($order_item_extras as $order_item_extra) {
                $total_price_item += $order_item_extra['price'] * $order_item['quantity'];
                $tpl .= '<p class="menu_extra">+ ' . $order_item_extra['title'] . ' : ' . price_format($order_item_extra['price'] * $order_item['quantity'], $currency) . ' </p>';
            }
        }
        $tpl .= '</td>';
        $tpl .= '<td height="40" class="menu_price"> <div align="right">' . $order_item_price . '</div></td>';
        $tpl .= '<td height="40" class="menu_total_price"><div  align="right">' . price_format($total_price_item, $currency) . '</div></td></tr>';
    }

    $page = new HtmlTemplate($config['site_url'] . "templates/" . $config['tpl_name'] . "/template_email_order.tpl");
    $classic_boder_color = get_shop_option($restro_id, 'restaurant_theme_color', $config['theme_color']);
    $page->SetParameter('BACKGROUND', $classic_boder_color);
    $page->SetParameter('RESTAURANT_TELEPHONE', $restaurant_telephone);
    $page->SetParameter('MAIN_IMAGE', $main_image);
    $page->SetParameter('RESTAURANT_ADDRESS', $restaurant_address);
    $page->SetParameter('RESTAURANT_NAME', $restaurant_name);
    $page->SetParameter('ORDER_ID', $order_id);
    $page->SetParameter('CUSTOMER_NAME', $customer_name);
    $page->SetParameter('CUSTOMER_ADDRESS', $customer_address);
    $page->SetParameter('CUSTOMER_TELEPHONE', $customer_telephone);
    $page->SetParameter('CUSTOMER_EMAIL', $customer_email);
    $page->SetParameter('TOTAL_SUM', $total_sum);
    $page->SetParameter('MESSAGE', $message);
    $page->SetParameter('DATE_TAKEAWAY_DELIVERY', $date_takeaway_delivery);
    $page->SetParameter('ORDER_TYPE', $order_type);
    $page->SetParameter('DELIVERY_FEE', $delivery_fee);
    $page->SetParameter('RABATT_CODE', $rabatt_code);
    $page->SetParameter('RABATT_COST', $rabatt_cost);
    $page->SetParameter('PAYMENT_METHOAD', $payment_methoad);
    $page->SetParameter('ORDER_DETAIL', $tpl);

    $email_body = $page->CreatePageReturn($lang, $config, $link);
  
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . $from_name . ' <' . $from_email . '>';
    $headers[] = 'X-Priority: 1 (Highest)';
    $headers[] = 'X-MSMail-Priority: High';
    $headers[] = 'Importance: High';
    mail($email_to, $subject, $email_body, implode("\r\n", $headers));
}

function generate_email_common($restro_id, $content, $email_to, $subject)
{
    global $config, $lang, $link;
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->find_one($restro_id);
    $main_image = $restaurant['main_image'];
    $restaurant_telephone = $restaurant['phone_number'];
    $restaurant_address = $restaurant['address'];
    $restaurant_name = $restaurant['name'];
    $page = new HtmlTemplate($config['site_url'] . "templates/" . $config['tpl_name'] . "/template_email_common.tpl");
    $classic_boder_color = get_shop_option($restro_id, 'restaurant_theme_color', $config['theme_color']);
    $page->SetParameter('BACKGROUND', $classic_boder_color);
    $page->SetParameter('RESTAURANT_TELEPHONE', $restaurant_telephone);
    $page->SetParameter('MAIN_IMAGE', $main_image);
    $page->SetParameter('RESTAURANT_ADDRESS', $restaurant_address);
    $page->SetParameter('RESTAURANT_NAME', $restaurant_name);
    $page->SetParameter('CONTENT_EMAIL', $content);
    $email_body = $page->CreatePageReturn($lang, $config, $link);
    $from_user = $config['site_title'];
    $from_email = $config['admin_email'];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . $from_user . ' <' . $from_email . '>';
    $headers[] = 'X-Priority: 1 (Highest)';
    $headers[] = 'X-MSMail-Priority: High';
    $headers[] = 'Importance: High';
    mail($email_to, $subject, $email_body, implode("\r\n", $headers));
}

function generate_email_admin($content, $email_to, $subject)
{
    global $config, $lang, $link;
    $page = new HtmlTemplate($config['site_url'] . "templates/" . $config['tpl_name'] . "/template_email_admin.tpl");
    $classic_boder_color = $config['theme_color'];
    $page->SetParameter('BACKGROUND', $classic_boder_color);
    $page->SetParameter('SITE_NAME', get_option("site_title"));
    $page->SetParameter('SITE_ADDRESS', get_option("contact_address"));
    $page->SetParameter('SITE_TELEPHONE', get_option("contact_phone"));
    $page->SetParameter('CONTENT_EMAIL', $content);
    $email_body = $page->CreatePageReturn($lang, $config, $link);
    $from_user = $config['site_title'];
    $from_email = $config['admin_email'];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';
    $headers[] = 'From: ' . $from_user . ' <' . $from_email . '>';
    $headers[] = 'X-Priority: 1 (Highest)';
    $headers[] = 'X-MSMail-Priority: High';
    $headers[] = 'Importance: High';
    mail($email_to, $subject, $email_body, implode("\r\n", $headers));
}

function add_shop_option($shop_id, $option, $value = null) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $option_id = ORM::for_table($config['db']['pre'].'shop_options')->create();
    $option_id->shop_id = $shop_id;
    $option_id->option_name = $option;
    $option_id->option_value = $value;
    $option_id->save();

    return $option_id->id();
}

function get_shop_option($shop_id, $option, $default = null) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return $default;

    $result = ORM::for_table($config['db']['pre'].'shop_options')
        ->where('option_name', $option)
        ->where('shop_id', $shop_id)
        ->find_one();

    if ( isset($result['option_value']))
        return $result['option_value'];
    else
        return $default;
}

function check_shop_option_exist($shop_id, $option) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $num_rows = ORM::for_table($config['db']['pre'].'shop_options')
        ->where('option_name',$option)
        ->where('shop_id', $shop_id)
        ->count();
    if($num_rows == 1)
        return true;
    else
        return false;
}

function update_shop_option($shop_id, $option, $value) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    if(check_shop_option_exist($shop_id, $option )){
        $pdo = ORM::get_db();
        $data = [
            'shop_id' => $shop_id,
            'option_value' => $value,
            'option_name' => $option
        ];
        $sql = "UPDATE ".$config['db']['pre']."shop_options SET option_value=:option_value WHERE option_name=:option_name AND shop_id=:shop_id";
        
        $query_result = $pdo->prepare($sql)->execute($data);
        
        if (!$query_result)
            return false;
        else
            return true;
    }
    else{
        add_shop_option($shop_id,$option,$value);
        return true;
    }
}

function delete_restaurant_option($restaurant_id, $option) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $result = ORM::for_table($config['db']['pre'].'restaurant_options')
        ->where('option_name',$option)
        ->where('restaurant_id', $restaurant_id)
        ->delete_many();

    if ( ! $result )
        return false;
    else
        return true;
}

function add_user_option($user_id, $option, $value = null) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $option_id = ORM::for_table($config['db']['pre'].'user_options')->create();
    $option_id->user_id = $user_id;
    $option_id->option_name = $option;
    $option_id->option_value = $value;
    $option_id->save();

    return $option_id->id();
}

function get_allow_ordering($id)
{
    global $config;
     // Get usergroup details
     $group_id = get_user_group_by_id($id);
     // Get membership details
     switch ($group_id) {
         case 'free':
             $plan = json_decode(get_option('free_membership_plan'), true);
             $settings = $plan['settings'];
             $allow_order = $settings['allow_ordering'];
             break;
         case 'trial':
             $plan = json_decode(get_option('trial_membership_plan'), true);
             $settings = $plan['settings'];
             $allow_order = $settings['allow_ordering'];
             break;
         default:
             $plan = ORM::for_table($config['db']['pre'] . 'plans')
                 ->select('settings')
                 ->where('id', $group_id)
                 ->find_one();
             if (!isset($plan['settings'])) {
                 $plan = json_decode(get_option('free_membership_plan'), true);
                 $settings = $plan['settings'];
                 $allow_order = $settings['allow_ordering'];
             } else {
                 $settings = json_decode($plan['settings'], true);
                 $allow_order = $settings['allow_ordering'];
             }
             break;
     }
     return $allow_order;
}

function get_day_of_week_string($string)
{
    global $lang;
    switch ($string) 
    {
        case "sunday": 
        $sOpenHour =  $lang['SUNDAY'];
         break;
         case "monday":
        $sOpenHour = $lang['MONDAY'];
         break;
        case "tuesday":
            $sOpenHour = $lang['TUESDAY'];
        break;
        case "wednesday":
            $sOpenHour = $lang['WEDNESDAY'];
        break;
        case "thursday":
            $sOpenHour = $lang['THURSDAY'];
        break;
        case "friday":
            $sOpenHour = $lang['FRIDAY'];
        break;
        case "saturday":
            $sOpenHour =  $lang['SATURDAY'];
        break;

        default:
        //'no nothing'
        $sOpenHour = '';
        break; 
    }
    return $sOpenHour;
}

/**
 * @param $user_id
 * @param $option
 * @param null $default
 * @return array|mixed|null
 */
function get_user_option($user_id, $option, $default = null) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return $default;

    $result = ORM::for_table($config['db']['pre'].'user_options')
        ->where('option_name', $option)
        ->where('user_id', $user_id)
        ->find_one();

    if ( isset($result['option_value']))
        return $result['option_value'];
    else
        return $default;
}

function check_user_option_exist($user_id, $option) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $num_rows = ORM::for_table($config['db']['pre'].'user_options')
        ->where('option_name',$option)
        ->where('user_id', $user_id)
        ->count();
    if($num_rows != 0)
        return true;
    else
        return false;
}

function update_user_option($user_id, $option, $value) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    if(check_user_option_exist($user_id, $option )){
        $pdo = ORM::get_db();
        $data = [
            'user_id' => $user_id,
            'option_value' => $value,
            'option_name' => $option
        ];
        $sql = "UPDATE ".$config['db']['pre']."user_options SET option_value=:option_value WHERE option_name=:option_name AND user_id=:user_id";
        $query_result = $pdo->prepare($sql)->execute($data);

        if (!$query_result)
            return false;
        else
            return true;
    }
    else{
        add_user_option($user_id,$option,$value);
        return true;
    }
}

/**
 * @param $user_id
 * @param $option
 * @return bool
 */
function delete_user_option($user_id, $option) {

    global $config;
    $option = trim($option);
    if ( empty($option) )
        return false;

    $result = ORM::for_table($config['db']['pre'].'user_options')
        ->where('option_name',$option)
        ->where('user_id', $user_id)
        ->delete_many();

    if ( ! $result )
        return false;
    else
        return true;
}

function getLocationInfoByIp(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];
    $result  = array('country'=>'', 'city'=>'');
    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    if($ip != "::1"){
        try{
            require_once  ROOTPATH . '/includes/database/geoip/autoload.php';
            // Country DB
            $reader = new \MaxMind\Db\Reader(ROOTPATH .'/includes/database/geoip/geo_country.mmdb');
            $data = $reader->get($ip);
            $result['countryCode'] = @strtoupper(trim($data['country']['iso_code']));
            $result['country'] = trim($data['country']['names']['en']);
            //$result['city'] = trim($data['city']['names']['en']);
            //$result['latitude'] = trim($data['location']['latitude']);
            //$result['longitude'] = trim($data['location']['longitude']);

            return $result;
        }catch (Exception $e){
            error_log($e->getMessage());
        }
    }

    $result['countryCode'] = null;
    $result['country'] = null;
    $result['city'] = null;
    $result['latitude'] = null;
    $result['longitude'] = null;

    return $result;
}

function checkinstall(){

    global $config;

    if(!isset($config['installed']))
    {
        $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
        $site_url = $protocol . $_SERVER['HTTP_HOST'] . str_replace ("index.php", "", $_SERVER['PHP_SELF']);
        header("Location: ".$site_url."install/");
        exit;
    }

}

function checkpurchase(){

    global $config;

    if(isset($config['purchase_key']))
    {
        header("Location: ".$config['site_url']."install/");
        exit;
    }
    else{
        $purchase_data = verify_envato_purchase_code($config['purchase_key']);

        if( isset($purchase_data['verify-purchase']['item_id']) )
        {
            if($purchase_data['verify-purchase']['item_id'] == '19960675'){
                return true;
            }
        }
        else
        {
            $url = $config['site_url'];
            echo 'Invalid Purchase code Or Check Internet connection.';
            //echo '<script type="text/javascript"> window.location = "'.$url.'install/" </script>';
            exit;
        }
    }
}

function db_connect(){

    global $config;
    checkinstall();
    // Create connection in MYsqli
    $db_connection = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['name']);
    // Check connection in MYsqli
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    return $db_connection;
}

function get_lang_list(){

    global $config;
    $langs = array();

    if ($handle = opendir('includes/lang/'))
    {
        while (false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..')
            {
                $langv = str_replace('.php','',$file);
                $langv = str_replace('lang_','',$langv);

                $langs[]['value'] = $langv;
            }
        }
        closedir($handle);
    }

    sort($langs);

    foreach ($langs as $key => $value)
    {
        if($config['lang'] == $value['value'])
        {
            $langs[$key]['name'] = ucwords($value['value']);
            $langs[$key]['selected'] = 'selected';
        }
        else
        {
            $langs[$key]['name'] = ucwords($value['value']);
            $langs[$key]['selected'] = '';
        }
    }

    return $langs;
}

function getExtension($str)
{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function fileUpload($path,$files,$type_file,$title,$reqwid,$reqhei,$Anysize=false,$unlink=null){

    $target_dir = $path;
    $target_file = $target_dir . basename($files["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    $random1 = rand(9999,100000);
    $random2 = rand(9999,200000);
    $image_title=$title.'_'.$random1.$random2.'.'.$imageFileType;

    $newname = $target_dir.$image_title;

    $error = "";
    if($type_file == "image"){
        list($width, $height) = getimagesize($files["tmp_name"]);
        if($Anysize){
            $uploadedfile = $files["tmp_name"];

            if( $imageFileType=="jpg" || $imageFileType=="jpeg" )
            {
                $src = imagecreatefromjpeg($uploadedfile);
            }
            else if($imageFileType=="png")
            {
                $src = imagecreatefrompng($uploadedfile);
            }
            else
            {
                $src = imagecreatefromgif($uploadedfile);
            }

            $thumb_width = $reqwid;
            $thumb_height = $reqhei;

            $width = imagesx($src);
            $height = imagesy($src);

            $original_aspect = $width / $height;
            $thumb_aspect = $thumb_width / $thumb_height;

            if ( $original_aspect >= $thumb_aspect )
            {
                // If image is wider than thumbnail (in aspect ratio sense)
                $new_height = $thumb_height;
                $new_width = $width / ($height / $thumb_height);
            }
            else
            {
                // If the thumbnail is wider than the image
                $new_width = $thumb_width;
                $new_height = $height / ($width / $thumb_width);
            }

            $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

            // Resize and crop
            imagecopyresampled($thumb,
                $src,
                0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                0, 0,
                $new_width, $new_height,
                $width, $height);

            $image_name =  "small_".$image_title;

            $filename = $target_dir . $image_name;

            imagejpeg($thumb, $filename, 80);

            imagedestroy($src);
            imagedestroy($thumb);

            //Moving file to uploads folder
            if ($filename) {
                if($unlink != null){
                    $filename = $target_dir.$unlink;
                    if(file_exists($filename)){
                        unlink($filename);
                    }
                }
                move_uploaded_file($files["tmp_name"], $newname);
                $success = "The file ". basename( $files["name"]). " has been uploaded.";
                return $image_title;
            } else {
                $error = "Sorry, there was an error uploading your file.";
                return "";
            }

        }
        else{
            //Check width height
            if($reqwid != $width && $reqhei != $height){
                $error = "Sorry, only dimension".$width."x".$height."files are allowed.";
                $uploadOk = 0;
            }
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error = "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }
    }
    elseif($type_file == "zip"){
        // Allow certain file formats
        if($imageFileType != "zip") {
            $error = "Sorry, only Zip file are allowed.";
            $uploadOk = 0;
        }
    }
    else{
    //Any type accepted
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $error = "Sorry, your file was not uploaded.";
        return 0;
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($files["tmp_name"], $newname)) {
            if($unlink != null){
                $filename = $target_dir.$unlink;
                unlink($filename);
            }
            $success = "The file ". basename( $files["name"]). " has been uploaded.";
            return $image_title;
        } else {
            $error = "Sorry, there was an error uploading your file.";
            return "";
        }
    }
}

//resize and crop image by center
function resize_crop_image($max_width, $max_height, $dst_dir, $source_file, $quality = 80){
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];

    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;

        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;

        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;
        default:
            return false;
            break;
    }

    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);

    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }

    $image($dst_img, $dst_dir, $quality);

    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);
    return true;
}

function resizeImage($newwidth, $filename, $uploadedfile) {
    $info = getimagesize($uploadedfile);
    $ext = $info['mime'];

    list($width,$height)=getimagesize($uploadedfile);

    $newheight=($height/$width)*$newwidth;
    $tmp=imagecreatetruecolor($newwidth,$newheight);

    switch( $ext ){
        case 'image/jpeg':
            $src = imagecreatefromjpeg($uploadedfile);
            @imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
            imagejpeg($tmp, $filename, 100);
            @imagedestroy($src);
            break;

        case 'image/png':
            $src = imagecreatefrompng( $uploadedfile );
            imagealphablending( $tmp, false );
            imagesavealpha( $tmp, true );
            imagecopyresampled( $tmp, $src, 0, 0, 0, 0, $newwidth,$newheight,$width,$height);
            imagepng($tmp, $filename, 5);
            @imagedestroy($src);
            break;
    }
    @imagedestroy($tmp);
    return true;
}

function timeAgo($timestamp){
    global $lang;
    //$time_now = mktime(date('h')+0,date('i')+30,date('s'));
    $datetime1=new DateTime("now");
    $datetime2=date_create($timestamp);
    $diff=date_diff($datetime1, $datetime2);
    $timemsg='';
    if($diff->y > 0){
        $timemsg = $diff->y .' '. ($diff->y > 1?$lang['YEARS']:$lang['YEAR']);
    }
    else if($diff->m > 0){
        $timemsg = $diff->m .' '. ($diff->m > 1?$lang['MONTHS']:$lang['MONTH']);
    }
    else if($diff->d > 0){
        $timemsg = $diff->d .' '. ($diff->d > 1?$lang['DAYS']:$lang['DAY']);
    }
    else if($diff->h > 0){
        $timemsg = $diff->h .' '. ($diff->h > 1 ? $lang['HOURS']:$lang['HOUR']);
    }
    else if($diff->i > 0){
        $timemsg = $diff->i .' '. ($diff->i > 1?$lang['MINUTES']:$lang['MINUTE']);
    }
    else if($diff->s > 0){
        $timemsg = $diff->s .' '. ($diff->s > 1?$lang['SECONDS']:$lang['SECONDS']);
    }
    if($timemsg == "")
        $timemsg = $lang['JUST_NOW'];
    else
        $timemsg = $timemsg.' '.$lang['AGO'];

    return $timemsg;
}

function time_elapsed_string($datetime, $full = false) {
    global $lang;
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : $lang['JUST_NOW'];
}

function pagenav($total,$page,$perpage,$url,$posts=0,$seo_url=false)
{
	$page_arr = array();
	$arr_count = 0;

	if($posts) 
	{
		$symb='&';
	}
	else
	{
		$symb='?';
	}
	$total_pages = ceil($total/$perpage);
	$llimit = 1;
	$rlimit = $total_pages;
	$window = 5;
	$html = '';
	if ($page<1 || !$page) 
	{
		$page=1;
	}
	
	if(($page - floor($window/2)) <= 0)
	{
		$llimit = 1;
		if($window > $total_pages)
		{
			$rlimit = $total_pages;
		}
		else
		{
			$rlimit = $window;
		}
	}
	else
	{
		if(($page + floor($window/2)) > $total_pages) 
		{
			if ($total_pages - $window < 0)
			{
				$llimit = 1;
			}
			else
			{
				$llimit = $total_pages - $window + 1;
			}
			$rlimit = $total_pages;
		}
		else
		{
			$llimit = $page - floor($window/2);
			$rlimit = $page + floor($window/2);
		}
	}
	if ($page>1)
	{
		$page_arr[$arr_count]['title'] = '<i class="fa fa-angle-left"></i>';
        if($seo_url)
            $page_arr[$arr_count]['link'] = $url.'/'.($page-1);
        else
            $page_arr[$arr_count]['link'] = $url.$symb.'page='.($page-1);

		$page_arr[$arr_count]['current'] = 0;
		
		$arr_count++;
	}

	for ($x=$llimit;$x <= $rlimit;$x++) 
	{
		if ($x <> $page) 
		{
			$page_arr[$arr_count]['title'] = $x;
            if($seo_url)
                $page_arr[$arr_count]['link'] = $url.'/'.($x);
            else
                $page_arr[$arr_count]['link'] = $url.$symb.'page='.($x);


			$page_arr[$arr_count]['current'] = 0;
		} 
		else 
		{
			$page_arr[$arr_count]['title'] = $x;
            if($seo_url)
                $page_arr[$arr_count]['link'] = $url.'/'.($x);
            else
                $page_arr[$arr_count]['link'] = $url.$symb.'page='.($x);
			$page_arr[$arr_count]['current'] = 1;
		}
		
		$arr_count++;
	}
	
	if($page < $total_pages)
	{
		$page_arr[$arr_count]['title'] = '<i class="fa fa-angle-right"></i>';
        if($seo_url)
            $page_arr[$arr_count]['link'] = $url.'/'.($page+1);
        else
            $page_arr[$arr_count]['link'] = $url.$symb.'page='.($page+1);
		$page_arr[$arr_count]['current'] = 0;
		
		$arr_count++;
	}
	
	return $page_arr;
}

function error($msg, $line='', $file='', $formatted=0)
{
    global $config,$lang,$link;
    if($formatted == 0)
    {
        echo "Low Level Error: " . $msg." ".$file ." ".$line ;
    }
    else
    {
        if(!isset($lang['ERROR']))
        {
            $lang['ERROR'] = '';
        }

        $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/error.tpl");
        $page->SetParameter ('OVERALL_HEADER', create_header($lang['ERROR']));
        $page->SetParameter ('MESSAGE', $msg);
        $page->SetParameter ('CONTENT', "");
        $page->SetParameter ('OVERALL_FOOTER', create_footer());
        $page->CreatePageEcho();
    }
    exit;
}

function error_content($msg, $content="")
{
    global $config,$lang,$link;

    if(!isset($lang['ERROR']))
    {
        $lang['ERROR'] = '';
    }

    $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/error.tpl");
    $page->SetParameter ('OVERALL_HEADER', create_header($lang['ERROR']));
    $page->SetParameter ('MESSAGE', $msg);
    $page->SetParameter ('CONTENT', $content);
    $page->SetParameter ('OVERALL_FOOTER', create_footer());
    $page->CreatePageEcho();

    exit;
}

function email_template($template,$user_id=null,$password=null){
    global $config,$lang,$link;

    if($user_id != null){
        $userdata = get_user_data(null,$user_id);
        $username = $userdata['username'];
        $user_email = $userdata['email'];
        $user_fullname = $userdata['name'];
        $confirm_id =  $userdata['confirm'];
    }

      /*SEND ACCOUNT DETAILS EMAIL*/
      if($template == "customer_signup_details"){
        $customerdata = get_customer_data(null,$user_id);
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_customer_signup_details'];
        $page->SetParameter ('USER_ID', $user_id);
        $page->SetParameter ('USERNAME', $customerdata['username']);
        $page->SetParameter ('EMAIL', $$customerdata['email']);
        $page->SetParameter ('USER_FULLNAME', $customerdata['name']);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);

        $page = new HtmlTemplate();
        $page->html = $config['email_message_customer_signup_details'];
        $page->SetParameter ('USER_ID', $user_id);
        $page->SetParameter ('USERNAME', $customerdata['username']);
        $page->SetParameter ('EMAIL', $customerdata['email']);
        $page->SetParameter ('USER_FULLNAME', $customerdata['name']);
        $page->SetParameter ('PASSWORD', $password);
        $email_body = $page->CreatePageReturn($lang,$config,$link);

        email($customerdata['email'],$customerdata['name'],$email_subject,$email_body);
        /*Send 1 copy to admin*/
        //email($config['admin_email'],$config['site_title'],$email_subject,$email_body);
        return;
    }

    /*SEND ACCOUNT DETAILS EMAIL*/
    if($template == "signup_details"){
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_signup_details'];
        $page->SetParameter ('USER_ID', $user_id);
        $page->SetParameter ('USERNAME', $username);
        $page->SetParameter ('EMAIL', $user_email);
        $page->SetParameter ('USER_FULLNAME', $user_fullname);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);

        $page = new HtmlTemplate();
        $page->html = $config['email_message_signup_details'];
        $page->SetParameter ('USER_ID', $user_id);
        $page->SetParameter ('USERNAME', $username);
        $page->SetParameter ('EMAIL', $user_email);
        $page->SetParameter ('USER_FULLNAME', $user_fullname);
        $page->SetParameter ('PASSWORD', $password);
        $email_body = $page->CreatePageReturn($lang,$config,$link);

        email($user_email,$user_fullname,$email_subject,$email_body);

        /*Send 1 copy to admin*/
        //email($config['admin_email'],$config['site_title'],$email_subject,$email_body);
        return;
    }

    /*SEND CONFIRMATION EMAIL*/
    if($template == "signup_confirm"){
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_signup_confirm'];
        $page->SetParameter ('USER_ID', $user_id);
        $page->SetParameter ('USERNAME', $username);
        $page->SetParameter ('EMAIL', $user_email);
        $page->SetParameter ('USER_FULLNAME', $user_fullname);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);

        $confirmation_link = $link['SIGNUP']."?confirm=".$confirm_id."&user=".$user_id;
        $page = new HtmlTemplate();
        $page->html = $config['email_message_signup_confirm'];
        $page->SetParameter ('USER_ID', $user_id);
        $page->SetParameter ('USERNAME', $username);
        $page->SetParameter ('EMAIL', $user_email);
        $page->SetParameter ('USER_FULLNAME', $user_fullname);
        $page->SetParameter ('CONFIRMATION_LINK', $confirmation_link);
        $email_body = $page->CreatePageReturn($lang,$config,$link);

        email($user_email,$user_fullname,$email_subject,$email_body);
        return;
    }

    /*SEND CONTACT EMAIL TO ADMIN*/
    if($template == "contact"){
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_contact'];
        $page->SetParameter ('CONTACT_SUBJECT', $_POST['subject']);
        $page->SetParameter ('NAME', $_POST['name']);
        $page->SetParameter ('EMAIL', $_POST['email']);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);

        $page = new HtmlTemplate();
        $page->html = $config['email_message_contact'];
        $page->SetParameter ('NAME', $_POST['name']);
        $page->SetParameter ('EMAIL', $_POST['email']);
        $page->SetParameter ('CONTACT_SUBJECT', $_POST['subject']);
        $page->SetParameter ('MESSAGE', $_POST['message']);
        $email_body = $page->CreatePageReturn($lang,$config,$link);

        //email($_POST['email'],$_POST['name'],$email_subject,$email_body);
        email($config['admin_email'],$config['site_title'],$email_subject,$email_body);
    }
    /*SEND FEEDBACK TO ADMIN */
    if($template == "feedback"){
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_feedback'];
        $page->SetParameter ('FEEDBACK_SUBJECT', $_POST['subject']);
        $page->SetParameter ('NAME', $_POST['name']);
        $page->SetParameter ('EMAIL', $_POST['email']);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);

        $page = new HtmlTemplate();
        $page->html = $config['email_message_feedback'];
        $page->SetParameter ('NAME', $_POST['name']);
        $page->SetParameter ('EMAIL', $_POST['email']);
        $page->SetParameter ('PHONE', $_POST['phone']);
        $page->SetParameter ('FEEDBACK_SUBJECT', $_POST['subject']);
        $page->SetParameter ('MESSAGE', $_POST['message']);
        $email_body = $page->CreatePageReturn($lang,$config,$link);

        //email($_POST['email'],$_POST['name'],$email_subject,$email_body);
        email($config['admin_email'],$config['site_title'],$email_subject,$email_body);
    }
    /*SEND REPORT TO ADMIN*/
    if($template == "report"){
        $page = new HtmlTemplate();
        $page->html = $config['email_sub_report'];
        $page->SetParameter ('EMAIL', $_POST['email']);
        $page->SetParameter ('NAME', $_POST['name']);
        $page->SetParameter ('USERNAME', $_POST['username']);
        $page->SetParameter ('VIOLATION', $_POST['violation']);
        $email_subject = $page->CreatePageReturn($lang,$config,$link);

        $page = new HtmlTemplate();
        $page->html = $config['email_message_report'];
        $page->SetParameter ('EMAIL', $_POST['email']);
        $page->SetParameter ('NAME', $_POST['name']);
        $page->SetParameter ('USERNAME', $_POST['username']);
        $page->SetParameter ('USERNAME2', $_POST['username2']);
        $page->SetParameter ('VIOLATION', $_POST['violation']);
        $page->SetParameter ('URL', $_POST['url']);
        $page->SetParameter ('DETAILS', $_POST['details']);
        $email_body = $page->CreatePageReturn($lang,$config,$link);

        //email($_POST['email'],$_POST['name'],$email_subject,$email_body);
        email($config['admin_email'],$config['site_title'],$email_subject,$email_body);
    }
}
function FirebaseNotification($FirebaseToken_user,$lang,$title = '',$msg)
{
    global $config; 
    //'title' => $sType,'android_channel_id' => 'default_notification_channel_id'
    if(empty($title))
    {
        $sType = $lang['NEW_ORDER'];
    }
    else
    {
       $sType =  $title;
    }
    $msg['title'] = $sType;
    $msg['android_channel_id'] = 'default_notification_channel_id';
    $Current = date("Y-m-d H:i:s");
    $msg['date_time'] = $Current;
    if($config['firebase_server_api_key']) 
    {
        $tokens = array($FirebaseToken_user);
        $header = [
            'Authorization: Key=' . $config['firebase_server_api_key'],
            'Content-Type: Application/json'
        ];   
        $payload = [
            'registration_ids' 	=> $tokens,
            'data'				=> $msg
        ];  
        //       'notification' => [],
        $curl = curl_init();   
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode( $payload ),
          CURLOPT_HTTPHEADER => $header
        )); 
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
$myfile = fopen("log.txt", "a") or die("Unable to open file!");
$txt = 'send Message :' .  print_r($msg, TRUE) . ' at ' . date("d-m-Y h:i:sa") . '; Response:' . $response;
fwrite($myfile, "\n". $txt);
fclose($myfile);
    } 
}




function email($email_to,$email_to_name,$email_subject,$email_body,$bcc=array(),$email_reply_to=null, $email_reply_to_name=null){

    global $config;
    if($config['email_template']){
        $email_subject = stripcslashes(nl2br($email_subject));
    }
    include(dirname(__FILE__).DIRECTORY_SEPARATOR."../mail/".$config['email_engine']."/init.engine.php");
}

function message($heading,$message,$forward='',$back=true)
{
    global $config,$lang,$link;
    if($forward == '')
    {
        if($back)
        {
            $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/message.tpl");
            $page->SetParameter ('OVERALL_HEADER', create_header($lang['MESSAGE']));
            $page->SetParameter ('HEADING', $heading);
            $page->SetParameter ('MESSAGE', $message);
            $page->SetParameter ('OVERALL_FOOTER', create_footer());
            $page->CreatePageEcho();
        }
        else
        {
            $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/message_noback.tpl");
            $page->SetParameter ('OVERALL_HEADER', create_header($lang['MESSAGE']));
            $page->SetParameter ('HEADING', $heading);
            $page->SetParameter ('MESSAGE', $message);
            $page->SetParameter ('OVERALL_FOOTER', create_footer());
            $page->CreatePageEcho();
        }
    }
    else
    {
        $page = new HtmlTemplate ("templates/" . $config['tpl_name'] . "/message_forward.tpl");
        $page->SetParameter ('OVERALL_HEADER', create_header($lang['MESSAGE']));
        $page->SetParameter ('HEADING', $heading);
        $page->SetParameter ('MESSAGE', $message);
        $page->SetParameter ('FORWARD', $forward);
        $page->SetParameter ('OVERALL_FOOTER', create_footer());
        $page->CreatePageEcho();
    }
    exit;
}

function transfer($url,$msg,$page_title=''){

    global $config, $lang;

	ob_start();
	echo "<html>\n";
	echo "<head>\n";
	echo "<title>\n";
	echo $page_title;
	echo "</title>\n";
	echo "<STYLE>\n";
	echo "<!--\n";
	echo "TABLE, TR, TD                { font-family:Verdana, Tahoma, Arial;font-size: 7.5pt; color:#000000}\n";
	echo "a:link, a:visited, a:active  { text-decoration:underline; color:#000000 }\n";
	echo "a:hover                      { color:#465584 }\n";
	echo "#alt1   { font-size: 16px; }\n";
	echo "body {\n";
	echo "	background-color: #e8ebf1\n";
    echo "	z-index: 99999\n";
	echo "}\n";
	echo "-->\n";
	echo "</STYLE>\n";
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
	echo "function changeurl(){\n";
	echo "window.location='" . $url . "';\n";
	echo "}\n";
	echo "</script>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head>\n";
	echo "<body onload=\"window.setTimeout('changeurl();',2000);\">\n";
	echo "<table width='95%' height='85%' style='margin: 100px'>\n";
	echo "<tr>\n";
	echo "<td valign='middle'>\n";
	echo "<table align='center' border=\"0\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#fff\">\n";
	echo "<tr>\n";
	echo "<td id='mainbg'>";
	echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"12\">\n";
	echo "<tr>\n";
	echo "<td width=\"100%\" align=\"center\" id=alt1>\n";
	echo $msg . "<br><br>\n";
	echo "<div><img src=\"" . $config['site_url'] . "loading.gif\"/></div><br><br>\n";
	echo "(<a href='" . $url . "'>".$lang['CLICK_IF_NOT_WISH_WAIT']."</a>)</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</body></html>\n";
	ob_end_flush();
}

function get_domain($email){

    $domain = implode('.', array_slice( preg_split("/(\.|@)/", $email), -2));

    return strtolower($domain);
}

function encode_ip($server,$env){

    if( getenv('HTTP_X_FORWARDED_FOR') != '' )
    {
        $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : $REMOTE_ADDR );

        $entries = explode(',', getenv('HTTP_X_FORWARDED_FOR'));
        reset($entries);
        while (list(, $entry) = each($entries))
        {
            $entry = trim($entry);
            if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
            {
                $private_ip = array('/^0\./', '/^127\.0\.0\.1/', '/^192\.168\..*/', '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', '/^10\..*/', '/^224\..*/', '/^240\..*/');
                $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

                if ($client_ip != $found_ip)
                {
                    $client_ip = $found_ip;
                    break;
                }
            }
        }
    }
    else
    {
        $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : $REMOTE_ADDR );
    }

    return $client_ip;
}

function verify_envato_purchase_code($code_to_verify) {
    $code = $code_to_verify;
    $personalToken = "YpjlEDfW7T4MhCv6w6OGAXXWH9roYyXe";
    $userAgent = "Purchase code";

    // If you took $code from user input it's a good idea to trim it:
    $code = trim($code);

    // Query using CURL:
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,

        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer {$personalToken}",
            "User-Agent: {$userAgent}"
        )
    ));

    // Execute CURL with warnings suppressed:
    $response = @curl_exec($ch);

    if (curl_errno($ch) > 0)
        return array('error' => "Failed to query Envato API: " . curl_error($ch));

    // Validate response:

    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($responseCode === 404)
        return array('error' => "The purchase code is invalid");

    if ($responseCode !== 200)
        return array('error' => "Failed to validate code due to an error: HTTP {$responseCode}, Please try again.");

    // Decode returned JSON
    $output = json_decode($response, true);

    // Close Channel
    curl_close($ch);

    // Return output
    return $output;
}

function escape_html($input){
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.AllowedElements', array('span'));
    $config->set('Core.EscapeInvalidTags', true);
    $purifier = new HTMLPurifier($config);

    if (is_array($input)) {
        return $purifier->purifyArray($input);
    } else {
        return $purifier->purify($input);
    }
}

function validate_input($input,$strip_tags=false)
{
    global $config;
    $con = db_connect();

    if(ini_get('magic_quotes_sybase'))
    {
        if(get_magic_quotes_gpc())
        {
            $input = str_replace("''", "'", $input);
        }
        else
        {
            $input = stripslashes($input);
        }
    }

    if($strip_tags){
        $input = stripUnwantedTagsAndAttrs($input);
    }else{
        $input = strip_tags($input);
        //$input = mysqli_real_escape_string($con,$input);
    }

    return $input;
}

function stripUnwantedTagsAndAttrs($html_str, $video_allow = false){
    $html_str = str_replace("&nbsp;"," ",$html_str);
    $html_str = str_replace("&", "&amp;", $html_str);
    $xml = new DOMDocument('1.0','utf-8');
    //$xml->xmlEncoding('utf-8');
    //Suppress warnings: proper error handling is beyond scope of example
    libxml_use_internal_errors(true);
    //List the tags you want to allow here, NOTE you MUST allow html and body otherwise entire string will be cleared
    $allowed_tags = array("div", "h1", "h2", "h3", "h4", "h5", "b", "br", "em", "hr", "i", "p", "a", "img", "span", "table", "tr", "td", "strong", "code", "pre", "ul", "li", "ol", "blockquote");
    //List the attributes you want to allow here
    $allowed_attrs = array ("href", "src");

    if($video_allow){
        $allowed_tags[] = 'iframe';
        $allowed_attrs[] = 'frameborder';
        $allowed_attrs[] = 'width';
        $allowed_attrs[] = 'height';
    }

    if (!strlen($html_str)){return false;}
    if ($xml->loadHTML(mb_convert_encoding($html_str, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD)){
        foreach ($xml->getElementsByTagName("*") as $tag){
            if (!in_array($tag->tagName, $allowed_tags)){
                $tag->parentNode->removeChild($tag);
            }else{
                foreach ($tag->attributes as $attr){
                    if (!in_array($attr->nodeName, $allowed_attrs)){
                        $tag->removeAttribute($attr->nodeName);
                    }
                }
            }
        }
    }
    return $xml->saveHTML();
}

function strlimiter($str,$limit){

    if (strlen($str) > $limit)
        $string = substr($str, 0, $limit) . '...';
    else
        $string = $str;

    return $string;
}

function redirect_parent($url,$close=false){

    echo "<script type='text/javascript'>";
    if ($close)
    {
        echo "window.close(); ";
        echo "window.opener.location.href='$url'";
    }
    else
    {
        echo "window.location.href='$url'";
    }
    echo "</script>";

}

function currencyConverter($from_Currency,$to_Currency,$amount) {
    $from_Currency = urlencode($from_Currency);
    $to_Currency = urlencode($to_Currency);
    $get = file_get_contents("https://finance.google.com/finance/converter?a=1&from=$from_Currency&to=$to_Currency");
    $get = explode("<span class=bld>",$get);
    $get = explode("</span>",$get[1]);
    $exchange_rate = preg_replace("/[^0-9\.]/", null, $get[0]);
    $converted_currency = $exchange_rate*$amount;
    return $converted_currency;


    // change amount according to your needs
    //$amount = 100;
    // change From Currency according to your needs
    //$from_Curr = "USD";
    // change To Currency according to your needs
    //$to_Curr = "INR";

    //$converted_currency = currencyConverter($from_Curr, $to_Curr, $amount);
    // Print outout
    //echo $converted_currency;
}

function rawFormat($number)
{
    if (is_numeric($number)) {
        return $number;
    }

    $number = trim($number);
    $number = strtr($number, array(' ' => ''));
    $number = preg_replace('/ +/', '', $number);
    $number = str_replace(',', '.', $number);
    $number = preg_replace('/[^0-9\.]/', '', $number);

    return $number;
}

function get_random_string($length = 10) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

function get_extension($file) {
    $file_ext = explode(".", $file);
    $extension = end($file_ext);
    return $extension ? $extension : false;
}

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function headerRedirect($url){
    header("Location: $url");
}

function log_adm_action($summary,$details)
{
    global $config;
    $now = time();
    $logs = ORM::for_table($config['db']['pre'].'logs')->create();
    $logs->log_date = $now;
    $logs->log_summary = $summary;
    $logs->log_details = $details;
    $logs->save();
}

function run_cron_job(){

    global $config,$lang,$link;
    $pdo = ORM::get_db();
    $cron_time = isset($config['cron_time']) ? $config['cron_time'] : 0;
    $cron_exec_time = isset($config['cron_exec_time']) ? $config['cron_exec_time'] : "300";

    if((time()-$cron_exec_time) > $cron_time) {

        ignore_user_abort(1);
        @set_time_limit(0);

        $start_time = time();
        update_option('cron_time',time());

        /**
         * START REMOVE OLD PENDING TRANSACTIONS IN 3 Days
         *
         */
        $expiry_time = time()-259200;
        ORM::for_table($config['db']['pre'].'transaction')
            ->where_any_is(array(
                array('status' => 'pending', 'transaction_time' => $expiry_time)), array('transaction_time' => '<'))
            ->delete_many();
         // END REMOVE OLD PENDING TRANSACTIONS

        $expire_membership = 0;
        $expiry_time = time();       

        $result = ORM::for_table($config['db']['pre'].'module_upgrades')
            ->select_many('id','user_id','upgrade_expires')
            ->where_lt('upgrade_expires', $expiry_time)
            ->find_many();
       
        foreach ($result as $info)
        {
            $date_now = date('Y-m-d');
            $expiry_date   = date('Y-m-d',$info['upgrade_expires']);
          if($date_now != $expiry_date)
          {
            ORM::for_table($config['db']['pre'].'module_upgrades')
            ->where('id', $info['id'])
            ->delete_many();

            ORM::for_table($config['db']['pre'].'send_mail_log')
            ->where('module_upgrades_id' , $info['id'])
            ->delete_many();
          }
           
        }
        // END REMOVE EXPIRED UPGRADES
        // Check and send mail module expiration

        $Date = date('Y-m-d');
        $result = ORM::for_table($config['db']['pre'].'send_mail_log')
        ->where(array('seen' => 0,'date' => $Date))
        ->limit(5)
        ->find_many();
     
    foreach ($result as $info)
    {
    $module_upgrades_id = $info->module_upgrades_id;
    $module_result =  ORM::for_table($config['db']['pre'].'module_upgrades')
    ->table_alias('m_u')
    ->select_many('m_u.upgrade_expires','m.name')
    ->where('m_u.id', $module_upgrades_id)
    ->inner_join($config['db']['pre']."module","m_u.module_id = m.id",'m')
    ->find_one();

    $user_result = ORM::for_table($config['db']['pre'].'module_upgrades')
    ->table_alias('m')
    ->select_many('u.email','r.*')
    ->where('m.id', $module_upgrades_id)
    ->inner_join($config['db']['pre']."user","u.id = m.user_id",'u')
    ->inner_join($config['db']['pre']."restaurant","u.id = r.user_id",'r')
    ->find_one();

    $page = new HtmlTemplate();
    $page->html = $config['email_sub_module_expiration'];
    $page->SetParameter('RESTAURANT_NAME', $user_result['name']);   
    $page->SetParameter('EMAIL', $user_result['email']);
    $page->SetParameter('PHONE_NUMBER', $user_result['phone_number']);
    $page->SetParameter('ADDRESS', $user_result['address']);  
    $page->SetParameter('CITY', $user_result['city']);
    $page->SetParameter('MODULE_NAME', $module_result['name']);
    $page->SetParameter('ZIPCODE', $user_result['zipcode']);
    $page->SetParameter('DATE_EXPIRATION', date('d-m-Y',$module_result['upgrade_expires']));
    $email_subject = $page->CreatePageReturn($lang, $config, $link);
    
    $page = new HtmlTemplate();
    $page->html = $config['email_message_module_expiration'];
    $page->SetParameter('RESTAURANT_NAME', $user_result['name']);   
    $page->SetParameter('EMAIL', $user_result['email']);
    $page->SetParameter('PHONE_NUMBER', $user_result['phone_number']);
    $page->SetParameter('ADDRESS', $user_result['address']);  
    $page->SetParameter('CITY', $user_result['city']);
    $page->SetParameter('MODULE_NAME', $module_result['name']);
    $page->SetParameter('ZIPCODE', $user_result['zipcode']);
    $page->SetParameter('DATE_EXPIRATION', date('d-m-Y',$module_result['upgrade_expires']));
    $email_body = $page->CreatePageReturn($lang, $config, $link);
    email($user_result['email'], $user_result['name'], $email_subject, $email_body);

   $send_mail_log =  ORM::for_table($config['db']['pre'].'send_mail_log')
    ->where('id',$info->id)
    ->find_one();
    $send_mail_log->set('seen', 1);
    $send_mail_log->save();
    }
     

        $end_time = (time()-$start_time);

        $cron_details = "Expire membership: ".$expire_membership."<br>";
        $cron_details.= "<br>";
        $cron_details.= "Cron Took: ".$end_time." seconds";

        log_adm_action('Cron Run',$cron_details);
    }
    else {
        return false;
    }
}

function parse_name_from_email($text)
{
    list($text) = explode('@', $text);
    $text = preg_replace('/[^a-z0-9]/i', '', $text);
    return $text;
}

function clean_string($string) {
    //$string = preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.
    $string= preg_replace('/(?!\n)[[:cntrl:]]+/','',$string);
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

function removeEmailAndPhoneFromString($string) {
    // remove email
    $string = preg_replace('/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/','',$string);

    // remove phone
    $string = preg_replace('/([0-9]+[\- ]?[0-9]+)/','',$string);

    return $string;
}

function thousandsCurrencyFormat($num) {

    if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

    }

    return $num;
}

function base64_url_encode($input) {
    return strtr(base64_encode($input), '+/=', '._-');
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '._-', '+/='));
}

function sanitize($text) {
    $text = htmlspecialchars($text, ENT_QUOTES);
    $text = str_replace("\n\r","\n",$text);
    $text = str_replace("\r\n","\n",$text);
    $text = str_replace("\n","<br>",$text);
    return $text;
}

function de_sanitize($text) {
    $text = str_replace("<br>","\n",$text);
    return $text;
}

function escape($text,$htmlspecialchars = true) {
    $text = strip_tags($text);
    if($htmlspecialchars)
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

    $text = str_replace("\n\r","\n",$text);
    $text = str_replace("\r\n","\n",$text);
    $text = str_replace("\n","<br>",$text);
    return $text;
}

function sanitize_string($text) {
    return filter_var($text, FILTER_SANITIZE_STRING);
}

/*
Get unread count for notification and chat conversation
action = unread_note_chat_count

1. user_id

Messages
1. unread_notification
2. unread_chat
*/

function unread_note_count($type=null){
    global $config;

    if($type != null){
        $array = array(
            'owner_id' => $_SESSION['user']['id'],
            'type' => $type,
            'recd' => '0'
        );
    }else{
        $array = array(
            'owner_id' => $_SESSION['user']['id'],
            'recd' => '0'
        );
    }
    $notification_count = ORM::for_table($config['db']['pre'].'push_notification')
        ->where($array)
        ->count();

    return $notification_count;
}

/*
Get Notification
action = get_notification

1. user_id

Messages
1. Success : array
2. Error : not found
*/

function get_firebase_notification($user_id)
{
    global $config, $lang, $results;

    $notification = array();

    $rows = ORM::for_table($config['db']['pre'].'push_notification')
        ->where('owner_id',$user_id)
        ->orderByDesc('id')
        ->find_many();

    foreach ($rows as $info)
    {
        $note['sender_id'] = $info['sender_id'];
        $note['sender_name'] = $info['sender_name'];
        $note['owner_id'] = $info['owner_id'];
        $note['owner_name'] = $info['owner_name'];
        $note['product_id'] = $info['product_id'];
        $note['product_title'] = $info['product_title'];
        $note['type'] = $info['type'];
        $note['message'] = $info['message'];

        $notification[] = $note;
    }

    /*$pdo = ORM::get_db();
    $query = "UPDATE `".$config['db']['pre']."push_notification` SET `recd` = '1' WHERE `owner_id` = '" . $user_id . "' ";
    $pdo->query($query);*/

    return $results = $notification;
}


function add_firebase_notification($SenderName,$SenderId,$OwnerName,$OwnerId,$productId,$productTitle,$type,$message)
{
    global $config, $lang, $results;

    if($OwnerId){

        $insert_note = ORM::for_table($config['db']['pre'].'push_notification')->create();
        $insert_note->sender_name = $SenderName;
        $insert_note->sender_id = $SenderId;
        $insert_note->owner_name = $OwnerName;
        $insert_note->owner_id = $OwnerId;
        $insert_note->product_id = $productId;
        $insert_note->product_title = $productTitle;
        $insert_note->type = $type;
        $insert_note->message = $message;
        $insert_note->save();

        return $note_id = $insert_note->id();

    }else{
        return 0;
    }

}

function sendFCM($message,$user_id,$title=null,$sending_type = "one_user") {
    global $config;
    $title = ($title != null)? $title : $config['app_name'];

    if($sending_type == "all_user"){
        $result = ORM::for_table($config['db']['pre'].'firebase_device_token')
            ->select('token')
            ->where_not_equal('user_id', $user_id)
            ->find_many();
        if(isset($result)){
            $token = array();
            foreach($result as $info){
                $token[] = $info['token'];
            }
        }else{
            return;
        }
    }else{
        $result = ORM::for_table($config['db']['pre'].'firebase_device_token')
            ->select('token')
            ->where('user_id', $user_id)
            ->find_many();
        if(isset($result)){
            $token = array();
            foreach($result as $info){
                $token[] = $info['token'];
            }
        }else{
            return;
        }
    }

    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array (
        'registration_ids' => $token ,
        'notification' => array (
            "body" => $message,
            "title" => $title,
            "icon" => "myicon"
        )
    );

    $fields = json_encode ( $fields );
    $headers = array (
        'Authorization: key=' . $config['firebase_server_key'],
        'Content-Type: application/json'
    );
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    curl_close ( $ch );
}


function unread_chat_count(){
    global $config;

    $chat_count = ORM::for_table($config['db']['pre'].'messages')
        ->where($array = array(
            'to_id' => $_SESSION['user']['id'],
            'recd' => '0'
        ))
        ->count();

    return $chat_count;
}

function get_last_unread_message($limit) {
    global $config;

    $message = array();

    $result = ORM::for_table($config['db']['pre'].'messages')
        ->where('to_id', $_SESSION['user']['id'])
        ->order_by_asc('message_id')
        ->limit($limit)
        ->find_many();
    foreach ($result as $chat)
    {
        $info = get_user_data(null,$chat['from_id']);
        $picname = ($info['image'] == "")? "default_user.png" : $info['image'];
        $status  = ($info['online'] == "0")? "offline" : "online";
        $from_name = ($info['name'] != '')? $info['name'] : $info['username'];
        $chat['message_content'] = escape($chat['message_content']);

        if (strpos($chat['message_content'], 'file_name') !== false) {

        }
        else{
            // The Regular Expression filter
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,10}(\/\S*)?/";

            // Check if there is a url in the text
            if (preg_match($reg_exUrl, $chat['message_content'], $url)) {

                // make the urls hyper links
                $chat['message_content'] = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a>", $chat['message_content']);

            } else {
                // The Regular Expression filter
                $reg_exUrl = "/(www)\.[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,10}(\/\S*)?/";

                // Check if there is a url in the text
                if (preg_match($reg_exUrl, $chat['message_content'], $url)) {

                    // make the urls hyper links
                    $chat['message_content'] = preg_replace($reg_exUrl, "<a href='{$url[0]}'>{$url[0]}</a>", $chat['message_content']);

                }
            }
        }

        $timeago = timeAgo($chat['message_date']);
        $chatContent = stripslashes($chat['message_content']);


        $message[$chat['message_id']]['image'] = $picname;
        $message[$chat['message_id']]['status'] = $status;
        $message[$chat['message_id']]['from_name'] = $from_name;
        $message[$chat['message_id']]['message'] = strlimiter(strip_tags($chatContent),45);;
        $message[$chat['message_id']]['time'] = $timeago;
    }


    return $message;
}

/**
 * XOR encrypt/decrypt.
 *
 * @param string $str
 * @param string $password
 * @return string
 */
function quick_xor($str, $password = '')
{
    $len = strlen($str);
    $gamma = '';
    $n = $len > 100 ? 8 : 2;
    while (strlen($gamma) < $len) {
        $gamma .= substr(pack('H*', sha1($password . $gamma)), 0, $n);
    }

    return $str ^ $gamma;
}

/**
 * XOR encrypt with Base64 encode.
 *
 * @param string $str
 * @param string $password
 * @return string
 */
function quick_xor_encrypt($str, $password = '')
{
    return base64_encode(quick_xor($str, $password));
}

/**
 * XOR decrypt with Base64 decode.
 *
 * @param string $str
 * @param string $password
 * @return string
 */
function quick_xor_decrypt($str, $password = '')
{
    return quick_xor(base64_decode($str), $password);
}

function d($data){
    if(is_null($data)){
        $str = "<i>NULL</i>";
    }elseif($data == ""){
        $str = "<i>Empty</i>";
    }elseif(is_array($data)){
        if(count($data) == 0){
            $str = "<i>Empty array.</i>";
        }else{
            $str = "<table style=\"border-bottom:0px solid #000;\" cellpadding=\"0\" cellspacing=\"0\">";
            foreach ($data as $key => $value) {
                $str .= "<tr><td style=\"background-color:#008B8B; color:#FFF;border:1px solid #000;\">" . $key . "</td><td style=\"border:1px solid #000;\">" . d($value) . "</td></tr>";
            }
            $str .= "</table>";
        }
    } elseif(is_object($data)){
        $str = d(get_object_vars($data));
    }elseif(is_bool($data)){
        $str = "<i>" . ($data ? "True" : "False") . "</i>";
    }else{
        $str = $data;
        $str = preg_replace("/\n/", "<br>\n", $str);
    }
    return $str;
}

function dnl($data){
    echo d($data) . "<br>\n";
}

function dd($data){
    echo dnl($data);
    exit;
}

function ddt($message = ""){
    echo "[" . date("Y/m/d H:i:s") . "]" . $message . "<br>\n";
}