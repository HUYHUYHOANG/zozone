<?php
if (checkloggedin()) {
    $settings = get_all_setting($_SESSION['user']['id']);
    $RESTAURANT_MENU_REDUCED = $settings['restaurant_menu_reduced'];
    $ses_userdata = get_user_data($_SESSION['user']['username']);
    $currency = !empty($ses_userdata['currency']) ? $ses_userdata['currency'] : get_option('currency_code');
    $currency_data = get_currency_by_code($currency);

    $menu_lang = get_user_option($_SESSION['user']['id'], 'restaurant_menu_languages', '');
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
    $menu = array();
    $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
        ->where('user_id', $_SESSION['user']['id'])
        ->find_one();
    //get list Allegie
    $Allegies = ORM::for_table($config['db']['pre'] . 'allegie')
    ->where_any_is(array(
        array('restaurant_id' => $restaurant['id']),
        array('is_default' => '1')))
        ->find_many();
    $result_allegie = array();
    foreach ($Allegies as $info) {
        $result_allegie[$info['id']]['id'] = $info['id'];
        $result_allegie[$info['id']]['alle_aliases'] = $info['alle_aliases'];
        $result_allegie[$info['id']]['alle_name'] = $info['alle_name'];
        $result_allegie[$info['id']]['image'] = $info['image'];
        $result_allegie[$info['id']]['selected'] = '';
    }
    //get list additives
    $additives = ORM::for_table($config['db']['pre'] . 'additives')
        ->where_any_is(array(
            array('restaurant_id' => $restaurant['id']),
            array('is_default' => '1')))
        ->find_many();
    $result_additives = array();
    foreach ($additives as $info) {
        $result_additives[$info['id']]['id'] = $info['id'];
        $result_additives[$info['id']]['additives_aliases'] = $info['additives_aliases'];
        $result_additives[$info['id']]['additives_name'] = $info['additives_name'];
        $result_additives[$info['id']]['selected'] = '';
    }
    //get list properties
    $properties = ORM::for_table($config['db']['pre'] . 'properties')
        ->where_any_is(array(
        array('restaurant_id' => $restaurant['id']),
        array('is_default' => '1')))
        ->find_many();
    $result_properties = array();
    foreach ($properties as $info) {
        $result_properties[$info['id']]['id'] = $info['id'];
        $result_properties[$info['id']]['properties_name'] = $info['properties_name'];
        $result_properties[$info['id']]['image'] = $info['image'];
        $result_properties[$info['id']]['selected'] = '';
    }
    $crush_action = '';
    if (isset($_GET['menu_id'])) {
        //edit menu
        $result = ORM::for_table($config['db']['pre'] . 'menu')
            ->where(array(
                'user_id' => $_SESSION['user']['id'],
                'id' => $_GET['menu_id']
            ))
            ->find_one();
        $menu_allegie_result = ORM::for_table($config['db']['pre'] . 'allegie_menu')
            ->where('menu_id', $_GET['menu_id'])
            ->find_many();
        foreach ($menu_allegie_result as $Allegie) {
            $result_allegie[$Allegie['alle_id']]['selected'] = 'selected';
        }

        $menu_additives_result = ORM::for_table($config['db']['pre'] . 'additives_menu')
            ->where('menu_id', $_GET['menu_id'])
            ->find_many();
   
        foreach ($menu_additives_result as $additives) {
            $result_additives[$additives['additive_id']]['selected'] = 'selected';
        }

        $menu_properties_result = ORM::for_table($config['db']['pre'] . 'properties_menu')
            ->where('menu_id', $_GET['menu_id'])
            ->find_many();
        $properties_list = array();
        foreach ($menu_properties_result as $properties) {
            $result_properties[$properties['properties_id']]['selected'] = 'selected';
        }

        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
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
        $response['display_image'] = $result['display_image'];
        $response['service'] = $result['service_department'];
        $response['menu_res_id'] = $result['menu_res_id'];
        $response['image'] = !empty($result['image'])
            ? $config['site_url'] . 'storage/menu/' . $result['image']
            : $config['site_url'] . 'storage/menu/' . 'default.png';
        $response['id'] =  $result['id'];
        $response['cat_id'] =  $result['cat_id'];
        $crush_action = 'update';
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
        $crush_action = 'add';
    }
    if(isset($_GET['type']) && $_GET['type'] == "copy")
    {
    $response['id'] = '';
    $response['active'] = '0';
    $response['menu_res_id'] = '';
    $crush_action = 'coppy';
    }
    $page = new HtmlTemplate('templates/' . $config['tpl_name'] . '/crush_menu.tpl');
    $page->SetParameter('OVERALL_HEADER', create_header($lang['MANAGE_MENU']));
    $page->SetParameter('SHOW_LANGS', count($language));
    $page->SetParameter('RESTAURANT_MENU_REDUCED',$RESTAURANT_MENU_REDUCED);
    $page->SetParameter('MENU_NAME',  $response['name']);
    $page->SetParameter('MENU_DESCRIPTION',  $response['description']);
    $page->SetParameter('MENU_PRICE',  $response['price']);
    $page->SetParameter('MENU_TYPE',  $response['type']);
    $page->SetParameter('MENU_ACTIVE',  $response['active']);
    $page->SetParameter('MENU_DISCOUNT_PRICE',  $response['discount_price']);
    $page->SetParameter('MENU_IS_NEW_FOOD',  $response['is_new_food']);
    $page->SetParameter('MENU_IS_DISCOUNT',  $response['is_discount']);
    $page->SetParameter('MENU_DISPLAY_IMAGE',  $response['display_image']);
    $page->SetParameter('MENU_SERVICE',  $response['service']);
    $page->SetParameter('MENU_MENU_RES_ID',  $response['menu_res_id']);
    $page->SetParameter('MENU_IMAGE',  $response['image']);
    $page->SetParameter('MENU_ID',  $response['id']);
    $page->SetParameter('MENU_CAT_ID',  $response['cat_id']);
    $page->SetParameter('CRUSH_ACTION',  $crush_action);   
    $page->SetLoop('LANGS', $language);
    $page->SetLoop('ALLEGIE', $result_allegie);
    $page->SetLoop('ADDITIVES', $result_additives);
    $page->SetLoop('PROPERTIES', $result_properties);
    $page->SetParameter('OVERALL_FOOTER', create_footer());
    $page->CreatePageEcho();
} 
else 
{
    headerRedirect($link['LOGIN']);
}
