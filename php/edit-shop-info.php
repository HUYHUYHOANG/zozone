<?php
if (checkloggedin()) {

    if(isEmployer()){
        headerRedirect('./reservations'); exit;
    }
    
    $shop = ORM::for_table($config['db']['pre'] . 'shop')
        ->where('id', $_SESSION['user']['shop_id'])
        ->find_one();    
    $errors = array();
    $user_lang = $config['lang_code'];

    if (isset($_POST['submit'])) {

        if (empty($_POST['name'])) {
            $errors[]['message'] = $lang['SHOP_NAME_REQ'];
        }
        if (empty($_POST['slug'])) {
            $errors[]['message'] = $lang['SHOP_SLUG_REQ'];
        } else if (!preg_match('/^[a-z0-9]+(-?[a-z0-9]+)*$/i', $_POST['slug'])) {
            $errors[]['message'] = $lang['SHOP_SLUG_INVALID'];
        } else {
            $count = ORM::for_table($config['db']['pre'] . 'shop')
                ->where('slug', $_POST['slug'])
                ->where_not_equal('id', $_SESSION['user']['shop_id'])
                ->count();

               
            // check row exist
            if ($count) {
                $errors[]['message'] = $lang['SHOP_SLUG_NOT_EXIST'];
            } else if (in_array($config['site_url'] . $_POST['slug'], $link)) {
                $errors = $lang['SLUG_NOT_EXIST'];
            }
        }
        if (empty($_POST['address'])) {
            $errors[]['message'] = $lang['SHOP_ADDRESS_REQ'];
        }
        if (empty($_POST['email'])) {
            $errors[]['email'] = $lang['ENTEREMAIL'];
        }else{
            if(!preg_match("|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i", $_POST['email'])){
                $errors[]['email'] = $lang['EMAILINV'];
            }
        }

        if (count($errors) == 0) {
            $now = date("Y-m-d H:i:s");
            $shopName = validate_input($_POST['name']);
            $shopSubTitle = validate_input($_POST['sub_title']);
            $shopDesc = validate_input($_POST['description']);
            
            require('ctrls/bo/CFr3eGoogl3Translat3.class.php');
            require('ctrls/lib/request.lib.php');
            $ggtl = new CFr3eGoogl3Translat3();

            if (isset($shop['id'])) {
                $shop_update = ORM::for_table($config['db']['pre'] . 'shop')
                    ->where('id', $_SESSION['user']['shop_id'])
                    ->find_one();
                $json = (array)json_decode($shop_update['translation']);
                $langs = JsonHelper::getActiveLangCodes();
                //translate from DE to other languages
                if($user_lang=='de'){                    
                    foreach($langs as $langCode){
                        if($langCode=='de') continue;
                        $json[$langCode] = array(
                                            'name' => $ggtl->translate('de', $langCode, $shopName),
                                            'sub_title' => $ggtl->translate('de', $langCode, $shopSubTitle),
                                            'description' => $ggtl->translate('de', $langCode, $shopDesc)
                                        );
                    }
                }
                //otherwise just update shop info in current language
                $json[$user_lang] = (object)array( 'name' => $shopName, 'sub_title' => $shopSubTitle, 'description' => $shopDesc );

                
                $shop_id = $shop_update['id'];
                $shop_update->set('name', $shopName);
                $shop_update->set('slug', validate_input($_POST['slug']));
                $shop_update->set('sub_title', $user_lang=='de' ? $shopSubTitle : $json['de']->sub_title);
                $shop_update->set('description', $user_lang=='de' ? $shopDesc : $json['de']->description);
                $shop_update->set('translation', json_encode($json, JSON_UNESCAPED_UNICODE));
                $shop_update->set('house_number', validate_input($_POST['house_number']));
                $shop_update->set('street_name', validate_input($_POST['street_name']));
                $shop_update->set('latitude', validate_input($_POST['latitude']));
                $shop_update->set('longitude', validate_input($_POST['longitude']));
                $shop_update->set('zipcode', validate_input($_POST['zipcode']));
                $shop_update->set('city', validate_input($_POST['city']));
                $shop_update->set('phone_number', validate_input($_POST['phone_number']));
                $shop_update->set('taxcode', validate_input($_POST['taxcode']));                
                $shop_update->set('address', validate_input($_POST['address']));
                $shop_update->set('email', validate_input($_POST['email']));
                $shop_update->save();   
                
            
            } else {
                $json = array();
                $langs = JsonHelper::getActiveLangCodes();
                $pos = array_search($user_lang, $langs);
                if($pos !== false) unset($langs[$pos]);
                foreach($langs as $desc_lang){
                    $json[$desc_lang] = array(  'name' => $ggtl->translate($user_lang, $desc_lang, $shopName),
                                                'sub_title' => $ggtl->translate($user_lang, $desc_lang, $shopSubTitle),
                                                'description' => $ggtl->translate($user_lang, $desc_lang, $shopDesc)
                                            );
                }
                $json[$user_lang] = array( 'name' => $shopName, 'sub_title' => $shopSubTitle, 'description' => $shopDesc );

                $insert_shop = ORM::for_table($config['db']['pre'] . 'shop')->create();
                $insert_shop->user_id = validate_input($_SESSION['user']['id']);
                $insert_shop->name = ($user_lang=='de' ? $shopName : $json['de']['name']);
                $insert_shop->slug = validate_input($_POST['slug']);
                $insert_shop->sub_title = ($user_lang=='de' ? $shopSubTitle : $json['de']['sub_title']);
                $insert_shop->description = ($user_lang=='de' ? $shopDesc : $json['de']['description']);
                $insert_shop->translation = json_encode($json, JSON_UNESCAPED_UNICODE);
                $insert_shop->house_number = validate_input($_POST['house_number']);
                $insert_shop->street_name =  validate_input($_POST['street_name']);
                $insert_shop->latitude = validate_input($_POST['latitude']);
                $insert_shop->longitude = validate_input($_POST['longitude']);
                $insert_shop->zipcode = validate_input($_POST['zipcode']);
                $insert_shop->city = validate_input($_POST['city']);
                $insert_shop->phone_number = validate_input($_POST['phone_number']);
                $insert_shop->taxcode = validate_input($_POST['taxcode']);                
                $insert_shop->address = validate_input($_POST['address']);
                $insert_shop->email = validate_input($_POST['email']);
                $insert_shop->created_at = $now;      
                $insert_shop->save();
                $shop_id = $insert_shop->id();
              }                
            update_shop_option($shop_id, 'shop_link_twitter', $_POST['shop_link_twitter']);
            update_shop_option($shop_id, 'shop_link_facebook', $_POST['shop_link_facebook']);
            update_shop_option($shop_id, 'shop_link_instagram', $_POST['shop_link_instagram']);
            
           transfer($link['WEBSITE'], $lang['SAVED_SUCCESS'], $lang['SAVED_SUCCESS']);
            exit;
        }
        // 
    }

    if (isset($shop['user_id'])) {
        $shop_id = $shop['id'];
        $name = $shop['name'];
        $slug = $shop['slug'];
        $sub_title = $shop['sub_title'];
        $taxcode = $shop['taxcode'];
        $house_number = $shop['house_number'];
        $street_name = $shop['street_name'];
        $latitude = $shop['latitude'];
        $longitude = $shop['longitude'];
        $zipcode = $shop['zipcode'];
        $city = $shop['city'];
        $phone_number = $shop['phone_number'];
        $description = stripcslashes(nl2br($shop['description']));
        $address = $shop['address'];
        $email = $shop['email'];
        $mapLat = $shop['latitude'];
        $mapLong = $shop['longitude'];
        
        $shopTranslation = (array)json_decode($shop['translation']);

        if (!empty($slug)) {
            $shop_link = $config['site_url'] . $slug;
        } else {
            $shop_link = $link['SHOP'] . '/' . $shop_id;
        }

    } else {
        $shop_id = '';
        $name = '';
        $slug = '';
        $sub_title = '';
        $taxcode = '';
        $house_number = '';
        $street_name = '';
        $zipcode = '';
        $city = '';
        $phone_number = '';
        $description = '';
        $address = '';
        $email = '';
        $mapLat     =  get_option("home_map_latitude");
        $mapLong    =  get_option("home_map_longitude");
        $shop_link = '#';
        $shopTranslation = 0;
    }
    // Get usergroup details
    $group_id = get_user_group();
    
    
    $page = new HtmlTemplate('templates/' . $config['tpl_name'] . '/edit-shop.tpl');
    $rightMenu = '';
    $page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));    
    $page->SetParameter('OVERALL_HEADER', create_header($lang['MANAGE_RESTAURANT']));
    $page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
    
    $page->SetParameter('SITE_TITLE', $config['site_title']);
    if (count($errors) > 0) {
        $page->SetLoop('ERRORS', $errors);
    } else {
        $page->SetLoop('ERRORS', "");
    }

    $page->SetParameter('SHOP_LINK_TWITTER', get_shop_option($shop_id, 'shop_link_twitter'));
    $page->SetParameter('SHOP_LINK_FACEBOOK', get_shop_option($shop_id, 'shop_link_facebook'));
    $page->SetParameter('SHOP_LINK_INSTAGRAM', get_shop_option($shop_id, 'shop_link_instagram'));

    $page->SetParameter('STREET_NAME', $street_name);
    $page->SetParameter('HOUSE_NUMBER', $house_number);
    $page->SetParameter('ZIPCODE', $zipcode);
    $page->SetParameter('CITY', $city);
    $page->SetParameter('PHONE_NUMBER', $phone_number);
    $page->SetParameter('TAXCODE', $taxcode);

    $page->SetParameter('ALLOW_ORDERING', $allow_order);
    $page->SetParameter('SHOP_LINK', $shop_link);
    $page->SetParameter('SHOP_ID', $shop_id);
    $page->SetParameter('NAME', $shopTranslation && isset($shopTranslation[$user_lang]) && isset($shopTranslation[$user_lang]->name) ? $shopTranslation[$user_lang]->name : $name);
    $page->SetParameter('SLUG', $slug);
    $page->SetParameter('SUB_TITLE', $shopTranslation && isset($shopTranslation[$user_lang]) && isset($shopTranslation[$user_lang]->sub_title) ? $shopTranslation[$user_lang]->sub_title : $sub_title);
    $page->SetParameter('SHOP_DESCRIPTION', $shopTranslation && isset($shopTranslation[$user_lang]) && isset($shopTranslation[$user_lang]->description) ? $shopTranslation[$user_lang]->description : $description);
    $page->SetParameter('ADDRESS', $address);
    $page->SetParameter('LATITUDE', $mapLat);
    $page->SetParameter('LONGITUDE', $mapLong);    
    $page->SetParameter('EMAIL', $email);
    $page->SetParameter('MAIN_IMAGE', $main_image);
    $page->SetParameter('COVER_IMAGE', $cover_image);
    $page->SetParameter('MAP_COLOR', $config['map_color']);
    $page->SetParameter('ZOOM', $config['home_map_zoom']);
    $page->SetParameter('RESTAURANT_TEXT_EDITOR', 0);

    $page->SetParameter('OVERALL_FOOTER', create_footer());
    $page->CreatePageEcho();
} else {
    headerRedirect($link['LOGIN']);
}
