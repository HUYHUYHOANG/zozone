<?php
if (checkloggedin()) {

    if(isEmployer()){
        headerRedirect('./reservations'); exit;
    }

   // $settings = get_all_setting($_SESSION['user']['id']);
    $SHOP_MENU_REDUCED = 1;// $settings['shop_menu_reduced'];
    $ses_userdata = get_user_data($_SESSION['user']['username']);
    $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');
    $currency_data = get_currency_by_code($currency);

    $menu_lang = get_user_option($_SESSION['user']['id'], 'shop_menu_languages', '');
    $menu_lang = explode(',', $menu_lang);

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
    $extras = array();
    $category = array();
    $category_result = ORM::for_table($config['db']['pre'] . 'catagory_main')
    ->where('shop_id', $_SESSION['user']['shop_id'])
    ->order_by_asc('cat_order')
    ->find_many();
    $lcode = $config['lang_code'];
    foreach ($category_result as $info) {
        $catname = $info['cat_name'];
        $trans = json_decode($info['translation']);
        if($trans){
            if(isset($trans->{$lcode}) && isset($trans->{$lcode}->title)) $catname = $trans->{$lcode}->title;
        }
        $category[$info['cat_id']]['cat_id'] = $info['cat_id'];
        $category[$info['cat_id']]['cat_name'] = $catname;
        $category[$info['cat_id']]['selected'] = '';
    }

    $menu = array();
    $shop = ORM::for_table($config['db']['pre'] . 'shop')
        ->where('id', $_SESSION['user']['shop_id'])
        ->find_one();
    $service_action = '';
    if (isset($_GET['menu_id'])) {

        $extras_result = ORM::for_table($config['db']['pre'] . 'menu_extras')
        ->where(array('active'=> 1,'menu_id' => $_GET['menu_id']))
        ->order_by_asc('id')
        ->find_many();
    
    foreach ($extras_result as $info) {
        $extras[$info['id']]['id'] = $info['id'];
        $extras[$info['id']]['name'] = $info['title'];
        $extras[$info['id']]['price'] =  number_format($info['price'],2);
    }
        //edit menu
        $result = ORM::for_table($config['db']['pre'] . 'menu')
            ->where(array(
                'shop_id' => $_SESSION['user']['shop_id'],
                'id' => $_GET['menu_id']
            ))
            ->find_one();

        //$user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
        $user_lang = $config['lang_code']; 
        $json = json_decode($result['translation'], true);

        $response['name'] = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $result['name'];

        $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $result['description'];
        
        $response['description'] = stripcslashes($description);

        $response['price'] =number_format($result['price'],2);
        $response['type'] = $result['type'];
        $response['active'] = $result['active'];
        $response['discount_price'] = number_format($result['discount_price'],2);
        $response['is_new_food'] = $result['is_new_food'];
        $response['is_discount'] = $result['is_discount'];
        $response['menu_res_id'] = $result['menu_res_id'];
        $response['image'] = !empty($result['image'])
            ? $config['site_url'] . 'storage/menu/' . $result['image']
            : $config['site_url'] . 'storage/menu/' . 'default.png';
        $response['id'] =  $result['id'];
        $response['cat_id'] =  $result['cat_id'];
        $response['service_duration'] =  $result['service_duration'];
        $category[$result['cat_id']]['selected'] = 'selected';
        $service_action = 'update';
    }
    else
    {
        $response['name'] = '';
        $response['description'] = '';
        $response['price'] = '';
        $response['type'] = '';
        $response['active'] = '1';
        $response['discount_price'] = '';
        $response['is_new_food'] = '';
        $response['is_discount'] = '';
        $response['display_image'] = '';
        $response['service'] = 'kitchen';
        $response['menu_res_id'] = '';
        $response['image'] = $config['site_url'] . 'storage/menu/' . 'default.png';
        $response['id'] =  '';
        $response['cat_id'] =  $_GET['cat_id'];
        $response['service_duration'] = '';
        $category[$_GET['cat_id']]['selected'] = 'selected';
        $service_action = 'add';
    }
    if(isset($_GET['type']) && $_GET['type'] == "copy")
    {
    $response['id'] = '';
    $response['active'] = '0';
    $response['menu_res_id'] = '';
    $service_action = 'copy';
    }
    $page = new HtmlTemplate('templates/' . $config['tpl_name'] . '/edit-service.tpl');
    $page->SetParameter('OVERALL_HEADER', create_header($lang['MANAGE_MENU']));
    $rightMenu = '';
    $page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
    $page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
    
    $page->SetParameter('SHOW_LANGS', count($language));
    $page->SetParameter('SHOP_MENU_REDUCED',$SHOP_MENU_REDUCED);
    $page->SetParameter('MENU_NAME',  $response['name']);
    $page->SetParameter('MENU_DESCRIPTION',  $response['description']);
    $page->SetParameter('MENU_PRICE',  $response['price']);
    $page->SetParameter('MENU_SERVICE_DURATION',  $response['service_duration']);
    $page->SetParameter('MENU_TYPE',  $response['type']);
    $page->SetParameter('MENU_ACTIVE',  $response['active']);
    $page->SetParameter('MENU_DISCOUNT_PRICE',  $response['discount_price']);
    $page->SetParameter('MENU_IS_NEW_FOOD',  $response['is_new_food']);
    $page->SetParameter('MENU_IS_DISCOUNT',  $response['is_discount']);
    $page->SetParameter('MENU_DISPLAY_IMAGE',  $response['display_image']);
    $page->SetParameter('MENU_SERVICE',  $response['service']);
    $page->SetParameter('MENU_MENU_RES_ID',  $response['menu_res_id']);
    $page->SetParameter('MENU_IMAGE',  $response['image']);
    $page->SetParameter('MENU_IMAGE_COPY',  isset($result['image']) ? $result['image'] : '');
    $page->SetParameter('MENU_ID',  $response['id']);
    $page->SetParameter('MENU_CAT_ID',  $response['cat_id']);
    $page->SetParameter('SERVICE_ACTION',  $service_action);   
    $page->SetParameter('CUSTOM_CSS_FILES', '');
    $page->SetLoop('LANGS', $language);
    $page->SetLoop('EXTRAS', $extras);
    $page->SetLoop('CATEGORY',$category);
    $page->SetParameter('OVERALL_FOOTER', create_footer());
    $page->CreatePageEcho();
} 
else 
{
    headerRedirect($link['LOGIN']);
}
