<?php


$home_orders_page = 'home-orders';
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
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('slug', $_POST['slug'])
            ->find_one();
        $confirm_id = get_random_id();
        $location = getLocationInfoByIp();
        $password = $_POST["password"];
        $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
        $now = date("Y-m-d H:i:s");
        $insert_user = ORM::for_table($config['db']['pre'] . 'customers')->create();
        $insert_user->status = '0';
        $insert_user->restaurant_id = $restaurant['id'];
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
        /*SEND CONFIRMATION EMAIL*/
        /*SEND ACCOUNT DETAILS EMAIL*/
        email_template("customer_signup_details",$restaurant['id'], $user_id, $password);
        $loggedin = customerslogin($_POST['username'], $_POST['password'], $restaurant['id']);
        create_customers_session($loggedin, $_POST['slug']);
        headerRedirect($link['CUSTOMER_ACCOUNT_SETTING']);
        //  create_page_customers_address($lang, $config, $restaurant, $user_id);
        exit();
    }
}

$cookie_acceptance = 0;
if(!empty($_SESSION['cookie_acceptance']))
{
    $cookie_acceptance = $_SESSION['cookie_acceptance'];
}
$order = '';
$action = '';
$item_id = '';
$slug = '';
if (isset($_POST['order'])) {
    $order = $_POST['order'];
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
}
if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
}

