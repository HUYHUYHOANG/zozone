<?php

/*use Google\Cloud\Translate\V2\TranslateClient;*/

/*if(!empty($_COOKIE['Quick_user_lang_code'])){
    $config['lang_code'] = $_COOKIE['Quick_user_lang_code'];
}
if(!empty($_COOKIE['Quick_user_lang'])){
    $config['lang'] = $_COOKIE['Quick_user_lang'];
}elseif(!empty($_COOKIE['Quick_lang'])){
    $config['lang'] = $_COOKIE['Quick_lang'];
}
*/
$user_lang = $config['lang_code'];


//check to register customer
if (isset($_POST['submit-register']) && $_POST['submit-register'] == 'submit-register') {
    if (empty($_POST["name"]))
        $_POST["name"] = $_POST["username"];

    $errors = 0;
    $type_error = '';
    $name_error = '';
    $username_error = '';
    $email_error = '';
    $password_error = '';
    $recaptcha_error = '';
    $name_length = strlen(utf8_decode($_POST['name']));
    if ($errors == 0) {
        $shop = ORM::for_table($config['db']['pre'] . 'shop')
            ->where('slug', $_POST['slug'])
            ->find_one();

        $confirm_id = get_random_id();
        $location = getLocationInfoByIp();
        $password = $_POST["password"];
        $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
        $now = date("Y-m-d H:i:s");
        $insert_user = ORM::for_table($config['db']['pre'] . 'customers')->create();
        $insert_user->status = '0';
        $insert_user->shop_id = $shop['id'];
        $insert_user->name = $_POST["name"];
        $insert_user->username = $_POST["username"];
        $insert_user->password_hash = $pass_hash;
        $insert_user->email = $_POST['email'];
        $insert_user->confirm = $confirm_id;
        $insert_user->created_at = $now;
        $insert_user->updated_at = $now;
        $insert_user->country = $location['country'];
        $insert_user->country_code = $location['countryCode'];
        $insert_user->save();

        $user_id = $insert_user->id();
        email_template("customer_signup_details", $user_id, $password);
        $loggedin = customerslogin($_POST['username'], $_POST['password'], $shop['id']);
        create_customers_session($loggedin, $_POST['slug']);
        headerRedirect($link['CUSTOMER_ACCOUNT_SETTING']);
        exit();
    }
}

