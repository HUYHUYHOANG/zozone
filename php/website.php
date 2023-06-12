<?php
if (checkloggedin()) {

    if(isEmployer()){
        headerRedirect('./reservations'); exit;
    }

    require('ctrls/lib/request.lib.php');
    require('ctrls/bo/CFr3eGoogl3Translat3.class.php');

    $ggtl = new CFr3eGoogl3Translat3();
    $user_lang = $config['lang_code'];

    //begin fix translate data
    if(isset($_GET['translate']) && $_GET['translate']=='true' && isset($_GET['src']) && $_GET['src']=='de'){
        set_time_limit(0);        
        if(1){
            /*
            echo "<br/>Image Groups <strong>{$name}</strong> : ";
            $rows = ORM::forTable('qr_shop_image_group')->find_many();
            foreach($rows as $r){
                $name = $r['name'];
                $id = $r['id'];
                $viName = $ggtl->translate('en', 'vi', $name);    
                $deName = $ggtl->translate('en', 'de', $name);
                $translated = json_encode( array('en'=>$name, 'de' => array('title'=> $deName), 'vi' => array('title'=>$viName)) , JSON_UNESCAPED_UNICODE );
                $data = array('id' => $id, 'translation' => $translated);
                $sql = "UPDATE qr_shop_image_group SET translation=:translation WHERE id=:id";
                echo "<br/>Translate and update <strong>{$name}</strong> : ";
                $ret = ORM::get_db()->prepare($sql)->execute($data);
                echo $ret ? " DONE..." : " FAILED...";
                ob_flush();
                flush();
                sleep(1);
            }*/
            $rows = ORM::forTable('qr_shop')->find_many();
            foreach($rows as $r){
                $id = $r['id']; $shopName = $r['name']; $shopSubTitle = $r['sub_title']; $shopDesc = $r['description'];
                $json['de'] = array(
                    'name' => $ggtl->translate('en', 'de', $shopName),
                    'sub_title' => $ggtl->translate('en', 'de', $shopSubTitle),
                    'description' => $shopDesc ? $ggtl->translate('en', 'de', $shopDesc) : ''
                );
                $json['vi'] = array(
                    'name' => $ggtl->translate('en', 'vi', $shopName),
                    'sub_title' => $ggtl->translate('en', 'vi', $shopSubTitle),
                    'description' => $shopDesc ? $ggtl->translate('en', 'vi', $shopDesc) : ''
                );
                $translated = json_encode( $json , JSON_UNESCAPED_UNICODE );
                $data = array('id' => $id, 'translation' => $translated);
                $sql = "UPDATE qr_shop SET translation=:translation WHERE id=:id";
                echo "<br/>Translate and update <strong>{$shopName}</strong> : ";
                $ret = ORM::get_db()->prepare($sql)->execute($data);
            }            
            echo "<br/>---------------------<br/>Redirecting ...<script>document.location='./website';</script>";        
            ob_flush();
            flush();
            sleep(1);
            exit;
        }
    }

    $shop = ORM::for_table($config['db']['pre'] . 'shop')
        ->where('id', $_SESSION['user']['shop_id'])
        ->find_one();
    $shop_id = $shop['id'];

    $errors = array();
    //$shop_setting_display_website = get_module_settting($shop_id, 'website');    
    $shop_setting_display_website = 1;    
    if (isset($_POST['submit'])) {
        
        if (count($errors) == 0) {
            $now = date("Y-m-d H:i:s");
            if ($shop_setting_display_website) {
                if (isset($_POST['shop_open_banner'])) {
                    update_shop_option($shop_id, 'shop_open_banner', $_POST['shop_open_banner']);
                } else {
                    update_shop_option($shop_id, 'shop_open_banner', 0);
                }                
                
                $langs = JsonHelper::getActiveLangCodes();
                $pos = array_search($user_lang, $langs);
                if($pos !== false) unset($langs[$pos]);
                $options = array('shop_title_story', 'shop_sub_title_story', 'shop_story', 'shop_popup_messages');
                foreach($options as $option){
                    $json = array();
                    $content = CRequest::postStr($option);
                    if( $content){
                  
                        if($user_lang=='de'){
                            foreach($langs as $desc_lang){
                                $json[$desc_lang] = $ggtl->translate($user_lang, $desc_lang, $content);
                            }
                            $json[$user_lang] = $content;
                            reset($langs);
                            update_shop_option($shop_id, $option, json_encode($json, JSON_UNESCAPED_UNICODE) );
                        }else{
                            
                              //  $json = json_decode(get_shop_option($shop_id, $option)) 
                                $json[$user_lang] = $content;
                                update_shop_option($shop_id, $option, json_encode($json, JSON_UNESCAPED_UNICODE) );
                             
                            
                        }
                    }
                }
                
              

                update_shop_option($shop_id, 'shop_open_story', isset($_POST['shop_open_story']) ? 1 : 0);                
                //update_shop_option($shop_id, 'shop_sub_title_story', $_POST['shop_sub_title_story']);
                //update_shop_option($shop_id, 'shop_story', $_POST['shop_story']);
            }
            if (isset($_POST['shop_popup_messages_on_off'])) {
                update_shop_option($shop_id, 'shop_popup_messages_on_off', $_POST['shop_popup_messages_on_off']);
            } else {
                update_shop_option($shop_id, 'shop_popup_messages_on_off', 0);
            }

            update_shop_option($shop_id, 'shop_second_popup', $_POST['shop_second_popup']);
            //update_shop_option($shop_id, 'shop_popup_messages', $_POST['shop_popup_messages']);
            update_shop_option($shop_id, 'shop_theme_color', $_POST['shop_theme_color']);
            update_shop_option($shop_id, 'shop_fore_color', $_POST['shop_fore_color']);
            update_shop_option($shop_id, 'shop_background_color', $_POST['shop_background_color']);
            update_shop_option($shop_id, 'shop_template', $_POST['shop_template']);

            update_shop_option($shop_id, 'shop_open_contact', $_POST['shop_open_contact']);
            update_shop_option($shop_id, 'shop_order_service', $_POST['shop_order_service']);
            update_shop_option($shop_id, 'shop_display_price', $_POST['shop_display_price']);
            update_shop_option($shop_id, 'shop_display_group_image', $_POST['shop_display_group_image']);

            update_shop_option($shop_id, 'shop_display_our_staffs', $_POST['shop_display_our_staffs']);
            update_shop_option($shop_id, 'shop_display_special_offer', $_POST['shop_display_special_offer']);

            transfer($link['WEBSITE'], $lang['SAVED_SUCCESS'], $lang['SAVED_SUCCESS']);
            exit;
        }
    }

    if (isset($shop['id'])) {
        $name = $shop['name'];
        $slug = $shop['slug'];
        $sub_title = $shop['sub_title'];
        $taxcode = $shop['taxcode'];
        $house_number = $shop['house_number'];
        $street_name = $shop['street_name'];
        $zipcode = $shop['zipcode'];
        $city = $shop['city'];
        $phone_number = $shop['phone_number'];
        $description = stripcslashes(nl2br($shop['description']));
        $address = $shop['address'];
        $mapLat = $shop['latitude'];
        $mapLong = $shop['longitude'];
        $main_image = $shop['main_image'];

        $shopTranslation = (array)json_decode($shop['translation']);

        if (!empty($slug)) {
            $shop_link = $config['site_url'] . $slug;
        } else {
            $shop_link = $link['SHOP'] . '/' . $shop_id;
        }

    } else {
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
        $main_image = 'default.png';
        $mapLat     =  get_option("home_map_latitude");
        $mapLong    =  get_option("home_map_longitude");
        $restaurant_link = '#';
        
        $shopTranslation = 0;
    }

    $shop_templates = array();

    $shop_templates_setting = "all";
    $shop_template =   get_shop_option($shop_id, 'shop_template', 'classic-theme');

    if ($handle = opendir('shop-templates/')) {
        while (false !== ($folder = readdir($handle))) {
            if ($folder != "." && $folder != "..") {
                $filepath = "shop-templates/" . $folder . "/theme-info.txt";
                if (file_exists($filepath)) {
                    $themefile = fopen($filepath, "r");

                    $themeinfo = array();
                    while (!feof($themefile)) {
                        $lineRead = fgets($themefile);
                        if (strpos($lineRead, ':') !== false) {
                            $line = explode(':', $lineRead);
                            $key = trim($line[0]);
                            $value = trim($line[1]);
                            $themeinfo[$key] = $value;
                        }
                    }
                    if ($shop_templates_setting == "all" || $shop_templates_setting == $folder) {
                        $shop_templates[$folder]['folder'] = $folder;
                        $shop_templates[$folder]['name'] = $themeinfo['Theme Name'];
                    }
                    fclose($themefile);
                }
            }
        }
        closedir($handle);
    }

    $content_slider_banner = '';
    $images = ORM::for_table($config['db']['pre'] . 'shop_image')
        ->where(array('shop_id' => $shop['id']/*, 'image_type' => 'banner'*/))
        ->find_many();
    //print_r($images);
    foreach ($images as $image) {        
        $content_slider_banner .= getBannerSliderItemContent($image, $config['site_url']);
    }

    //SHOP_GROUP_IMAGE
    $count = 0;
    $result = ORM::for_table($config['db']['pre'] . 'shop_image_group')
        ->where(array(
            'shop_id' => $shop['id']
        ))
        ->order_by_asc('id')
        ->find_many();

    $user_lang = $config['lang_code'];
    $shop_group_image = array();
    foreach ($result as $info) {
        $shop_group_image[$count]['count'] = $count;
        $shop_group_image[$count]['id'] = $info['id'];
        $shop_group_image[$count]['active'] = $info['active'];

        $img_group_name = $info['name'];
        $json = json_decode($info['translation']);
        if($json && isset($json->{$user_lang}->title)) $img_group_name = $json->{$user_lang}->title;
        $shop_group_image[$count]['name'] = $img_group_name;
        $count++;
    }

    //END SHOP_GROUP_IMAGE
    //open time
    $opentime_data = array();
    $table = $config['db']['pre'] . 'open_close_hour';
    $sql = "SELECT id, day_of_week, day_of_week_to, open_hour, 	close_hour, open_hour_2, close_hour_2, is_from_to,
                    ( CASE WHEN day_of_week='sunday' then 0 WHEN day_of_week='monday' then 1 WHEN day_of_week='tuesday' then 2 
                    WHEN day_of_week='wednesday' then 3 WHEN day_of_week='thursday' then 4 WHEN day_of_week='friday' then 5 
                    WHEN day_of_week='saturday' then 6 END ) as day_nbr
                FROM {$table} WHERE shop_id={$shop['id']} ORDER by day_nbr ASC";
    
    $open_time_result = ORM::forTable($table)->rawQuery($sql)->findMany();
    foreach ($open_time_result as $info) {
        switch ($info['day_of_week']) {
            case 'sunday':
                $day_of_week = $lang['SUNDAY'];
                break;
            case 'monday':
                $day_of_week = $lang['MONDAY'];
                break;
            case 'tuesday':
                $day_of_week = $lang['TUESDAY'];
                break;
            case 'wednesday':
                $day_of_week = $lang['WEDNESDAY'];
                break;
            case 'thursday':
                $day_of_week = $lang['THURSDAY'];
                break;
            case 'friday':
                $day_of_week = $lang['FRIDAY'];
                break;
            case 'saturday':
                $day_of_week = $lang['SATURDAY'];
                break;
            default:
                $day_of_week = '';
                break;
        }

        switch ($info['day_of_week_to']) {
            case 'sunday':
                $day_of_week_to = $lang['SUNDAY'];
                break;
            case 'monday':
                $day_of_week_to = $lang['MONDAY'];
                break;
            case 'tuesday':
                $day_of_week_to = $lang['TUESDAY'];
                break;
            case 'wednesday':
                $day_of_week_to = $lang['WEDNESDAY'];
                break;
            case 'thursday':
                $day_of_week_to = $lang['THURSDAY'];
                break;
            case 'friday':
                $day_of_week_to = $lang['FRIDAY'];
                break;
            case 'saturday':
                $day_of_week_to = $lang['SATURDAY'];
                break;
            default:
                $day_of_week_to = '';
                break;
        }
        $opentime_data[$info['id']]['id'] = $info['id'];
        $opentime_data[$info['id']]['day_of_week'] = !empty($day_of_week_to) ? $day_of_week . '-' . $day_of_week_to : $day_of_week;
        $opentime_data[$info['id']]['open_hour'] = $info['open_hour'];
        $opentime_data[$info['id']]['close_hour'] = $info['close_hour'];
        $opentime_data[$info['id']]['open_hour_2'] = $info['open_hour_2'];
        $opentime_data[$info['id']]['close_hour_2'] = $info['close_hour_2'];
        $opentime_data[$info['id']]['day_of_week_value'] = $info['day_of_week'];
        $opentime_data[$info['id']]['day_of_week_to_value'] = $info['day_of_week_to'];
        $opentime_data[$info['id']]['is_from_to'] = $info['is_from_to'];
    }


    $restaurant_change_theme = "image";
    $restaurant_online_payment = $allow_order;


    //end open time
    $page = new HtmlTemplate('templates/' . $config['tpl_name'] . '/website.tpl');
    $rightMenu = '';
    $page->SetParameter ('OVERALL_SIDEBAR', sidebar_add_custom_menu_items($rightMenu));
    $page->SetParameter('OVERALL_HEADER', create_header($lang['MANAGE_SHOP']));
    $page->SetParameter ('OVERALL_RIGHT_NOTIFICATION_MENU', $rightMenu);
    $page->SetParameter('SITE_TITLE', $config['site_title']);
    if (count($errors) > 0) {
        $page->SetLoop('ERRORS', $errors);
    } else {
        $page->SetLoop('ERRORS', "");
    }
    $page->SetLoop('OPEN_CLOSE_HOUR', $opentime_data);
    $page->SetLoop('SHOP_TEMPLATES', $shop_templates);
    $page->SetLoop('SHOP_GROUP_IMAGE', $shop_group_image);

    $page->SetParameter('SHOP_BACKGROUND_IMAGE', get_shop_option($shop_id, 'shop_background_image'));
    $page->SetParameter('SHOP_SETTING_DISPLAY_WEBSITE', $shop_setting_display_website);

    $page->SetParameter('SHOP_CHANGE_THEME', $shop_change_theme);
    $page->SetParameter('SHOP_TEMPLATE', $shop_template);

    $page->SetParameter('SHOP_LINK_TWITTER', get_shop_option($shop_id, 'shop_link_twitter'));
    $page->SetParameter('SHOP_LINK_FACEBOOK', get_shop_option($shop_id, 'shop_link_facebook'));
    $page->SetParameter('SHOP_LINK_INSTAGRAM', get_shop_option($shop_id, 'shop_link_instagram'));


    $page->SetParameter('HOUSE_NUMBER', $house_number);
    $page->SetParameter('ZIPCODE', $zipcode);
    $page->SetParameter('CITY', $city);
    $page->SetParameter('PHONE_NUMBER', $phone_number);
    $page->SetParameter('TAXCODE', $taxcode);
    $page->SetParameter('STREET_NAME', $street_name);
    $page->SetParameter('SHOP_LINK', $shop_link);
    $page->SetParameter('SHOP_ID', $shop_id);

    $page->SetParameter('NAME', $shopTranslation && isset($shopTranslation[$user_lang]) && isset($shopTranslation[$user_lang]->name) ? $shopTranslation[$user_lang]->name : $name);
    $page->SetParameter('SUB_TITLE', $shopTranslation && isset($shopTranslation[$user_lang]) && isset($shopTranslation[$user_lang]->sub_title) ? $shopTranslation[$user_lang]->sub_title : $sub_title);
    $page->SetParameter('SHOP_DESCRIPTION', $shopTranslation && isset($shopTranslation[$user_lang]) && isset($shopTranslation[$user_lang]->description) ? $shopTranslation[$user_lang]->description : $description);

    //$page->SetParameter('NAME', $name);   
    //$page->SetParameter('SUB_TITLE', $sub_title);
    //$page->SetParameter('DESCRIPTION', $description);

    $page->SetParameter('SLUG', $slug);    
    $page->SetParameter('OPEN_TIME', $open_time);
    $page->SetParameter('CLOSE_TIME', $close_time);    
    $page->SetParameter('ADDRESS', $address);
    $page->SetParameter('MAIN_IMAGE', $main_image);
    $page->SetParameter('MAP_COLOR', $config['map_color']);
    $page->SetParameter('ZOOM', $config['home_map_zoom']);
    $page->SetParameter('SHOP_SECOND_POPUP', get_shop_option($shop_id, 'shop_second_popup', 0));
    $page->SetParameter('SHOP_POPUP_MESSAGES_ON_OFF', get_shop_option($shop_id, 'shop_popup_messages_on_off', 0));

    $page->SetParameter('SHOP_POPUP_MESSAGES', JsonHelper::getValByLangCode(get_shop_option($shop_id, 'shop_popup_messages'), $user_lang));    
    
    $page->SetParameter('SHOP_OPEN_STORY', get_shop_option($shop_id, 'shop_open_story', 1));

    $page->SetParameter('TIMER_COVER_IMAGE', get_shop_option($shop_id, 'timer_cover_image', 5));
    $page->SetParameter('TIMER_FOOTER_IMAGE', get_shop_option($shop_id, 'timer_footer_image', 5));

    $page->SetParameter('SHOP_TITLE_STORY', JsonHelper::getValByLangCode(get_shop_option($shop_id, 'shop_title_story'), $user_lang));
    $page->SetParameter('SHOP_SUB_TITLE_STORY', JsonHelper::getValByLangCode(get_shop_option($shop_id, 'shop_sub_title_story'), $user_lang));    
    $page->SetParameter('SHOP_STORY', JsonHelper::getValByLangCode(get_shop_option($shop_id, 'shop_story'), $user_lang));

    $page->SetParameter('SHOP_THEME_COLOR', get_shop_option($shop_id, 'shop_theme_color', $config['theme_color']));
    $page->SetParameter('SHOP_FORE_COLOR',  get_shop_option($shop_id, 'shop_fore_color', '#ffffff'));
    $page->SetParameter('SHOP_OPEN_BANNER', get_shop_option($shop_id, 'shop_open_banner', 1));
    $page->SetParameter('SHOP_OPEN_FOOTER_IMAGE', get_shop_option($shop_id, 'shop_open_footer_image', 0));
    $page->SetParameter('SHOP_OPEN_CONTACT', get_shop_option($shop_id, 'shop_open_contact', 0));
    $page->SetParameter('SHOP_ORDER_SERVICE', get_shop_option($shop_id, 'shop_order_service', 0));
    $page->SetParameter('SHOP_DISPLAY_PRICE', get_shop_option($shop_id, 'shop_display_price', 0));
    $page->SetParameter('SHOP_DISPLAY_GROUP_IMAGE', get_shop_option($shop_id, 'shop_display_group_image', 0));
    
    $page->SetParameter('SHOP_SPECIAL_OFFER_DISPLAY', get_shop_option($shop_id, 'shop_display_special_offer', 0));
    $page->SetParameter('SHOP_OUR_STAFFS_DISPLAY', get_shop_option($shop_id, 'shop_display_our_staffs', 0));

    $page->SetParameter('SHOP_OUTSTANDING_SERVICE_IMAGE', get_shop_option($shop_id, 'shop_outstanding_service_image', 'default.png'));

    $page->SetParameter('CONTENT_SLIDER_BANNER', $content_slider_banner);
    $page->SetParameter('OVERALL_FOOTER', create_footer());

    $page->SetParameter('USER_AUTH_STRING', $_SESSION['user']['login_string']);
    $_SESSION['user']['site_url'] = $config['site_url'];
    $_SESSION['user']['tpl_name'] = $config['tpl_name'];  
    
    $customCss = '<link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/bootstrap-elms.css?v={VERSION}&t=' . date('ymdhis') . '">
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/custom-styles.css?v={VERSION}&t=' . date('ymdhis') . '">              
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/pages/customers-styles.css" />
              <link rel="stylesheet" type="text/css" href="{SITE_URL}templates/{TPL_NAME}/css/flaticon/flaticon.css" />
              <style>
                /*fix caret css isse*/
                .dropup .dropdown-toggle::after,.dropdown-toggle::after{display: none;}
                .dashboard-nav-inner ul li a{font-weight: normal;
                    font-family: Barlow Semi Condensed,nunito, helveticaneue, helvetica neue, Helvetica, Arial, sans-serif;}
                .dashboard-nav-inner ul li a:hover{text-decoration: none;}
                .dashboard-nav-inner ul li a svg.svg-dashboard-nav {top:6px !important;}
                .user-menu-small-nav li a svg.svg-dashboard-nav-small{position:relative;top:-2px;}
            </style>    ';

$addCss = 'a.flat-icon-wrap{margin:1px;height:32px;width:36px;display:inline-block;}     
i.flat-icon{    
    width:100%;
    margin:2px;
    min-width:36px;
    height:32px;
    display:block;
    border:1px solid #EEE;
    border-radius: 4px;    
    text-align:center;
    position: relative;    
    font-style:normal;
}
i.flat-icon:after{
    font-family: "Flaticon";
    position: absolute;
    left: 0px;
    top: 2px;
    width: 100%;
    height: 25px;
    font-size: 25px;
    color: var(--classic-color-1);
    line-height: 25px;
    opacity: 1;
    font-weight: 400;        
    transition: all 500ms ease;
}

i.flat-icon:hover{background: var(--classic-color-0_5);}
i.flat-icon.active, i.flat-icon.active:hover{background: var(--classic-color-1) !important;}
i.flat-icon.active:after, i.flat-icon:hover:after{
    color: #FFF !important;
}';

$iconCss = '';
for($i = 256; $i<=300; ++$i){
    $hex = dechex($i);
    $iconCss .= " i.flat-icon.icon-{$i}:after{ content: '\\f{$hex}';} ";
}

$customCss = $customCss . "<style>" . $addCss . $iconCss . "</style>";
    $page->SetParameter ('CUSTOM_CSS_FILES', $customCss); //css files

    $page->CreatePageEcho();
} else {
    headerRedirect($link['LOGIN']);
}

function getBannerSliderItemContent($image, $site_url){    
    $s = '<li>
        <div data-id="' . $image['id'] . '" class="input-file-slide">
            <img src="' . $site_url . '/storage/shop/cover/' . $image['image'] . '" id="shop_cover_image_' . $image['id'] . '">            
            <span class="delete_cover_image">&times;</span>
            <div class="uploadButton uploadButton-slider">
                <input class="uploadButton-input" type="file" accept="image/*" onchange="readImageURLAndEdit(this,&apos;shop_cover_image_' . $image['id'] . '&apos; , &apos;banner&apos;)" id="cover_upload_' . $image['id'] . '" name="shop_cover_image"/>
                <label class="uploadButton-slider-button ripple-effect" for="cover_upload_' . $image['id'] . '">Upload</label>
            </div>            
        </div>        
    </li>';    
    return preg_replace("/\r|\n|\t+|\s{3,}/", "", $s);
}

?>