if (isset($_GET['slug']) || $_GET['id'] || isset($_POST['slug']) || $_POST['restaurant_id']) {
    if (isset($_GET['id'])) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->find_one($_GET['id']);
    } elseif (isset($_POST['slug'])) {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('slug', $_POST['slug'])
            ->find_one();
    } else {
        $restaurant = ORM::for_table($config['db']['pre'] . 'restaurant')
            ->where('slug', $_GET['slug'])
            ->find_one();
    }
    if (isset($restaurant['name'])) {
        // Get usergroup details
        $user_info = ORM::for_table($config['db']['pre'] . 'user')
            ->find_one($restaurant['user_id']);
        if ($user_info['status'] == 2) {
            error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
            exit();
        }
        run_cron_job_reset_data_restaurant($restaurant['id']);
        $limit = "999";
        $restaurant_menu_reduced = 1; //$settings['restaurant_menu_reduced'];
        $restaurant_setting_display_website = get_module_settting($restaurant['user_id'], 'website'); //$settings['restaurant_setting_display_website'];
        $restaurant_open_story  = $restaurant_setting_display_website == 1 ? get_restaurant_option($restaurant->id, 'restaurant_open_story', 1) : 0;
        $restaurant_open_banner  = $restaurant_setting_display_website == 1 ? get_restaurant_option($restaurant->id, 'restaurant_open_banner', 1) : 0;
        $restaurant_open_image_advertisement  = $restaurant_setting_display_website == 1 ? get_restaurant_option($restaurant->id, 'restaurant_open_image_advertisement', 1) : 0;

        $display_image =  get_restaurant_option($restaurant['id'], 'restaurant_display_menu_image', 1);
        $display_id = get_restaurant_option($restaurant['id'], 'restaurant_display_menu_id', 1);
        $display_price = get_restaurant_option($restaurant['id'], 'restaurant_display_menu_price', 1);

        $table = '';
        if (!empty($_GET['table'])) {
            $table = $_GET['table'];
        }
        // check for url
        if (!empty($_GET['qr-id'])) {
            $qr_id = quick_xor_decrypt(urldecode($_GET['qr-id']), 'quick-qr');
            if ($_GET['slug'] == $qr_id || $_GET['id'] == $qr_id) {

                if ($limit != "999") {
                    $start = date('Y-m-01');
                    $end = date('Y-m-t');

                    $total = ORM::for_table($config['db']['pre'] . 'restaurant_view')
                        ->where('restaurant_id', $restaurant['id'])
                        ->where_raw("`date` BETWEEN '$start' AND '$end'")
                        ->count();

                    if ($total >= $limit) {
                        message($lang['NOTIFY'], $lang['SCAN_LIMIT_EXCEED']);
                        exit();
                    }
                }

                $add_view = ORM::for_table($config['db']['pre'] . 'restaurant_view')->create();
                $add_view->restaurant_id = $restaurant['id'];
                $add_view->ip = get_client_ip();
                $add_view->date = date('Y-m-d H:i:s');
                $add_view->save();
                if (!empty($_GET['table'])) {
                    headerRedirect($config['site_url'] . $restaurant['slug'] . '?table=' . $table);
                }
            }
        }
        $restro_id = $restaurant['id'];
        $name = $restaurant['name'];
        $sub_title = $restaurant['sub_title'];
        $res_description =  nl2br(stripcslashes($restaurant['description']));
        $res_description =  str_replace("<br>", " ", $res_description);

        $address = $restaurant['address'];
        $mapLat = $restaurant['latitude'];
        $mapLong = $restaurant['longitude'];
        $main_image = $restaurant['main_image'];
        $main_image_bg_white = $restaurant['main_image_bg_white'];
        if(empty($main_image_bg_white))
        $main_image_bg_white = $main_image; //"165667426562bed7d9b1092.png";

        $cover_image = $restaurant['cover_image'];
        $slug = $restaurant['slug'];
        $restaurant_link = $config['site_url'] . $slug;
        $order_link = $config['site_url'] . 'order/' . $slug;
        $userdata = get_user_data(null, $restaurant['user_id']);
        $email = $userdata['email'];
        $templates_setting = "all";
        $restaurant_template =   get_restaurant_option($restro_id, 'restaurant_template', 'modern-cuisine');
        $category = array();
        $cat = array();

        $currency = !empty($userdata['currency']) ? $userdata['currency'] : get_option('currency_code');
        $currency_data = get_currency_by_code($currency);
        $allow_payment = (get_option("admin_allow_online_payment") == '1') ? 1 : 0;

        $allow_booking = get_module_settting($restaurant['user_id'], 'booking'); //$settings['allow_booking'];
        $allow_reservations = get_module_settting($restaurant['user_id'], 'reservations'); //$settings['allow_reservations'];
        $allow_on_table =  get_module_settting($restaurant['user_id'], 'on_table'); //$settings['allow_on_table_order'];
        $allow_takeaway = get_module_settting($restaurant['user_id'], 'takeaway'); //$settings['allow_takeaway_order'];
        $allow_delivery = get_module_settting($restaurant['user_id'], 'delivery'); //$settings['allow_delivery_order'];
        if ($allow_on_table) {
            $restaurant_on_table_order = get_restaurant_option($restro_id, 'restaurant_on_table_order', 0);
        } else {
            $restaurant_on_table_order = "0";
        }
        if ($allow_takeaway) {
            $restaurant_takeaway_order = get_restaurant_option($restro_id, 'restaurant_takeaway_order', 0);
        } else {
            $restaurant_takeaway_order = "0";
        }
        if ($allow_delivery) {
            $restaurant_delivery_order = get_restaurant_option($restro_id, 'restaurant_delivery_order', 0);
        } else {
            $restaurant_delivery_order = "0";
        }

        if ($allow_booking) {
            $restaurant_booking = get_restaurant_option($restro_id, 'restaurant_booking', 0);
        } else {
            $restaurant_booking = "0";
        }
        if ($allow_reservations) {
            $restaurant_reservations = get_restaurant_option($restro_id, 'restaurant_reservations', 0);
        } else {
            $restaurant_reservations = "0";
        }
        $bAllow_order =  $restaurant_takeaway_order || $restaurant_delivery_order;
        $allow_order  = ($bAllow_order) ? "1" : "0";
        $bShowPoppup =  $restaurant_takeaway_order || $restaurant_delivery_order || $restaurant_reservations || $restaurant_booking;
        $show_poppup = ($bShowPoppup) ? "1" : "0";
        $total_menus = $image_menu = array();
        $menu_layout = !empty($userdata['menu_layout']) ? $userdata['menu_layout'] : 'both';

        if ($restaurant_template == "modern-cuisine") {
            $count = 0;
            $menu_tpl_discount = '';
            $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                ->where_any_is(array(
                    array(
                        'is_new_food' => '1',
                        'user_id' => $restaurant['user_id'],
                        'active' => '1'
                    ), array(
                        'is_discount' => '1', 'user_id' => $restaurant['user_id'],
                        'active' => '1'
                    )
                ))
                ->where_not_equal('image', 'default.png')
                ->count();
            $menu_discount_count = $menu_count > 0 ? 1 : 0;

            if ($menu_discount_count == "1") {
                $menu_tpl_discount = get_menu_tpl_by_cat_id_grand_templates($menu_tpl_discount, '', true);
            }



            $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where(array(
                    'user_id' => $restaurant['user_id'],
                    'parent' => 0
                ))
                ->order_by_asc('cat_order')
                ->find_many();

            foreach ($result as $info) {

                //check menu
                $sub_menus = array();
                array_push($sub_menus, $info['cat_id']);
                $sub_menu_result =  ORM::for_table($config['db']['pre'] . 'catagory_main')
                    ->where(array(
                        'parent' => $info['cat_id'],
                        'user_id' => $restaurant['user_id']
                    ))
                    ->find_many();

                foreach ($sub_menu_result as $sub_info) {
                    array_push($sub_menus, $sub_info->cat_id);
                }

                $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where(array(
                        'user_id' => $restaurant['user_id'],
                        'active' => '1'
                    ))
                    ->where_in('cat_id', $sub_menus)
                    ->count();
                //end check
                if ($menu_count > 0) {
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $json = json_decode($info['translation'], true);
                    $cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['cat_name'];
                    $description =  !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info['description'];

                    $category[$count]['image'] = $info['picture'];
                    $category[$count]['id'] = $info['cat_id'];
                    $category[$count]['name'] = ucfirst($cat_name);
                    $category[$count]['count'] = $count;
                    $cat[$count]['count'] = $count;
                    $cat[$count]['id'] = $info['cat_id'];
                    $cat[$count]['image'] = $info['picture'];
                    $cat[$count]['display_image'] = $info['display_image'];
                    $cat[$count]['description'] = nl2br($description);
                    $cat[$count]['name'] = ucfirst($cat_name);
                    $cat[$count]['menu'] = '';
                    $menu_tpl = '';
                    $menu_tpl = get_menu_tpl_by_cat_id_grand_templates($menu_tpl, $info['cat_id']);
                    $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                    $count++;
                }
            }
        }else if($restaurant_template === "cafe"){
            $count = 0;
            $menu_tpl_discount = '';
            $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                ->where_any_is(array(
                    array(
                        'is_new_food' => '1',
                        'user_id' => $restaurant['user_id'],
                        'active' => '1'
                    ), array(
                        'is_discount' => '1', 'user_id' => $restaurant['user_id'],
                        'active' => '1'
                    )
                ))
                ->where_not_equal('image', 'default.png')
                ->count();
            $menu_discount_count = $menu_count > 0 ? 1 : 0;

            if ($menu_discount_count == "1") {
                $menu_tpl_discount = cafe_get_menu_tpl_by_cat_id_grand_templates($menu_tpl_discount, '', true);
            }



            $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                ->where(array(
                    'user_id' => $restaurant['user_id'],
                    'parent' => 0
                ))
                ->order_by_asc('cat_order')
                ->find_many();

            foreach ($result as $info) {

                //check menu
                $sub_menus = array();
                array_push($sub_menus, $info['cat_id']);
                $sub_menu_result =  ORM::for_table($config['db']['pre'] . 'catagory_main')
                    ->where(array(
                        'parent' => $info['cat_id'],
                        'user_id' => $restaurant['user_id']
                    ))
                    ->find_many();

                foreach ($sub_menu_result as $sub_info) {
                    array_push($sub_menus, $sub_info->cat_id);
                }

                $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where(array(
                        'user_id' => $restaurant['user_id'],
                        'active' => '1'
                    ))
                    ->where_in('cat_id', $sub_menus)
                    ->count();
                //end check
                if ($menu_count > 0) {
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $json = json_decode($info['translation'], true);
                    $cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['cat_name'];
                    $description =  !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info['description'];

                    $category[$count]['image'] = $info['picture'];
                    $category[$count]['id'] = $info['cat_id'];
                    $category[$count]['name'] = ucfirst($cat_name);
                    $category[$count]['count'] = $count;
                    $cat[$count]['count'] = $count;
                    $cat[$count]['id'] = $info['cat_id'];
                    $cat[$count]['image'] = $info['picture'];
                    $cat[$count]['display_image'] = $info['display_image'];
                    $cat[$count]['description'] = nl2br($description);
                    $cat[$count]['name'] = ucfirst($cat_name);
                    $cat[$count]['menu'] = '';
                    $menu_tpl = '';
                    $menu_tpl = cafe_get_menu_tpl_by_cat_id_grand_templates($menu_tpl, $info['cat_id']);
                    $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                    $count++;
                }
            }
        } else {
            if ($restaurant_template == 'flipbook-pdf') {
                $result = ORM::for_table($config['db']['pre'] . 'pdf_menu')
                    ->where('user_id', $restaurant['user_id'])
                    ->where('active', '1')
                    ->find_one();
                if (!empty($result['name'])) {
                    $pdf_menu = $result['name'];
                } else {
                    $pdf_menu = '';
                }
            } elseif ($restaurant_template == 'flipbook-2') {
                $result = ORM::for_table($config['db']['pre'] . 'image_menu')
                    ->where('user_id', $restaurant['user_id'])
                    ->where('active', '1')
                    ->order_by_asc('position')
                    ->find_many();

                $menu_count = 0;
                foreach ($result as $info) {
                    $image_menu[$info['id']]['id'] = $info['id'];
                    $image_menu[$info['id']]['name'] = $info['name'];
                    $image_menu[$info['id']]['image'] = !empty($info['image']) ? $info['image'] : 'default.png';
                    $image_menu[$info['id']]['active'] = $info['active'];
                    $menu_count++;
                }
            } else {
                function get_menu_tpl_by_cat_id($menu_tpl, $cat_id, $bGetNewMenu = false)
                {
                    global $config,  $lang, $currency, $restaurant_template, $allow_order, $menu_layout, $total_menus, $restaurant, $restaurant_menu_reduced, $translate;

                    $cat_result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                        ->where('cat_id', $cat_id)
                        ->find_one();
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $json = json_decode($cat_result['translation'], true);
                    $cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $cat_result['cat_name'];
                    if ($bGetNewMenu) {
                        $menu = ORM::for_table($config['db']['pre'] . 'menu')
                            ->where_any_is(array(
                                array(
                                    'is_new_food' => '1',
                                    'user_id' => $restaurant['user_id'],
                                    'active' => '1'
                                ), array(
                                    'is_discount' => '1', 'user_id' => $restaurant['user_id'],
                                    'active' => '1'
                                )
                            ))
                            ->order_by_asc('is_new_food')->find_many();
                    } else {
                        $menu = ORM::for_table($config['db']['pre'] . 'menu')
                            ->where(array(
                                'cat_id' => $cat_id,
                                'user_id' => $restaurant['user_id'],
                                'active' => '1'
                            ))
                            ->order_by_asc('position')
                            ->find_many();
                    }
                    if ($menu_layout == 'grid') {
                        $grid_layout = 'style="display:block"';
                        $list_layout = 'style="display:none"';
                    } else if ($menu_layout == 'list') {
                        $grid_layout = 'style="display:none"';
                        $list_layout = 'style="display:block"';
                    } else {
                        if ($menu[0]['image'] == "default.png") {
                            $grid_layout = 'style="display:none"';
                            $list_layout = 'style="display:block"';
                        } else {
                            $grid_layout = 'style="display:block"';
                            $list_layout = 'style="display:none"';
                        }
                    }

                    $menu_count = 0;
                    $menu_count_2 = 0;
                    $title_translate = '';
                    $desc_translate = '';
                    foreach ($menu as $info) {
                        $title_translate .= $info['name'] . " | ";
                        $desc_translate .= $info['description'] . " | ";
                        $menu_count_2++;
                    }
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    foreach ($menu as $info2) {

                        $menuId = $info2['id'];
                        $menu_allegie = ORM::for_table($config['db']['pre'] . 'allegie')
                            ->table_alias('a')
                            ->inner_join($config['db']['pre'] . "allegie_menu", "a.id = am.alle_id", 'am')
                            ->where('am.menu_id', $menuId)
                            ->find_many();
                        $menuAllegie  = '';
                        foreach ($menu_allegie as $info) {
                            if ($menuAllegie == '') {
                                $menuAllegie .= $info['alle_aliases'] . '|' . $info['alle_name'] . '|' . $info['image'];
                            } else {
                                $menuAllegie .=  '#' . $info['alle_aliases'] . '|' . $info['alle_name'] . '|' . $info['image'];
                            }
                        }

                        $menu_additives = ORM::for_table($config['db']['pre'] . 'additives')
                            ->table_alias('a')
                            ->inner_join($config['db']['pre'] . "additives_menu", "a.id = am.additive_id", 'am')
                            ->where('am.menu_id', $menuId)
                            ->find_many();
                        $dataAdditives  = '';

                        foreach ($menu_additives as $info) {
                            if ($dataAdditives == '') {
                                $dataAdditives .= $info['additives_aliases'] . '. ' . $info['additives_name'];
                            } else {
                                $dataAdditives .= '#' . $info['additives_aliases'] . '. ' . $info['additives_name'];
                            }
                        }
                        $menu_properties = ORM::for_table($config['db']['pre'] . 'properties')
                            ->table_alias('p')
                            ->inner_join($config['db']['pre'] . "properties_menu", "p.id = pm.properties_id", 'pm')
                            ->where('pm.menu_id', $menuId)
                            ->find_many();
                        $menuProperties  = '<span class="image_properties_container">';
                        $data_properties = '';
                        foreach ($menu_properties as $info) {
                            $menuProperties .= '<img class="svg svg-properties-restaurant-menu" src="' . $config['site_url'] . 'storage/icon-food/' . $info['image'] .  '"/>';

                            if ($data_properties == '') {
                                $data_properties .= $info['properties_aliases'] . '|' . $info['properties_name'] . '|' . $info['image'];
                            } else {
                                $data_properties .=  '#' . $info['properties_aliases'] . '|' . $info['properties_name'] . '|' . $info['image'];
                            }
                        }
                        $menuProperties .= '</span>';
                        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                        $json = json_decode($info2['translation'], true);
                        $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info2['name'];
                        $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info2['description'];

                        $menuName = ucfirst($title);
                        $menuDesc = nl2br($description);
                        $menuType = $info2['type'];
                        $menu_id = '';
                        if (!empty($info2['menu_res_id'])) {
                            $menu_id = $info2['menu_res_id'] . '. ';
                        }
                        $menuImage = $info2['image'];
                        $discount_price = $info2['discount_price'];
                        if ($restaurant_menu_reduced == "1") {
                            $is_new_food = $info2['is_new_food'];
                            $is_discount  = $info2['is_discount'];
                        } else {
                            $is_new_food = "0";
                            $is_discount  = "0";
                        }
                        $extras_data = ORM::for_table($config['db']['pre'] . 'menu_extras')
                            ->where(array(
                                'menu_id' => $menuId,
                                'active' => 1,
                                'extra_option' => 'many'
                            ))
                            ->order_by_asc('position')
                            ->find_many();
                        $extras = array();
                        foreach ($extras_data as $info) {
                            $data = array();
                            $data['id'] = $info['id'];
                            $json = json_decode($info['translation'], true);
                            $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['title'];
                            $data['title'] = htmlentities((string)$title, ENT_QUOTES, 'UTF-8');
                            $data['price'] = $info['price'];
                            $extras[] = $data;
                        }


                        $extras_option_data = ORM::for_table($config['db']['pre'] . 'menu_extras')
                            ->where(array(
                                'menu_id' => $menuId,
                                'active' => 1,
                                'extra_option' => 'one'
                            ))
                            ->order_by_asc('position')
                            ->find_many();
                        $extras_option = array();
                        $extras_option_min_price = '';
                        $extras_option_first_price = '';
                        foreach ($extras_option_data as $info) {
                            if ($extras_option_first_price == '') {
                                $extras_option_first_price = $info['price'];
                                $extras_option_min_price = $info['price'];
                            }
                            if ($extras_option_min_price > $info['price']) {
                                $extras_option_min_price = $info['price'];
                            }
                            $data = array();
                            $data['id'] = $info['id'];
                            $json = json_decode($info['translation'], true);
                            $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['title'];
                            $data['title'] = htmlentities((string)$title, ENT_QUOTES, 'UTF-8');
                            $data['price'] = $info['price'];
                            $extras_option[] = $data;
                        }
                        $menuPrePrinceDiscount = price_format($info2['price'], $currency);
                        if ($is_discount == "1") {
                            if (!empty($extras_option_min_price)) {
                                $menuPrice =  price_format($extras_option_min_price, $currency);
                            } else {
                                $menuPrice = price_format($discount_price, $currency);
                            }

                            $amount = $discount_price;
                            $amount_reduced = $info2['price'] - $discount_price;
                        } else {

                            if (!empty($extras_option_min_price)) {

                                $menuPrice =  price_format($extras_option_min_price, $currency);
                            } else {
                                $menuPrice = price_format($info2['price'], $currency);
                            }
                            $amount = $info2['price'];
                            $amount_reduced = 0;
                        }
                        $ribbon = '';
                        if ($is_new_food == "1") {
                            $ribbon = '<span class="ribbon new"></span>';
                        } elseif ($is_discount == "1") {
                            $ribbon = '<span class="ribbon discount"></span>';
                        }
                        $menu_data_array = array();
                        $menu_data_array['id'] = $menuId;
                        $menu_data_array['title'] = htmlentities((string)$menuName, ENT_QUOTES, 'UTF-8');
                        $menu_data_array['price'] = $info2['price'];
                        $menu_data_array['price_format'] = $menuPrice;
                        $menu_data_array['type'] = $menuType;
                        $menu_data_array['imgFullLink'] = $config['site_url'] . 'storage/menu/' . $menuImage;
                        $menu_data_array['img'] =  $menuImage;
                        $menu_data_array['description'] = $menuDesc; //htmlentities((string)$menuDesc, ENT_QUOTES, 'UTF-8');
                        $menu_data_array['extras'] = $extras;
                        $menu_data_array['extras_option'] = $extras_option;
                        $menu_data_array['properties'] = $data_properties;
                        $menu_data_array['additives'] = $dataAdditives;
                        $menu_data_array['allegie'] = $menuAllegie;
                        $menu_data_array['cat_name'] = $cat_name;
                        $total_menus[$menuId] = $menu_data_array;
                        if ($restaurant_template == 'modern-cuisine' || $restaurant_template == 'flipbook') {
                            $menu_tpl .= '
                                <div class="col-xl-3 col-6 col-lg-6 col-md-6 col-sm-6 ajax-item-listing menu-grid-view" ' . $grid_layout . ' data-properties="' . $data_properties . '" data-allegie="' . $menuAllegie . '" data-amount-reduced="' . $amount_reduced . '" data-additives="' . $dataAdditives . '" data-id="' . $menuId . '"  data-name="' . $menuName . '" data-price="' . $menuPrice . '" data-amount="' . $amount . '" data-description="" data-image-url="' . $config['site_url'] . 'storage/menu/' . $menuImage . '">
                                    <div class="menu_item">' . $ribbon . '
                                        <figure>
                                            <img  src="' . $config['site_url'] . 'storage/menu/' . $menuImage . '" alt="' . $menuName . '">
                                        </figure>
                                        <div class="menu_detail">
                                            <h4 style="position:relative;" class="menu_post menu_post_figure">
                                                <span class="menu_title menu_title_main ">' . $menu_id . $menuName  . ' </span> </h4>
                                            <div class="menu_excerpt menu_excerpt_main"></div><div class="menu_excerpt menu_excerpt_main"> </div>
                                            <div class="menu_excerpt menu_excerpt_main"><span class="menu_price menu_price_main menu_price_2">' . ($is_discount == "1" ? '<span class="menu-Pre-Prince-Discount margin-right-5">' . $menuPrePrinceDiscount . '</span>' : '')  . $menuPrice  .
                                '<button type="button" class="info-item-button"><i class="icon-feather-info"></i></button> </span>' .

                                ($allow_order
                                    ? '<div style="" class="add-item-container margin-left-auto padding-left-10"><button type="button" class="button add-item-button add-extras"><i class="icon-feather-plus"></i></button></div>'
                                    : '') . '</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 ajax-item-listing menu-list-view" ' . $list_layout . ' data-id="' . $menuId . '"  data-properties="' . $data_properties . '" data-allegie="' . $menuAllegie . '" data-amount-reduced="' . $amount_reduced . '" data-additives="' . $dataAdditives . '" data-name="' . $menuName . '" data-price="' . $menuPrice . '" data-amount="' . $amount . '" data-description="" data-image-url="' . $config['site_url'] . 'storage/menu/' . $menuImage . '">
                                    <div class="menu_detail">
                                        <h4 class="menu_post">
                                            <span class="menu_title menu_title_main">' . $menu_id . $menuName . ' </span>
                                            <span class="menu_dots menu_dots_main"></span>' .
                                ($is_discount == "1" ? ' <span class="menu_price menu_price_main menu_pre_price">' . $menuPrePrinceDiscount . '</span>' : '') . '
                                            <span class="menu_price menu_price_main flex-75">' . $menuPrice . '</span> <button to type="button" class="info-item-button margin-top-4-r"><i class="icon-feather-info"></i></button>' .
                                ($allow_order
                                    ? '<div class="margin-left-auto padding-left-10"><button type="button" class="button add-item-button add-extras"><i class="icon-feather-plus"></i></button></div>'
                                    : '') .
                                '
                                        </h4>
                                        <div class="menu_excerpt menu_excerpt_main"><div></div></div>
                                    </div>
                                </div>';
                        } else {
                            $menu_tpl .= '<div class="section-menu" data-id="' . $menuId . '" data-name="' . $menuName . '" data-price="' . $menuPrice . '" data-amount="' . $info2['price'] . '" data-description="' . $menuDesc . '" data-image-url="' . $config['site_url'] . 'storage/menu/' . $menuImage . '">
                            <div class="menu-item list">
                            ' .
                                (!empty($menuImage != 'default.png') ?
                                    '<div class="menu-image">
                                        <img src="' . $config['site_url'] . 'storage/menu/' . $menuImage . '">
                                        <div class="badge abs ' . $menuType . '"><i class="fa fa-circle"></i></div>
                                    </div>' :
                                    '<div class="badge ' . $menuType . ' only"><i class="fa fa-circle"></i></div>')
                                . ' 
                                <div class="menu-content">
                                    <div class="menu-detail">
                                        <div class="menu-title">
                                            <h4>' . $menuName . ' <sup>' . $menuAllegie . '</sup> </h4>
                                            <div class="menu-price">' . $menuPrice . '</div>
                                        </div>' .
                                ($allow_order
                                    ? '<div class="add-menu">
                                            <div class="add-btn add-item-to-order">
                                                <span>' . $lang['ADD'] . '</span>
                                                <i class="icon-feather-plus"></i>
                                            </div>
                                ' .
                                    (!empty($extras) ? '' : '')
                                    . '        </div>'
                                    : '') .

                                '</div>
                                    <div class="menu-recipe">' . $menuDesc . '</div>
                                </div>
                            </div>
                        </div>';
                        }

                        $menu_count++;
                    }

                    return $menu_tpl;
                }
                $count = 0;
                $menu_tpl_discount = '';
                $menu_count = ORM::for_table($config['db']['pre'] . 'menu')
                    ->where_any_is(array(
                        array(
                            'is_new_food' => '1',
                            'user_id' => $restaurant['user_id'],
                            'active' => '1'
                        ), array(
                            'is_discount' => '1', 'user_id' => $restaurant['user_id'],
                            'active' => '1'
                        )
                    ))->count();
                $menu_discount_count = $menu_count > 0 ? 1 : 0;


                if ($restaurant_menu_reduced == "1") {
                    $menu_tpl_discount = get_menu_tpl_by_cat_id($menu_tpl_discount, '', true);
                }
                $result = ORM::for_table($config['db']['pre'] . 'catagory_main')
                    ->where(array(
                        'user_id' => $restaurant['user_id'],
                        'parent' => 0
                    ))
                    ->order_by_asc('cat_order')
                    ->find_many();

                foreach ($result as $info) {
                    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                    $json = json_decode($info['translation'], true);
                    $cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info['cat_name'];
                    $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info['description'];
                    $category[$count]['image'] = $info['picture'];
                    $category[$count]['id'] = $info['cat_id'];
                    $category[$count]['name'] = ucfirst($cat_name);
                    $category[$count]['count'] = $count;
                    $cat[$count]['count'] = $count;
                    $cat[$count]['id'] = $info['cat_id'];
                    $cat[$count]['image'] = $info['picture'];
                    $cat[$count]['description'] = $description;
                    $cat[$count]['display_image'] = $info['display_image'];
                    $cat[$count]['name'] = ucfirst($cat_name);
                    if ($restaurant_template == 'modern-cuisine' || $restaurant_template == 'flipbook') {
                        $cat[$count]['menu'] = '<div class="col-lg-12 margin-bottom-30 text-center menu_not_available">' . $lang['MENU_NOT_AVAILABLE'] . '</div>';
                    } else {
                        $cat[$count]['menu'] = '';
                    }
                    $menu_tpl = '';
                    $sub_cats = ORM::for_table($config['db']['pre'] . 'catagory_main')
                        ->where(array(
                            'parent' => $info['cat_id']
                        ))
                        ->order_by_asc('cat_order')
                        ->find_many();

                    if (($restaurant_template == 'modern-theme' || $restaurant_template == 'modern-theme2') && $sub_cats->count()) {
                        $menu_tpl .= '<div id="accordion' . $info['cat_id'] . '" class="accordion menu-category-item menu-category-' . $info['cat_id'] . '">';
                    } else if (($restaurant_template == 'modern-cuisine' || $restaurant_template == 'flipbook') && $sub_cats->count()) {

                        $menu_tpl .= '<div class="col-sm-12 js-accordion margin-bottom-20">';
                    }
                    $sub_cat_count = 0;
                    foreach ($sub_cats as $sub_cat) {
                        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
                        $json = json_decode($sub_cat['translation'], true);

                        $sub_cat_name = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $sub_cat['cat_name'];
                        $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $sub_cat['description'];
                        $sub_cat_count++;

                        if ($restaurant_template == 'modern-cuisine' || $restaurant_template == 'flipbook') {
                            $img_tpl = '';
                            if ($sub_cat['picture'] != 'default.png' && $sub_cat['display_image'] == 1) {
                                $img_tpl = '<div class="image-boxed padding-15"><img class="category-image" src="storage/category/' . $sub_cat['picture'] . '" /></div>';
                            }
                            $menu_tpl .= '<div class="boxed-list-small js-accordion-item margin-bottom-10"><div class=" js-accordion-header"><div class="boxed-container flex">' . $img_tpl . '
                            <div class="boxed-list-headline flex-grow-1"><h3><i class="icon-material-outline-restaurant"></i> ' . $sub_cat_name . '<span class="cat_menu_desc">' . $description . '</span></h3></div></div>
                            </div>
                            <div class="box-item js-accordion-body js-accordion-body-active" style="display: none">';
                            $menu_tpl = get_menu_tpl_by_cat_id($menu_tpl, $sub_cat['cat_id']);
                            $menu_tpl .= '</div></div>';
                        } else {
                            $menu_tpl .= '<div class="card"><div class="card-header collapsed waves-effect" data-toggle="collapse" href="#collapse' . $sub_cat['cat_id'] . '">
                        <a class="card-title">' . $sub_cat_name . '</a>
                    </div>
                    <div id="collapse' . $sub_cat['cat_id'] . '" class="card-body collapse" data-parent="#accordion' . $info['cat_id'] . '">';

                            $menu_tpl = get_menu_tpl_by_cat_id($menu_tpl, $sub_cat['cat_id']);
                            $menu_tpl .= '</div></div>';
                        }
                    }
                    if ($sub_cats->count()) {
                        $menu_tpl .= '</div>';
                    }

                    if ($restaurant_template == 'modern-theme' || $restaurant_template == 'modern-theme2') {
                        $menu_tpl .= '<div class="card-body menu-category-item menu-category-' . $info['cat_id'] . '">';
                    }
                    $menu_tpl = get_menu_tpl_by_cat_id($menu_tpl, $info['cat_id']);
                    if ($restaurant_template == 'modern-theme' || $restaurant_template == 'modern-theme2') {
                        $menu_tpl .= '</div>';
                    }

                    $cat[$count]['menu'] = !empty($menu_tpl) ? $menu_tpl : $cat[$count]['menu'];
                    $count++;
                }
            }
        }

        $menu_lang = get_user_option($restaurant['user_id'], 'restaurant_menu_languages', '');
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

        //get list Allegie
        $Allegies = ORM::for_table($config['db']['pre'] . 'allegie')
            ->where_any_is(array(
                array('restaurant_id' => $restaurant['id']),
                array('is_default' => '1')
            ))
            ->order_by_asc('is_default')->find_many();
        $Allegie_list = '';
        foreach ($Allegies as $info) {
            if ($Allegie_list == '') {
                $Allegie_list = $info['alle_aliases'] . '. ' .  $info['alle_name'];
            } else {
                $Allegie_list .= ' | ' . $info['alle_aliases'] . '. ' .  $info['alle_name'];
            }
        }

        //get list Additives
        $Additives = ORM::for_table($config['db']['pre'] . 'additives')
            ->where_any_is(array(
                array('restaurant_id' => $restaurant['id']),
                array('is_default' => '1')
            ))
            ->order_by_asc('is_default')->find_many();
        $Additives_list = '';
        foreach ($Additives as $info) {
            if ($Additives_list == '') {
                $Additives_list = $info['additives_aliases'] . '. ' .  $info['additives_name'];
            } else {
                $Additives_list .= ' | ' . $info['additives_aliases'] . '. ' .  $info['additives_name'];
            }
        }

        //get list Properties
        $Properties = ORM::for_table($config['db']['pre'] . 'properties')
            ->where_any_is(array(
                array('restaurant_id' => $restaurant['id']),
                array('is_default' => '1')
            ))
            ->order_by_asc('is_default')->find_many();
        $Properties_list = '';
        foreach ($Properties as $info) {
            if ($Properties_list == '') {
                $Properties_list =   $info['properties_name'];
            } else {
                $Properties_list .= ' | ' .   $info['properties_name'];
            }
        }
        //get open time 
        $open_time = '';
        $open_close_hour_result = ORM::for_table($config['db']['pre'] . 'open_close_hour')
            ->where('restaurant_id', $restaurant['id'])->find_many();
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


        // get open hours to day
        $open_hours_today = '';
        $date = date("Y-m-d H:i:s");
        $dayofweek = date('w', strtotime($date));
        $days = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        $day_off_week_string = $days[$dayofweek];
        $open_close_hour_result = ORM::for_table($config['db']['pre'] . 'open_close_hour')
            ->where(array('restaurant_id' => $restaurant['id'], 'day_of_week' => $day_off_week_string))->find_one();

        if (empty($open_close_hour_result['id'])) {
            $open_hours_today = $lang['CLOSE'];
        } else {
            $text_open_close = $open_close_hour_result['open_hour'] . ' - ' . $open_close_hour_result['close_hour'];
            $text_open_close_2 = !empty($open_close_hour_result['open_hour_2']) ? ' & ' . $open_close_hour_result['open_hour_2'] . ' - ' . $open_close_hour_result['close_hour_2'] : '';
            $open_hours_today = $text_open_close . $text_open_close_2;
        }

        //get image list
        $image_result = ORM::for_table($config['db']['pre'] . 'restaurant_image')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'image_type' => 'restaurant'
            ))
            ->order_by_asc('id')
            ->find_many();
        $menu_count = 0;
        $image = [];
        foreach ($image_result as $info2) {
            $image[$info2['id']]['id'] = $info2['id'];
            $image[$info2['id']]['description'] = '';
            $image[$info2['id']]['name'] = '';
            $image[$info2['id']]['image'] = $info2['image'];
            $menu_count++;
        }

        $image_result = ORM::for_table($config['db']['pre'] . 'restaurant_image')
            ->where(array(
                'restaurant_id' => $restaurant['id'],
                'image_type' => 'story'
            ))
            ->order_by_asc('id')
            ->find_one();
        $story_image = $image_result['image'];

        if ($restaurant_takeaway_order == "1" || $restaurant_delivery_order == "1" || $restaurant_reservations == "1") {
            $allow_loggin_register = "1";
        } else {
            $allow_loggin_register = "0";
        }
        $gmap_api_key = get_option("gmap_api_key");

        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];

        //discover
        $json = json_decode(get_restaurant_option($restro_id, 'restaurant_discover_translate'), true);
        $discorver_text = !empty($json[$user_lang]['text']) ? $json[$user_lang]['text'] : get_restaurant_option($restro_id, 'restaurant_discover_text');

        //description
        $json = json_decode(get_restaurant_option($restro_id, 'restaurant_description_translate'), true);
        $res_description = !empty($json[$user_lang]['text']) ? $json[$user_lang]['text'] : $res_description;


        // featured title
        $json = json_decode(get_restaurant_option($restro_id, 'restaurant_featured_title_translate'), true);
        $featured_title = !empty($json[$user_lang]['text']) ? $json[$user_lang]['text'] : get_restaurant_option($restro_id, 'restaurant_image_featured_title');

        // featured description
        $json = json_decode(get_restaurant_option($restro_id, 'restaurant_featured_description_translate'), true);
        $featured_description = !empty($json[$user_lang]['text']) ? $json[$user_lang]['text'] : get_restaurant_option($restro_id, 'restaurant_image_featured_desc');

        $latlng = '';
        $latitude =  get_restaurant_option($restro_id, 'restaurant_latitude');
        $longitude =  get_restaurant_option($restro_id, 'restaurant_longitude');
        $latlng = $latitude . ', ' . $longitude;
        $page = new HtmlTemplate('restaurant-templates/' . $restaurant_template . '/index.tpl');
        $classic_boder_color = get_restaurant_option($restro_id, 'restaurant_theme_color', $config['theme_color']);
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

        $cancellation_reason = array();
        $count = 0;
        $result = ORM::for_table($config['db']['pre'] . 'cancellation_reason')
            ->where_any_is(array(
                array('restaurant_id' => $restaurant['id']),
                array('is_default' => '1')
            ))
            ->order_by_asc('is_default')
            ->find_many();
        foreach ($result as $info) {
            $cancellation_reason[$count]['id'] = $info['id'];
            $cancellation_reason[$count]['reason'] = $info['reason'];
            $count++;
        }
        $fun_result = ORM::for_table($config['db']['pre'] . 'function_position')
            ->where(array(
                'restaurant_id' => $restro_id
            ))
            ->order_by_asc('position')
            ->find_many();
        $count = 0;
        $function = array();
        $function_not_image = array();
        foreach ($fun_result as $info) {
            switch ($info['function']) {
                case 'menu':
                    $function_name = $lang['MENU'];
                    $class_name = 'menu-action';
                    $function_on_off = 1;
                    break;
                case 'booking':
                    $class_name = 'reservations-action';
                    $function_name = $lang['BOOKING'];
                    $function_on_off = $restaurant_booking;
                    break;
                case 'delivery':
                    $class_name = 'delivery-action';
                    $function_name = $lang['DELIVERY'];
                    $function_on_off = $restaurant_delivery_order;
                    break;
                case 'reservations':
                    $class_name = 'reservation-food-action';
                    $function_name = $lang['RESERVATIONS'];
                    $function_on_off = $restaurant_reservations;
                    break;
                case 'takeaway':
                    $class_name = 'takeaway-action';
                    $function_name = $lang['TAKEAWAY'];
                    $function_on_off = $restaurant_takeaway_order;
                    break;
                default:
                    $function_name = $lang['MENU'];
                    $class_name = 'menu-action';
                    $function_on_off = 0;
                    break;
            }
            if ($info['function'] != 'menu') {
                $function_not_image[$count]['id'] = $info['id'];
                $function_not_image[$count]['function'] = $info['function'];
                $function_not_image[$count]['function_name'] = $function_name;
                $function_not_image[$count]['class_name'] = $class_name;
                $function_not_image[$count]['function_on_off'] = $function_on_off;
            }
            $function[$count]['id'] = $info['id'];
            $function[$count]['function'] = $info['function'];
            $function[$count]['image'] = $info['image'];
            $function[$count]['position'] = $info['position'];
            $function[$count]['function_name'] = $function_name;
            $function[$count]['class_name'] = $class_name;
            $function[$count]['function_on_off'] = $function_on_off;
            $count++;
        }

        $page->SetLoop('CANCELLATION_REASON', $cancellation_reason);
        $page->SetLoop('FUNCTION', $function);
        $page->SetLoop('FUNCTION2', $function_not_image);
        $page->SetLoop('FUNCTION3', $function);
        $page->SetLoop('COLORS', $colors);
        $page->SetParameter('OVERALL_HEADER', create_header($lang['RESTAURANT']));
        $page->SetParameter('SITE_TITLE', $config['site_title']);
        $page->SetParameter('SHOW_LANGS', count($language));
        $page->SetLoop('LANGS', $language);
        $page->SetLoop('LANGS2', $language);
        $page->SetParameter('LATLNG', $latlng);
        $page->SetParameter('OPEN_CLOSE_HOUR', $open_time);
        $page->SetParameter('RESTAURANT_TEMPLATE', $restaurant_template);
        $page->SetParameter('RESTAURANT_SEND_ORDER', $allow_order);
        $page->SetParameter('RESTAURANT_ON_TABLE_ORDER', $restaurant_on_table_order);
        $page->SetParameter('RESTAURANT_LOGGIN_REGISTER', $allow_loggin_register);
        $page->SetParameter('RESTAURANT_TAKEAWAY_ORDER', $restaurant_takeaway_order);
        $page->SetParameter('RESTAURANT_DELIVERY_ORDER', $restaurant_delivery_order);
        $page->SetParameter('RESTAURANT_BOOKING', $restaurant_booking);
        $page->SetParameter('RESTAURANT_RESERVATIONS', $restaurant_reservations);
        $page->SetParameter('RESTAURANT_SHOW_POPPUP', $show_poppup);

        $page->SetParameter('RESTAURANT_ONLINE_PAYMENT', $allow_payment);
        $page->SetParameter('CAT_MENU_DISCOUNT', $menu_tpl_discount);
        $page->SetParameter('MENU_DISCOUNT_COUNT', $menu_discount_count);
        $page->SetParameter('RESTAURANT_MENU_REDUCED', $restaurant_menu_reduced);
        $page->SetParameter('ALLEGIE', $Allegie_list);
        $page->SetParameter('ADDITIVES', $Additives_list);
        $page->SetParameter('PROPERTIES', $Properties_list);
        $page->SetLoop('CATEGORY', $category);
        $page->SetLoop('CATEGORY2', $category);
        $page->SetLoop('CAT_MENU', $cat);
        $page->SetLoop('IMAGE_MENU', $image_menu);
        $page->SetLoop('IMAGE', $image);
        $page->SetLoop('IMAGE2', $image);
        $page->SetLoop('STORY_IMAGE', $story_image);
        $page->SetParameter('RESTRO_ID', $restro_id);
        $page->SetParameter('NAME', $name);
        $page->SetParameter('SUB_TITLE', $sub_title);

        $page->SetParameter('ADDRESS', $address);
        $page->SetParameter('PHONE', $restaurant['phone_number']);
        $page->SetParameter('EMAIL', $email);
        $page->SetParameter('GMAP_API_KEY', $gmap_api_key);
        $page->SetParameter('OPEN_HOUR_1', $sOpenHour_1_f);
        $page->SetParameter('OPEN_HOUR_2', $sOpenHour_2_f);
        $page->SetParameter('OPEN_HOUR_3', $sOpenHour_3_f);
        $page->SetParameter('OPEN_HOUR_4', $sOpenHour_4_f);
        $page->SetParameter('OPEN_HOUR_5', $sOpenHour_5_f);
        $page->SetParameter('OPEN_HOUR_6', $sOpenHour_6_f);
        $page->SetParameter('OPEN_HOUR_7', $sOpenHour_7_f);
        $page->SetParameter('SLUG', $slug);
        $page->SetParameter('SLUG-2', $slug);
        $page->SetParameter('MAIN_IMAGE', $main_image);
        $page->SetParameter('MAIN_IMAGE_BG_WHITE', $main_image_bg_white);
        $page->SetParameter('COVER_IMAGE', $cover_image);
        $page->SetParameter('LATITUDE', $mapLat);
        $page->SetParameter('LONGITUDE', $mapLong);
        $page->SetParameter('MAP_COLOR', $config['map_color']);
        $page->SetParameter('ZOOM', $config['home_map_zoom']);
        $page->SetParameter('CURRENCY_SIGN', $currency_data['html_entity']);
        $page->SetParameter('CURRENCY_LEFT', $currency_data['in_left']);
        $page->SetParameter('CURRENCY_DECIMAL_PLACES', $currency_data['decimal_places']);
        $page->SetParameter('CURRENCY_DECIMAL_SEPARATOR', $currency_data['decimal_separator']);
        $page->SetParameter('CURRENCY_THOUSAND_SEPARATOR', $currency_data['thousand_separator']);
        $page->SetParameter('MENU_LAYOUT', $menu_layout);
        $page->SetParameter('TOTAL_MENUS', json_encode($total_menus));
        $page->SetParameter('PAGE_TITLE', $name);
        $page->SetParameter('PAGE_LINK', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $page->SetParameter('PAGE_META_KEYWORDS', $config['meta_keywords']);
        $page->SetParameter('PAGE_META_DESCRIPTION', $config['meta_description']);
        $page->SetParameter('LANGUAGE_DIRECTION', get_current_lang_direction());
        $page->SetParameter('RESTAURANT_CHANGE_THEME', get_restaurant_option($restro_id, 'restaurant_change_theme', 'image'));
        $page->SetParameter('RESTAURANT_BACKGROUND_COLOR', get_restaurant_option($restro_id, 'restaurant_background_color', '#a1b7e8'));
        $restaurant_change_theme = get_restaurant_option($restro_id, 'restaurant_change_theme', 'image');
        if ($restaurant_change_theme != 'color') {
            $page->SetParameter('RESTAURANT_BACKGROUND_IMAGE', get_restaurant_option($restro_id, 'restaurant_background_image', 'default.jpg'));
        }

        if (isset($_SESSION['access_token'])) {

            $access_token = $_SESSION['access_token'];
            if (checkcustomerloggedin($restro_id)) {
                $page->SetParameter('CUSTOMER_ID', $_SESSION['customer']['id']);
                $page->SetParameter('CUSTOMER_USERNAME', $_SESSION['customer']['username']);
            } else {
                $page->SetParameter('CUSTOMER_ID', '');
                $page->SetParameter('CUSTOMER_USERNAME', '');
                unset($_SESSION['customer']);
            }
            $page->SetParameter('CUSTOMER_NAME', $_SESSION['quickad'][$access_token]['customer_name']);
            $page->SetParameter('CUSTOMER_PHONE', $_SESSION['quickad'][$access_token]['phone_number']);
            $page->SetParameter('CUSTOMER_EMAIL', $_SESSION['quickad'][$access_token]['email']);
            $page->SetParameter('CUSTOMER_ADDRESS', $_SESSION['quickad'][$access_token]['address']);
            $page->SetParameter('CUSTOMER_HOUSE_NUMBER', $_SESSION['quickad'][$access_token]['house_number']);
            $page->SetParameter('CUSTOMER_STREET_NAME', $_SESSION['quickad'][$access_token]['street_name']);
            $page->SetParameter('CUSTOMER_CITY', $_SESSION['quickad'][$access_token]['city']);
            $page->SetParameter('CUSTOMER_ZIP_CODE', $_SESSION['quickad'][$access_token]['zip_code']);
            $page->SetParameter('CUSTOMER_MESSAGE',   $_SESSION['quickad'][$access_token]['message']);
            $page->SetParameter('CUSTOMER_TAKEAWAY_DELIVERY_TIME',  $_SESSION['quickad'][$access_token]['takeaway_delivery_time']);
        } else {
            if (checkcustomerloggedin($restro_id)) {
                $page->SetParameter('CUSTOMER_ID', $_SESSION['customer']['id']);
                $page->SetParameter('CUSTOMER_USERNAME', $_SESSION['customer']['username']);
                $page->SetParameter('CUSTOMER_NAME', $_SESSION['customer']['name']);
                $page->SetParameter('CUSTOMER_PHONE', $_SESSION['customer']['phone']);
                $page->SetParameter('CUSTOMER_EMAIL', $_SESSION['customer']['email']);
                $page->SetParameter('CUSTOMER_ADDRESS',  $_SESSION['customer']['address']);
                $page->SetParameter('CUSTOMER_HOUSE_NUMBER', $_SESSION['customer']['house_number']);
                $page->SetParameter('CUSTOMER_STREET_NAME', $_SESSION['customer']['street_name']);
                $page->SetParameter('CUSTOMER_CITY', $_SESSION['customer']['city']);
                $page->SetParameter('CUSTOMER_ZIP_CODE', $_SESSION['customer']['zip_code']);
                $page->SetParameter('CUSTOMER_MESSAGE',  '');
                $page->SetParameter('CUSTOMER_TAKEAWAY_DELIVERY_TIME', '');
            } else {
                unset($_SESSION['customer']);
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
            }
        }
        $page->SetParameter('RESTAURANT_STORY1_IMAGE', get_restaurant_option($restro_id, 'restaurant_story1_image', 'default.png'));
        $page->SetParameter('RESTAURANT_FEATURED_IMAGE', get_restaurant_option($restro_id, 'restaurant_featured_image', 'default.png'));
        $page->SetParameter('RESTAURANT_BACKGROUND_IMAGE_HOME_PAGE', get_restaurant_option($restro_id, 'restaurant_background_image_home_page', 'default.png'));
        $page->SetParameter('RESTAURANT_LINK_TWITTER', get_restaurant_option($restro_id, 'restaurant_link_twitter'));
        $page->SetParameter('RESTAURANT_LINK_FACEBOOK', get_restaurant_option($restro_id, 'restaurant_link_facebook'));
        $page->SetParameter('RESTAURANT_LINK_INSTAGRAM', get_restaurant_option($restro_id, 'restaurant_link_instagram'));
        $page->SetParameter('RESTAURANT_OPEN_STORY', $restaurant_open_story);
        $page->SetParameter('RESTAURANT_DISCOVER_TEXT', $discorver_text);
        $page->SetParameter('DESCRIPTION', $res_description);
        $page->SetParameter('RESTAURANT_IMAGE_FEATURED_TITLE', $featured_title);
        $page->SetParameter('RESTAURANT_IMAGE_FEATURED_DESC', $featured_description);

        $page->SetParameter('RESTAURANT_OPEN_IMAGE_ADVERTISEMENT', $restaurant_open_image_advertisement);
        $page->SetParameter('RESTAURANT_TEMPLATE_IMAGE_WITH_THUMB', get_restaurant_option($restro_id, 'restaurant_template_image_with_thumb', 1));
        $page->SetParameter('RESTAURANT_OPEN_BANNER', $restaurant_open_banner);
        $page->SetParameter('TABLE_NUMBER', $table);
        $page->SetParameter('PDF_MENU', $pdf_menu);
        $page->SetParameter('RESTAURANT_TABLE_CONFIRM', get_restaurant_option($restro_id, 'restaurant_table_confirm', 0));
        $page->SetParameter('RESTAURANT_SECOND_POPUP', get_restaurant_option($restro_id, 'restaurant_second_popup', 0));
        $page->SetParameter('RESTAURANT_POPUP_MESSAGES_ON_OFF', get_restaurant_option($restro_id, 'restaurant_popup_messages_on_off', 0));
        $page->SetParameter('RESTAURANT_POPUP_MESSAGES', get_restaurant_option($restro_id, 'restaurant_popup_messages', ''));
        $page->SetParameter('MIN_HOUR_EDIT_PRE_ORDER', get_restaurant_option($restro_id, 'restaurant_min_hour_edit_pre_order', 1));
        $page->SetParameter('MIN_TOTAL_AMOUNT_ON_TABLE_ORDER', get_restaurant_option($restro_id, 'restaurant_min_total_amount_on_table_order', 0));
        $page->SetParameter('MIN_TOTAL_AMOUNT_ONLINE_ORDER', get_restaurant_option($restro_id, 'restaurant_min_total_amount_online_order', 0));
        $page->SetParameter('MIN_TOTAL_AMOUNT_PRE_ORDER', get_restaurant_option($restro_id, 'restaurant_min_total_amount_pre_order', 0));
        $page->SetParameter('ONLY_ON_TABLE', $config['only_on_table']);
        $page->SetParameter('OPEN_HOURS_TODAY', $open_hours_today);
        $page->SetParameter('RESTAURANT_MENU_FORE_COLOR', get_restaurant_option($restro_id, 'restaurant_menu_fore_color', '#333'));
        $page->SetParameter('RESTAURANT_MENU_COLOR', get_restaurant_option($restro_id, 'restaurant_menu_color', '#B7AAAA'));
        $page->SetParameter('RESTAURANT_ID', $restro_id);
        $page->SetParameter('ITEM_ID', $item_id);
        $page->SetParameter('ACTION', $action);
        $page->SetParameter('ORDER_LINK', $order_link);
        $page->SetParameter('RESTAURANT_LINK', $restaurant_link);
        $page->SetParameter('COOKIE_ACCEPTANCE', $cookie_acceptance);
        
        $page->SetParameter('RESTAURANT_DISPLAY_MENU_IMAGE', get_restaurant_option($restro_id, 'restaurant_display_menu_image', 1));
        $page->SetParameter('RESTAURANT_DISPLAY_MENU_ID', get_restaurant_option($restro_id, 'restaurant_display_menu_id', 1));
        $page->SetParameter('RESTAURANT_DISPLAY_MENU_PRICE', get_restaurant_option($restro_id, 'restaurant_display_menu_price', 1));

        $page->SetParameter('RESTAURANT_POSITION_FEATURED', get_restaurant_option($restro_id, 'restaurant_position_featured', 'right'));
        $page->SetParameter('RESTAURANT_POSITION_DESCRIPTION', get_restaurant_option($restro_id, 'restaurant_position_description', 'left'));
        $page->SetParameter('RESTAURANT_CHANGE_HOME_BACKGROUND_IMAGE', get_restaurant_option($restro_id, 'restaurant_change_home_background_image', 1));
        $page->SetParameter('RESTAURANT_DISCOUNT_ICON', get_restaurant_option($restro_id, 'restaurant_discount_icon','discount_default.png'));
        $page->SetParameter('RESTAURANT_NEW_ICON', get_restaurant_option($restro_id, 'restaurant_new_icon','new_default.png','new_default'));
        $page->SetParameter('OVERALL_FOOTER', create_footer());
        $page->CreatePageEcho();
    } else {
        error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
        exit();
    }
} else {
    error($lang['PAGE_NOT_FOUND'], __LINE__, __FILE__, 1);
    exit();
}