//check if requesting a valid shop slug or ID
if (isset($_GET['slug']) || $_GET['id']) {
    $qr = explode('/', $_GET['slug']);
    $shopSlug = $qr[0];
    $shopOtherAction = count($qr)>1 ? $qr[1] : false;
    
    if (isset($_GET['id'])) {
        $shop = ORM::for_table($config['db']['pre'] . 'shop')->find_one($_GET['id']);
    } else {
        $shop = ORM::for_table($config['db']['pre'] . 'shop')->where('slug', $shopSlug)->find_one();        
    }
    
    if (isset($shop['name'])){
        //check if this is first time the shop loaded
        $firstTimeLoaded = $shop['slug'] . "_first_time_loaded";        
        if(isset($_GET['lang'])){
            
        }else{
            if(!isset($_SESSION[$firstTimeLoaded])){
                $_COOKIE['Quick_user_lang_code'] = 'de';
                $_COOKIE['Quick_user_lang'] = 'german';
                $_COOKIE['Quick_lang'] = 'german';
                $config['lang'] = 'german';
                $config['lang_code'] = 'de';
                $user_lang = $config['lang_code'];
                unset($lang);
                include("includes/lang/lang_german.php");            
                $_SESSION[$firstTimeLoaded] = 1;
            }
        }

        //save shop slug
        $config['shop_slug'] = $shop['slug'];

        $gszTemplate = 'index.tpl';
        $isBookingLading = 0;
        $isForgotPwd = 0;    
        define("LPCTSTR_TOKEN", 1);
        require('ctrls/customer-service.class.php');
        require('ctrls/lib/request.lib.php');
        require('ctrls/lib/codec.lib.php');
        $theCustomer = new CCustomerService($config['db']['pre']);

        if($shopOtherAction){
            CZozoneShopUtil::doTheAction($shopOtherAction, $shop->id);
        }

        $limit = "999";
        $allow_google_translate = get_module_settting($shop['id'], 'translate');
        $shop_menu_reduced = 1;
        $shop_setting_display_website = 1; //get_module_settting($shop['id'],'website');
        $shop_open_story  = $shop_setting_display_website == 1 ? get_shop_option($shop->id, 'shop_open_story', 1) : 0;
        $shop_open_banner  = $shop_setting_display_website == 1 ? get_shop_option($shop->id, 'shop_open_banner', 1) : 0;        
        $timer_cover_image = get_shop_option($shop->id, 'timer_cover_image', 5);
        $shop_display_group_image  = $shop_setting_display_website == 1 ? get_shop_option($shop->id, 'shop_display_group_image', 1) : 0;        
        $shop_open_contact  = $shop_setting_display_website == 1 ? get_shop_option($shop->id, 'shop_open_contact', 1) : 0;
        $shop_open_footer_image  = $shop_setting_display_website == 1 ? get_shop_option($shop->id, 'shop_open_footer_image', 1) : 0;
        $shop_display_price  = get_shop_option($shop->id, 'shop_display_price', 1);
        $shop_order_service  = get_shop_option($shop->id, 'shop_order_service', 1);

        $booking_show_staffs_list = get_shop_option($shop->id, 'booking_show_staffs_list', 0);
        $total_bookable_staffs = get_shop_option($shop->id, 'total_bookable_staffs', 1);

        $shopInfoJson = json_decode($shop['translation']);
        $langCode = $config['lang_code'];
        if($shopInfoJson && isset($shopInfoJson->{$langCode})){
            $tmpShopInfo = $shopInfoJson->{$langCode}; 
            $name = $tmpShopInfo->name;
            $sub_title = $tmpShopInfo->sub_title;
            $description = $tmpShopInfo->description;
        }else{
            $tmpShopInfo = new stdClass;
            $tmpShopInfo->name = $shop['name'];
            $tmpShopInfo->sub_title = $shop['sub_title'];
            $description = $shop['description']; //nl2br(stripcslashes($shop['description']));
            $description =  str_replace("<br>", " ", $description);
            $tmpShopInfo->description = $description;
        }
        
        $shop_id = $shop['id'];
        
        $address = $shop['address'];
        $mapLat = $shop['latitude'];
        $mapLong = $shop['longitude'];
        $main_image = $shop['main_image'];
        $cover_image = $shop['cover_image'];
        $slug = $shop['slug'];
        $email = $shop['email'];        

        $userdata = get_user_data(null, $shop['user_id']);
        //$email = $userdata['email'];
        $templates_setting = "all";
        $shop_template = "barber";  //"peerly";//get_shop_option($shop->id, 'shop_template', 'beautyzone');
 
        $category = array();
        $cat = array();

        $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
        $currency_data = get_currency_by_code($currency);
        $total_menus = $image_menu = array();

      
        //nail template c
        if($shop_template ==  "nail"){
            $count = 0;
            $menu_tpl_discount = '';
            $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                ->where_any_is(array(
                    array(
                        'is_new_food' => '1',
                        'shop_id' => $shop['id'],
                        'active' => '1'
                    ), array(
                        'is_discount' => '1', 'shop_id' => $shop['id'],
                        'active' => '1'
                    )
                ))
                ->where_not_equal('image', 'default.png')
                ->count();
            $menu_discount_count = $menu_count > 0 ? 1 : 0;
           
            if (1 || $menu_discount_count == "1") {
                $menu_tpl_discount = get_menu_tpl_by_cat_id_Nail_templates($menu_tpl_discount, '', true);
            }   
            $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where(array(
                    'shop_id' => $shop['id'],
                    'parent' => 0
                ))->order_by_asc('cat_order')->find_many();
            
            $idx = 0;
            $wowClasses = array('slideInLeft', 'slideInRight', 'fadeInUp');

            foreach ($result as $info) {

                //check menu
                $sub_menus = array();
                array_push($sub_menus, $info['cat_id']);
                $sub_menu_result =  ORM::for_table($config['db']['pre'] . 'catagory_main')
                    ->where(array(
                        'parent' => $info['cat_id'],
                        'shop_id' => $shop['id']
                    ))
                    ->find_many();

                foreach ($sub_menu_result as $sub_info) {
                    array_push($sub_menus, $sub_info->cat_id);
                }

                $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where(array(
                        'shop_id' => $shop['id'],
                        'active' => '1'
                    ))
                    ->where_in('cat_id', $sub_menus)
                    ->count();
                //end check
                if ($menu_count > 0) {                    
                    $json = json_decode($info['translation'], true);
                    $cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['cat_name'];
                    $description =  !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info['description'];

                    $category[$count]['image'] = CShopHelper::getCategoryImage($shop_id, $info['cat_id']);
                    $category[$count]['id'] = $info['cat_id'];
                    $category[$count]['name'] = ucfirst($cat_name);
                    $category[$count]['count'] = $count;
                    $cat[$count]['count'] = $count;
                    $cat[$count]['id'] = $info['cat_id'];
                    $cat[$count]['image'] = $info['picture'];
                    $cat[$count]['display_image'] = $info['display_image'];
                    $cat[$count]['description'] = nl2br($description);
                    $cat[$count]['name'] = ucfirst($cat_name);
                    $cat[$count]['wow_class_name'] = $wowClasses[$idx++ % 3] . " " . ($idx%2 ? "odd":"even");
                    $cat[$count]['background'] = $idx%2?'none':'#fafafa';
                    $cat[$count]['menu'] = '';
                    $menu_tpl = '';
                    if($shopOtherAction){                        
                        $category[$count]['service_items'] = CShopHelper::loadAllServices($info['cat_id'], 0, $user_lang);
                    }else{
                        $menu_tpl = get_menu_tpl_by_cat_id_Nail_templates($menu_tpl, $info['cat_id']);
                    }                    
                    $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                    $count++;
                }
            }
        }
        elseif($shop_template == "peerly")
        {
            $count = 0;
            $menu_tpl_discount = '';
            $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                ->where_any_is(array(
                    array(
                        'is_new_food' => '1',
                        'shop_id' => $shop['id'],
                        'active' => '1'
                    ), array(
                        'is_discount' => '1', 'shop_id' => $shop['id'],
                        'active' => '1'
                    )
                ))
                ->where_not_equal('image', 'default.png')
                ->count();
            $menu_discount_count = $menu_count > 0 ? 1 : 0;
           
            if (1 || $menu_discount_count == "1") {
                $menu_tpl_discount = get_menu_tpl_by_cat_id_peerly_templates($menu_tpl_discount, '', true);
            }   
            $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where(array(
                    'shop_id' => $shop['id'],
                    'parent' => 0
                ))->order_by_asc('cat_order')->find_many();
            
            $idx = 0;
            $wowClasses = array('slideInLeft', 'slideInRight', 'fadeInUp');

            foreach ($result as $info) {

                //check menu
                $sub_menus = array();
                array_push($sub_menus, $info['cat_id']);
                $sub_menu_result =  ORM::for_table($config['db']['pre'] . 'catagory_main')
                    ->where(array(
                        'parent' => $info['cat_id'],
                        'shop_id' => $shop['id']
                    ))
                    ->find_many();

                foreach ($sub_menu_result as $sub_info) {
                    array_push($sub_menus, $sub_info->cat_id);
                }

                $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where(array(
                        'shop_id' => $shop['id'],
                        'active' => '1'
                    ))
                    ->where_in('cat_id', $sub_menus)
                    ->count();
                //end check
                if ($menu_count > 0) {                    
                    $json = json_decode($info['translation'], true);
                    $cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['cat_name'];
                    $description =  !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info['description'];

                    $category[$count]['image'] = CShopHelper::getCategoryImage($shop_id, $info['cat_id']);
                    $category[$count]['id'] = $info['cat_id'];
                    $category[$count]['name'] = ucfirst($cat_name);
                    $category[$count]['count'] = $count;
                    $cat[$count]['count'] = $count;
                    $cat[$count]['left_or_right'] = ($count % 2 == 0 ? 'left' : 'right');
                    $cat[$count]['id'] = $info['cat_id'];
                    $cat[$count]['image'] = $info['picture'];
                    $cat[$count]['display_image'] = $info['display_image'];
                    $cat[$count]['description'] = nl2br($description);
                    $cat[$count]['name'] = ucfirst($cat_name);
                    $cat[$count]['wow_class_name'] = $wowClasses[$idx++ % 3] . " " . ($idx%2 ? "odd":"even");
                    $cat[$count]['background'] = $idx%2?'none':'#fafafa';
                    $cat[$count]['menu'] = '';
                    $menu_tpl = '';
                    if($shopOtherAction){                        
                        $category[$count]['service_items'] = CShopHelper::loadAllServices($info['cat_id'], 0, $user_lang);
                    }else{
                        $menu_tpl = get_menu_tpl_by_cat_id_peerly_templates($menu_tpl, $info['cat_id']);

                  
                    }                    
                    $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                    $count++;
                }
            }
        }
        elseif($shop_template == "barber")
        {

        }
        
        /*$menu_lang = get_user_option($shop['user_id'], 'shop_menu_languages', '');
        $menu_lang = explode(',', $menu_lang);*/
        $language = array();
        if(1) /* || !empty($menu_lang) && count($menu_lang) > 1)*/ {
            $menu_languages = ORM::for_table($config['db']['pre'] . 'languages')
                ->where('active', 1)
                ->order_by_asc('name')                
                ->find_many();

            foreach ($menu_languages as $info) {
                $language[$info['id']]['code'] = $info['code'];
                $language[$info['id']]['name'] = $info['name'];
                $language[$info['id']]['file_name'] = $info['file_name'];
            }
        }      


        //get open time 

        $open_time = '';
        $open_close_hour_result = ORM::for_table($config['db']['pre'] . 'open_close_hour')
            ->where('shop_id', $shop['id'])->find_many();
        $sOpenHour_1 = '';
        $sOpenHour_2 = '';
        $sOpenHour_3 = '';
        $sOpenHour_4 = '';
        $sOpenHour_5 = '';
        $sOpenHour_6 = '';
        $sOpenHour_7 = '';
        $sOpenHour_from_to = '';
        $sOpenHour_1_f = '';
        $sOpenHour_2_f = '';
        $sOpenHour_3_f = '';
        $sOpenHour_4_f = '';
        $sOpenHour_5_f = '';
        $sOpenHour_6_f = '';
        $sOpenHour_7_f = '';
        foreach ($open_close_hour_result as $info) {
            $text_open_close = $info['open_hour'] . ' - ' . $info['close_hour'];
            $text_open_close_2 = !empty($info['open_hour_2']) ? ' & ' . $info['open_hour_2'] . ' - ' . $info['close_hour_2'] : '';
            if ($info['is_from_to'] == "1") {
                $sOpenHour = get_day_of_week_string($info['day_of_week']);
                $sOpenHour_to = get_day_of_week_string($info['day_of_week_to']);
                $sOpenHour_from_to .=  $sOpenHour . " - " . $sOpenHour_to . ":" . $text_open_close . $text_open_close_2 . '<br>';
            } else {
                switch ($info['day_of_week']) {
                    case "sunday":
                        $sOpenHour_1 .= $sOpenHour_1 == '' ? $lang['SUNDAY'] . ':' . $text_open_close . $text_open_close_2 : ' & ' . $text_open_close . $text_open_close_2;
                        $sOpenHour_1_f .= $sOpenHour_1_f == '' ? $text_open_close . $text_open_close_2 : ' & ' . $text_open_close . $text_open_close_2;
                        break;
                    case "monday":
                        $sOpenHour_2 .= $sOpenHour_2 == '' ? $lang['MONDAY'] . ':' . $text_open_close . $text_open_close_2  : ' & ' . $text_open_close . $text_open_close_2;

                        $sOpenHour_2_f .= $sOpenHour_2_f == '' ? $text_open_close . $text_open_close_2  : ' & ' . $text_open_close . $text_open_close_2;
                        break;
                    case "tuesday":
                        $sOpenHour_3 .= $sOpenHour_3 == '' ? $lang['TUESDAY'] . ':' . $text_open_close . $text_open_close_2  : ' & ' . $text_open_close . $text_open_close_2;

                        $sOpenHour_3_f .= $sOpenHour_3_f == '' ? $text_open_close . $text_open_close_2  : ' & ' . $text_open_close . $text_open_close_2;
                        break;
                    case "wednesday":
                        $sOpenHour_4 .= $sOpenHour_4 == '' ? $lang['WEDNESDAY'] . ':' . $text_open_close  . $text_open_close_2  : ' & ' . $text_open_close . $text_open_close_2;

                        $sOpenHour_4_f .= $sOpenHour_4_f == '' ? $text_open_close  . $text_open_close_2  : ' & ' . $text_open_close . $text_open_close_2;
                        break;
                    case "thursday":
                        $sOpenHour_5 .= $sOpenHour_5 == '' ? $lang['THURSDAY'] . ':' . $text_open_close . $text_open_close_2   : ' & ' . $text_open_close . $text_open_close_2;

                        $sOpenHour_5_f .= $sOpenHour_5_f == '' ? $text_open_close . $text_open_close_2   : ' & ' . $text_open_close . $text_open_close_2;
                        break;
                    case "friday":
                        $sOpenHour_6 .= $sOpenHour_6 == '' ? $lang['FRIDAY'] . ':' . $text_open_close . $text_open_close_2   : ' & ' . $text_open_close . $text_open_close_2;

                        $sOpenHour_6_f .= $sOpenHour_6_f == '' ? $text_open_close . $text_open_close_2   : ' & ' . $text_open_close . $text_open_close_2;
                        break;
                    case "saturday":
                        $sOpenHour_7 .= $sOpenHour_7 == '' ? $lang['SATURDAY'] . ':' . $text_open_close . $text_open_close_2 : ' & ' . $text_open_close . $text_open_close_2;
                        $sOpenHour_7_f .= $sOpenHour_7_f == '' ? $text_open_close . $text_open_close_2 : ' & ' . $text_open_close . $text_open_close_2;
                        break;

                    default:
                        //'no nothing'
                        break;
                }
            }
        }
        $sOpenHour_1_f = $sOpenHour_1_f == '' ? $lang['CLOSE'] : $sOpenHour_1_f;
        $sOpenHour_2_f = $sOpenHour_2_f == '' ? $lang['CLOSE'] : $sOpenHour_2_f;
        $sOpenHour_3_f = $sOpenHour_3_f == '' ? $lang['CLOSE'] : $sOpenHour_3_f;
        $sOpenHour_4_f = $sOpenHour_4_f == '' ? $lang['CLOSE'] : $sOpenHour_4_f;
        $sOpenHour_5_f = $sOpenHour_5_f == '' ? $lang['CLOSE'] : $sOpenHour_5_f;
        $sOpenHour_6_f = $sOpenHour_6_f == '' ? $lang['CLOSE'] : $sOpenHour_6_f;
        $sOpenHour_7_f = $sOpenHour_7_f == '' ? $lang['CLOSE'] : $sOpenHour_7_f;
        $arr_open_time = array($sOpenHour_1, $sOpenHour_2, $sOpenHour_3, $sOpenHour_4, $sOpenHour_5, $sOpenHour_6, $sOpenHour_7);
        $sopen_time = '';
        foreach ($arr_open_time as $info) {
            if ($info != '') {
                if ($sopen_time == '') {
                    $sopen_time .= $info;
                } else {
                    $sopen_time .= ' | ' . $info;
                }
            }
        }
        $open_time = $sOpenHour_from_to . $sopen_time;
        //get image list
        //banner
        $banner_1 = '';
        $floatingBanner = ORM::for_table($config['db']['pre'] . 'shop_image')
                            ->where(array( 'shop_id' => $shop['id'], 'image_type' => 'banner', 'is_floating' => 1))->find_one();
        if($floatingBanner){
            $banner_1 = $floatingBanner['image'];
        } 

        $banner_result = ORM::for_table($config['db']['pre'] . 'shop_image')
            ->where(array(
                'shop_id' => $shop['id'], 'image_type' => 'banner'
            ))
            ->order_by_desc('is_floating')
            ->find_many();
            
        
        $banner_2 = 'default.png';
        if(!empty($banner_result[1]['image']))
        $banner_2 = $banner_result[1]['image'];

        if($banner_result){
            $bnimages = array();
            foreach($banner_result as $banner){
                if($banner['is_floating']) continue;
                $bnimages[$banner['id']] = array('image' => $banner['image']);
            }
            $banner_result = $bnimages;
        }

        //footer
        $footer_result = ORM::for_table($config['db']['pre'] . 'shop_image')
            ->where(array(
                'shop_id' => $shop['id'], 'image_type' => 'footer_image'
            ))
            ->order_by_asc('position')
            ->find_many();
        $footer_image = [];
        $path =  'storage/shop/footer/';
        foreach ($footer_result as $info2) {
            //if(!is_file($path.$info2['image'])) continue;
            $footer_image[$info2['id']]['id'] = $info2['id'];
            $footer_image[$info2['id']]['description'] = '';
            $footer_image[$info2['id']]['name'] = '';
            $footer_image[$info2['id']]['image'] = $info2['image'];
        }

        // group image

        $group_image_result = ORM::for_table($config['db']['pre'] . 'shop_image_group')
            ->where(array(
                'shop_id' => $shop['id'], 'active' => 1
            ))
            ->order_by_asc('position')
            ->find_many();
        $group_image = [];        
        foreach ($group_image_result as $info) {
            $json = json_decode($info['translation']);
            $image_group_name = $info['name'];
            if($json && isset($json->{$user_lang}) && isset($json->{$user_lang}->title)) $image_group_name = $json->{$user_lang}->title;
            $group_image[$info['id']]['id'] = $info['id'];
            $group_image[$info['id']]['name'] = $image_group_name;
        }

        $image_in_group = [];
        $image_in_group_result = ORM::for_table($config['db']['pre'] . 'shop_image')
        ->table_alias('si')
         ->left_outer_join($config['db']['pre'] . 'shop_image_group', array('sig.id', '=', 'si.group_id'), 'sig')
         ->where('sig.active',1)    
        ->where('si.shop_id', $shop['id'])
        ->where_gt('si.group_id',0)
        ->order_by_asc('si.position')
        ->select('si.*')
        ->find_many();

        foreach ($image_in_group_result as $info) {
            $image_in_group[$info['id']]['id'] = $info['id'];
            $image_in_group[$info['id']]['image'] = $info['image'];
            $image_in_group[$info['id']]['group_id'] = $info['group_id'];
        }


        $gmap_api_key = get_option("gmap_api_key");        
        
        $json = json_decode($text = get_shop_option($shop_id, 'shop_title_story'));
     
        $shop_title_story = $json && isset($json->{$user_lang}) ? $json->{$user_lang} : (isset($json->de) ? $json->de : '');
        
        $json = json_decode($text = get_shop_option($shop_id, 'shop_sub_title_story'));
        $shop_sub_title_story = $json && isset($json->{$user_lang}) ? $json->{$user_lang} : (isset($json->de) ? $json->de : '');

        $json = json_decode($text = get_shop_option($shop_id, 'shop_story'));        
        $shop_story = $json && isset($json->{$user_lang}) ? $json->{$user_lang} : (isset($json->de) ? $json->de : '');

        $json = json_decode($text = get_shop_option($shop_id, 'shop_popup_messages'));
        $shop_popup_message = $json && isset($json->{$user_lang}) ? $json->{$user_lang} : (isset($json->de) ? $json->de : '');

        //flat icon seting
        $flatIconCode = get_shop_option($shop_id, 'menu_flat_icon_code');
        if($flatIconCode) $flatIconCode = "\\" . $flatIconCode;

        if($shopOtherAction=='login' && $theCustomer->checkLoggedIn()){
            header("Location:" . $config['site_url'] . $shop_template); die;
            /*$gszTemplate = 'template-parts/booking-landing.html.php';
            $page = new HtmlTemplate('shop-templates/' . $shop_template . '/' . $gszTemplate);    
            $page->SetParameter('LOGGED_IN', 1);*/
        }else{            
            switch($shopOtherAction){
                case 'booking':
                    $gszTemplate = 'template-parts/booking-landing.html.php';
                    $page = new HtmlTemplate('shop-templates/' . $shop_template . '/' . $gszTemplate);
                    $isBookingLading = 1;
                    //booking style
                    $bookingStyle = get_shop_option($shop_id, 'shop_booking_template', 1);
                    $payViaPaypal = get_shop_option($shop_id, 'shop_pay_via_paypal', 0);
                    $payViaStripe = get_shop_option($shop_id, 'shop_pay_via_stripe', 0);
                    if($bookingStyle !=1 && $bookingStyle!=2) $bookingStyle=1;
                    if(!$payViaPaypal) $payViaPaypal = 0;
                    if(!$payViaStripe) $payViaStripe = 0;
                    $page->SetParameter('BOOKING_TEMPLATE_STYLE', $bookingStyle);
                    $page->SetParameter('PAYMENT_PAYPAL', $payViaPaypal);
                    $page->SetParameter('PAYMENT_STRIPE', $payViaStripe);
                    
                    break;
                case 'login':                
                    $gszTemplate = 'template-parts/login-landing.html.php';
                    $page = new HtmlTemplate('shop-templates/' . $shop_template . '/' . $gszTemplate);

                    $isForgotPwd = 1;                
                    $loginData = false;                
                    $theNextForm = 'login';
                    if(isset($_GET['forgot'])){
                        $mayChangePwd = $theCustomer->validateFogotPwdLink($loginData) ? 1 : 0;
                        if(1||$mayChangePwd){
                            $theNextForm = 'change-pwd';
                            $params = array( 'CUSTOMER_NAME' => $loginData->name, 'FIELD_FORGOT' => $loginData->forgot, 'FORGOT_ERROR' => $loginData->loginError,
                                            'FIELD_R' => $loginData->rand, 'FIELD_E' => CCodec::encode($loginData->email), 'FIELD_T' => $loginData->time);                        
                            $page->SetParameter ('CUSTOMER_FORM_CONTENT', CShopHelper::getCustomerCommonForm('change-pwd', $params));
                        }else{
                            $theNextForm = 'login';
                            $page->SetParameter ('CUSTOMER_FORM_CONTENT', CShopHelper::getCustomerCommonForm('login'));
                        }
                    }elseif(isset($_GET['forgot-pwd'])){
                        $theNextForm = 'forgot-pwd';
                        $page->SetParameter ('CUSTOMER_FORM_CONTENT', CShopHelper::getCustomerCommonForm('forgot-pwd'));
                    }elseif(isset($_GET['signup'])){
                        $theNextForm = 'signup';
                        $page->SetParameter ('CUSTOMER_FORM_CONTENT', CShopHelper::getCustomerCommonForm('signup'));
                    }
                    else{
                        $theNextForm = 'login';
                        $page->SetParameter ('CUSTOMER_FORM_CONTENT', CShopHelper::getCustomerCommonForm('login'));
                    }
                    $page->SetParameter ('THE_REQUEST_FORM', $theNextForm);
                    $page->SetParameter('SHOP_SLUG', $theCustomer->slug);
                    $page->SetParameter('RETURN_URL', CRequest::getStr('return'));
                    break;
                case "payment-result":                    
                    $page = new HtmlTemplate('shop-templates/'.$shop_template.'/template-parts/payment-result-landing.html.php');
                    if(isset($_GET['cancel'])) $page->SetParameter('PAYMENT_RESULT', $lang['ORDER_HAS_BEEN_CANCELLED']);
                    elseif(isset($_GET['success'])) $page->SetParameter('PAYMENT_RESULT', $lang['THANKS_FOR_YOUR_ORDER']);
                    break;
                case "privacy":
                    $page = new HtmlTemplate('shop-templates/'.$shop_template.'/template-parts/privacy-landing.html.php');
                    break;
                default:
                    $page = new HtmlTemplate('shop-templates/' . $shop_template . '/index.tpl');
            }

            $names = CRequest::splitName($theCustomer->name);
            
            $page->SetParameter('CUSTOMER_FNAME', $names[0]);
            $page->SetParameter('CUSTOMER_LNAME', $names[1]);
            $page->SetParameter('CUSTOMER_EMAIL', $theCustomer->email);
            $page->SetParameter('CUSTOMER_PHONE', $theCustomer->phone);
        }

        $shop_fore_color = get_shop_option($shop_id, 'shop_fore_color', '#FFF');
        $page->SetParameter('SHOP_MENU_FORE_COLOR', $shop_fore_color);

        $classic_shop_theme_color = get_shop_option($shop_id, 'shop_theme_color', $config['theme_color']);
        $classic_border_colors = array();
        list($r2, $g2, $b2) = sscanf($classic_shop_theme_color, "#%02x%02x%02x");
        $i = 0.01;
        while ($i <= 1) {
            $classic_border_colors["$i"]['id'] = str_replace('.', '_', $i);
            $classic_border_colors["$i"]['value'] = "rgba($r2,$g2,$b2,$i)";
            $i += 0.01;
        }
        $classic_border_colors[1]['id'] = 1;
        $classic_border_colors[1]['value'] = "rgba($r2,$g2,$b2,1)";
        $page->SetParameter('DEFAULT_LINK_COLOR', base64_encode($classic_border_colors[1]['value']));
        $page->setLoop('CLASSIC_COLOR', $classic_border_colors);
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

        $page->SetParameter('LOGGED_IN', $theCustomer->checkLoggedIn() ? 1 : 0);

        $page->SetLoop('COLORS', $colors);
        $page->SetParameter('OVERALL_HEADER', create_header($lang['SHOP']));
        $page->SetParameter('SITE_TITLE', $config['site_title']);
        $page->SetParameter('SHOW_LANGS', count($language));
        $page->SetLoop('LANGS', $language);
        $page->SetParameter('OPEN_CLOSE_HOUR', $open_time);
        $page->SetParameter('SHOP_TEMPLATE', $shop_template);
        $page->SetLoop('CATEGORY', $category);
        $page->SetLoop('CATEGORY_2', $category);
        $page->SetLoop('CAT_MENU', $cat); 
        $page->SetLoop('CAT_MENU_2', $cat);        
        $page->SetParameter('CAT_MENU_DISCOUNT', $menu_tpl_discount);

        $page->SetParameter('SHOP_ID', $shop_id);
        $page->SetParameter('NAME', $tmpShopInfo->name);
        $page->SetParameter('SUB_TITLE', $tmpShopInfo->sub_title);
        $page->SetParameter('SHOP_DESCRIPTION', $tmpShopInfo->description);
        $page->SetParameter('ADDRESS', $address);
        $page->SetParameter('PHONE', $shop['phone_number']);
        $page->SetParameter('EMAIL', $email);
        $page->SetParameter('SLUG', $slug);
        $page->SetParameter('MAIN_IMAGE', $main_image);
        $page->SetParameter('LATITUDE', $mapLat);
        $page->SetParameter('LONGITUDE', $mapLong);
        $page->SetParameter('MAP_COLOR', $config['map_color']);
        $page->SetParameter('ZOOM', $config['home_map_zoom']);
        $page->SetParameter('CURRENCY_SIGN', $currency_data['html_entity']);
        $page->SetParameter('CURRENCY_LEFT', $currency_data['in_left']);
        $page->SetParameter('CURRENCY_DECIMAL_PLACES', $currency_data['decimal_places']);
        $page->SetParameter('CURRENCY_DECIMAL_SEPARATOR', $currency_data['decimal_separator']);
        $page->SetParameter('CURRENCY_THOUSAND_SEPARATOR', $currency_data['thousand_separator']);
        $page->SetParameter('TOTAL_MENUS', json_encode($total_menus));
        $page->SetParameter('PAGE_TITLE', $name);
        $page->SetParameter('PAGE_LINK', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $page->SetParameter('PAGE_META_KEYWORDS', $config['meta_keywords']);
        $page->SetParameter('PAGE_META_DESCRIPTION', $config['meta_description']);
        $page->SetParameter('LANGUAGE_DIRECTION', get_current_lang_direction());
        $page->SetParameter('GMAP_API_KEY', $gmap_api_key);
        $page->SetParameter('OPEN_HOUR_1', $sOpenHour_1_f);
        $page->SetParameter('OPEN_HOUR_2', $sOpenHour_2_f);
        $page->SetParameter('OPEN_HOUR_3', $sOpenHour_3_f);
        $page->SetParameter('OPEN_HOUR_4', $sOpenHour_4_f);
        $page->SetParameter('OPEN_HOUR_5', $sOpenHour_5_f);
        $page->SetParameter('OPEN_HOUR_6', $sOpenHour_6_f);
        $page->SetParameter('OPEN_HOUR_7', $sOpenHour_7_f);
        $page->SetParameter('SHOP_BACKGROUND_IMAGE', get_shop_option($shop_id, 'shop_background_image', 'default.jpg'));
        $page->SetParameter('MENU_FLAT_ICON_CODE', $flatIconCode);

        /*
        // customer
        $page->SetParameter('CUSTOMER_ID', '');
        $page->SetParameter('CUSTOMER_USERNAME', '');
        $page->SetParameter('CUSTOMER_NAME', '');
        $page->SetParameter('CUSTOMER_PHONE', '');
        $page->SetParameter('CUSTOMER_EMAIL', '');
        $page->SetParameter('CUSTOMER_ADDRESS', '');
        $page->SetParameter('CUSTOMER_HOUSE_NUMBER', '');
        $page->SetParameter('CUSTOMER_STREET_NAME', '');
        $page->SetParameter('CUSTOMER_CITY', '');
        $page->SetParameter('CUSTOMER_ZIP_CODE', '');
        $page->SetParameter('CUSTOMER_MESSAGE',  '');
        $page->SetParameter('CUSTOMER_TAKEAWAY_DELIVERY_TIME', '');
        //end customer
        */

        $page->SetParameter('SHOP_LINK_TWITTER', get_shop_option($shop_id, 'shop_link_twitter'));
        $page->SetParameter('SHOP_LINK_FACEBOOK', get_shop_option($shop_id, 'shop_link_facebook'));
        $page->SetParameter('SHOP_LINK_INSTAGRAM', get_shop_option($shop_id, 'shop_link_instagram'));

        $page->SetParameter('BANNER_1', $banner_1);
        $page->SetParameter('BANNER_2', $banner_2);        
        
        // $page->SetLoop('BANNER_IMAGE', $banner_image);
        //********************************************************************/
        $randomString = hash('sha256', CShopHelper::randomStr(), false);
        $_SESSION['SHOP_RANDOM_TOKEN'] = $randomString;
        $_SESSION['SHOP_ID'] = $shop_id;
        $_SESSION['DEFAULT_TIME_ZONE'] = $timezone;
        $staffs = 0;
        CShopHelper::loadStaffsList($shop_id, $staffs, 0);
        if($staffs){
            $page->SetLoop('STAFFS_LIST', $staffs);
            $page->SetLoop('STAFFS_LIST_2', $staffs);
        }

        $page->SetParameter('BOOKING_SHOW_STAFFS_LIST', $booking_show_staffs_list);
        $page->SetParameter('TOTAL_BOOKABLE_STAFFS', $total_bookable_staffs);

        $page->SetParameter('SHOP_ID', $shop_id);
        $page->SetParameter('SHOP_RANDOM_TOKEN', $randomString);
        $page->SetParameter('SHOP_TIME_NOW', date('YmdHis'));        
        if($shopOtherAction){
            if(!isset($_SESSION['SHOP_BOOKING_TOKEN'])){
                $bookingKey = hash('sha256', CShopHelper::randomStr(), false);
                $_SESSION['SHOP_BOOKING_TOKEN'] = $bookingKey;
            }else $bookingKey = $_SESSION['SHOP_BOOKING_TOKEN'];
            $page->SetParameter('SHOP_BOOKING_TOKEN', $bookingKey);
        }else $page->SetParameter('SHOP_BOOKING_MODAL_TEMPLATE_FILE', CShopHelper::loadBookingModalTemplate($shop_id));

        $staffs = 0;
        CShopHelper::loadStaffsList($shop_id, $staffs);
        $page->SetLoop('OUR_STAFFS', $staffs);
        // var_dump(count($staffs));
        //  die();

        //********************************************************************/
        //updated at 10-26-2022, 15:49PM
        //banner type: slider, video        
        /*if($shop->id==5){
            update_shop_option($shop->id, 'shop_banner_type', 'video');
            update_shop_option($shop->id, 'shop_banner_video_filename', 'shop-nail-4-spa.mp4');
        }*/
        $shop_banner_type = get_shop_option($shop->id, 'shop_banner_type', 'slider');
        if($shop_banner_type!='slider' && $shop_banner_type!='video') $shop_banner_type = 'slider';
        $banner_video_file = false;
        if($shop_banner_type=="video"){
            $shop_banner_video_filename = get_shop_option($shop->id, 'shop_banner_video_filename', false);            
            $banner_video_file = __DIR__ . "/../storage/videos/" . $shop_banner_video_filename;
            if(!is_file($banner_video_file)){
                $shop_banner_type = 'slider';
                $banner_video_file = false;                
            }else{
                $page->SetParameter('SHOP_BANNER_VIDEO_MIME_TYPE', mime_content_type($banner_video_file));
                $page->SetParameter('SHOP_BANNER_VIDEO_URI', $config['site_url']."storage/videos/" . $shop_banner_video_filename);
            }            
        }        
        $page->SetParameter('SHOP_BANNER_TYPE', $shop_banner_type);

        //end updated 10-26-2022, 15:49PM
        //********************************************************************/

        $page->SetParameter('CURRENT_LANGUAGE_CODE', $config['lang_code']);
        $page->SetParameter('CURRENT_LANGUAGE_NAME', $config['lang']);

        $page->SetLoop('BANNER_IMAGES', $banner_result);

        //font settings
        $fontSettingData = CShopHelper::getAllFontSettings($shop['id'], $config['site_url'].'storage/user-fonts/');
        $page->SetParameter('CUSTOM_SETTING_FONT_FACES_AND_CLASSES', '<style>'.$fontSettingData['font-face'].$fontSettingData['css'].'</style>');

        //********************************************************************/

        $page->SetLoop('FOOTER_IMAGE', $footer_image);
        $page->SetLoop('GROUP_IMAGE', $group_image);
        $page->SetLoop('IMAGE_IN_GROUP', $image_in_group);
        $page->SetParameter('SHOP_OPEN_STORY', $shop_open_story);
        $page->SetParameter('SHOP_OPEN_BANNER', $shop_open_banner);
        $page->SetParameter('SHOP_OPEN_BANNER_CHANGE_TIME', $timer_cover_image);
        $page->SetParameter('SHOP_DISPLAY_GROUP_IMAGE', $shop_display_group_image);
        $page->SetParameter('SHOP_OPEN_CONTACT', $shop_open_contact);
        $page->SetParameter('SHOP_OPEN_FOOTER_IMAGE', $shop_open_footer_image);
        $page->SetParameter('SHOP_DISPLAY_PRICE', $shop_display_price);
        $page->SetParameter('SHOP_ORDER_SERVICE', $shop_order_service);
        $page->SetParameter('SHOP_TITLE_STORY', $shop_title_story);
        $page->SetParameter('SHOP_SUB_TITLE_STORY', $shop_sub_title_story);
        $page->SetParameter('SHOP_STORY', $shop_story);
        $page->SetParameter('STORY_IMAGE', get_shop_option($shop_id, 'shop_outstanding_service_image', 'default.png'));
        $page->SetParameter('SHOP_SECOND_POPUP', get_shop_option($shop_id, 'shop_second_popup', 0));
        $page->SetParameter('SHOP_POPUP_MESSAGES_ON_OFF', get_shop_option($shop_id, 'shop_popup_messages_on_off', 0));
        
        $page->SetParameter('SHOP_SPECIAL_OFFER_DISPLAY', get_shop_option($shop_id, 'shop_display_special_offer', 0));
        $page->SetParameter('SHOP_OUR_STAFFS_DISPLAY', get_shop_option($shop_id, 'shop_display_our_staffs', 0));
        
        $page->SetParameter('SHOP_POPUP_MESSAGES', $shop_popup_message);
        $page->SetParameter('OVERALL_FOOTER', create_footer());
        $page->CreatePageEcho(0);    
    } else {        
        error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
        exit();        
    }
} else {
    //error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
    header("Location:{$config['site_url']}");
    exit();
}


//************************************************************************************** */
//**updated 2022-11-20 22:10PM - ihoapm@gmail.com */
class CZozoneShopUtil{
    public static function doTheAction($action, $shopId){        
        $className = "CZozoneShop{$action}";
        if(class_exists($className)){
            $obj = new $className($shopId);
        }
    }
}

class CZozoneShopPrivacy{
    public function __construct($shopId){

    }
}

class CZozoneShopBooking{
    public function __construct($shopId){
        if(CRequest::getStr("do")=="add-item"){
            $id = CRequest::getNbr("item");
            
            if($id>0){
                define("LPCTSTR_TOKEN", 1);
                require_once("ctrls/booking-cart.class.php");
                $sql = "SELECT id, name, service_duration, is_discount, translation,
                        IF(discount_price, discount_price, price) AS price, 
                        IF(discount_price, price - discount_price, 0) AS discount_price FROM qr_menu WHERE id={$id}";
                
                $item = ORM::forTable('')->rawQuery($sql)->findOne();
                if(!$item){
                    return;
                }
                global $user_lang;
                
                $item = (object)$item;
                $json = json_decode($item->translation);
                if(isset($json->{$user_lang}->title)) $name = $json->{$user_lang}->title;
                else $name = $item->name;
                $data = array('id'=> $item->id, 'name' => $name, 'duration' => $item->service_duration, 'price' => $item->price, 'discount' => $item->discount_price);
                
                $cart = new TheBookingC2rt($shopId);
                $cart->add($id, $data);
            }
        }
    }
}

class CZozoneShopLogin{    
    public function __construct($shopId){
        if(CRequest::getStr("logout")=="true"){
            self::logout();
        }        
    }

    private static function logout(){
        global $config;        
        global $theCustomer;
        $returnUrl = CRequest::getStr('return');
        $theCustomer->logMeOut();        
        if($returnUrl=='booking'){
            $returnUrl = $config['site_url'].$config['shop_slug'].'/'.$returnUrl;
            header("Location:{$returnUrl}");
            die;
        }
    }
}