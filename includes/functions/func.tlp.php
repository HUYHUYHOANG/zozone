<?php

///////
function get_menu_tpl_by_cat_id_Nail_templates($menu_tpl, $cat_id, $bGetNewMenu = false){
    
    global $config,  $lang, $currency, $shop_template, $allow_order, $total_menus, $shop, $translate;
    global $shop_order_service, $shop_display_price;
   $display_image =  get_shop_option($shop['id'], 'shop_display_menu_image',1);
   $display_id = get_shop_option($shop['id'], 'shop_display_menu_id',1);
   $display_price = get_shop_option($shop['id'], 'shop_display_menu_price',1); 
   $allow_order = $shop_order_service ? $shop_order_service : 0;
   $shop_menu_reduced = 1;

 
   if($allow_order == 1){
    $display_price = $allow_order;
   }else $display_price = $shop_display_price ? $shop_display_price : 0;

   $cat_name = '';
   if(!empty($cat_id)){
    $cat_result = ORM::for_table($config['db']['pre'] . 'catagory_main')
    ->where('cat_id', $cat_id)
    ->find_one();
    $cat_name = $cat_result['cat_name'];
   }

    if ($bGetNewMenu) {
        $menu = ORM::for_table($config['db']['pre'] . 'menu')
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
            ->order_by_asc('is_new_food')->find_many();

            
    } else {
        $sub_menus = array();
        array_push($sub_menus,$cat_id);
        $sub_menu_result =  ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->where(array(
            'parent' => $cat_id,
            'shop_id' => $shop['id']
        ))
        ->find_many();

        foreach ($sub_menu_result as $info) 
        {
            array_push($sub_menus,$info->cat_id);
        }
     
        $menu = ORM::for_table($config['db']['pre'] . 'menu')
            ->where(array(
                'shop_id' => $shop['id'],
                'active' => '1'
            ))
            ->where_in('cat_id', $sub_menus)
            ->order_by_asc('position')
            ->find_many();
    }
    $menu_count = 0;
    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
    
    $idx = 0;
    define('CALLED_FROM_NAIL',1);
    $item_html_part = 'shop-templates/' . $shop_template . '/template-parts/shop-items-by-category.html.php';
    ob_start();
   
    foreach ($menu as $info2) {
        if(empty($cat_id))
        {
         $cat_result = ORM::for_table($config['db']['pre'] . 'catagory_main')
         ->where('cat_id', $info2['cat_id'])
         ->find_one();
         $cat_name = $cat_result['cat_name'];
        }
        $menuId = $info2['id'];
       
        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
        $json = json_decode($info2['translation'], true);
        $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info2['name'];
        $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info2['description'];
        //$description = $info2['description'];
        $menuName = ucfirst($title);
        $menuDesc = nl2br($description);
        $menuType = $info2['type'];

        $menu_id = '';
        if (!empty($info2['menu_res_id'])) {
            $menu_id = $info2['menu_res_id'] . '. ';
        }
        $menuImage = $info2['image'];
        $discount_price = $info2['discount_price'];
        if ($shop_menu_reduced == "1") {
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
        if ($is_new_food) {
            $ribbon = '<span class="ribbon new-item"></span>';
        } elseif ($is_discount) {
            $ribbon = '<span class="ribbon discount-item"></span>';
        }
        $menu_data_array = array();
        $menu_data_array['id'] = $menuId;
        $menu_data_array['title'] = htmlentities((string)$menuName, ENT_QUOTES, 'UTF-8');
        $menu_data_array['price'] = $info2['price'];
        $menu_data_array['price_format'] = $menuPrice;
        $menu_data_array['type'] = $menuType;
        $menu_data_array['imgFullLink'] = $config['site_url'] . 'storage/menu/' . $menuImage;
        $menu_data_array['img'] =  $menuImage;
        $menu_data_array['description'] = $menuDesc . '&ensp;';
        $menu_data_array['extras'] = $extras;
        $menu_data_array['cat_name'] = $cat_name;
        $menu_data_array['menu_id'] = $menu_id;
        $total_menus[$menuId] = $menu_data_array;

        $menu_data_array['cat_id'] = $cat_id ? $cat_id : $info2['cat_id'];
        $menu_data_array['discount'] = $discount_price;
        $menu_data_array['currency'] = $currency;
        $menu_data_array['show_price'] = $display_price;
        $menu_data_array['show_id'] = $display_id;
        $menu_data_array['show_image'] = ($display_image) && ($menuImage!="default.png");
        $menu_data_array['show_order'] = $allow_order;
        $menu_data_array['image_path'] = $config['site_url'] . 'storage/menu/';

        $menu_data_array['duration'] = $info2['service_duration'] ? $info2['service_duration'] : 60;

        $data = &$menu_data_array;
        $data['ribbon'] = $ribbon;

        $menuName = ($data['show_id'] ?  $menu_id : '') . $menuName;
        $menuName = CShopHelper::splitWords($menuName, $bGetNewMenu ? ($display_id ? 24 : 60) : 60);
        $item_image = $menu_data_array['imgFullLink'];

        $s = '';
        if ($bGetNewMenu) { //list discount and/or new items
            require($item_html_part);
        }else{ //list all items section
            $dSubString  = 30;
            if($idx==0) echo '<div class="container"><div class="row no-margin">';            
            require($item_html_part);
            if(++$idx>=2){
                $idx = 0;
                echo '</div></div>'; //end row
            }            
        }      
              
        $menu_count++;
    }//foreach($menu as $info2)

    if($idx) echo '</div></div>'; //end row    
    $s = ob_get_contents();        
    ob_clean();
    ob_end_flush();

    $menu_tpl .= $s;  

    return $menu_tpl;
}


function get_menu_tpl_by_cat_id_peerly_templates($menu_tpl, $cat_id, $bGetNewMenu = false){
    
    global $config,  $lang, $currency, $shop_template, $allow_order, $total_menus, $shop, $translate;
    global $shop_order_service, $shop_display_price;
   $display_image =  get_shop_option($shop['id'], 'shop_display_menu_image',1);
   $display_id = get_shop_option($shop['id'], 'shop_display_menu_id',1);
   $display_price = get_shop_option($shop['id'], 'shop_display_menu_price',1); 
   $allow_order = $shop_order_service ? $shop_order_service : 0;
   $shop_menu_reduced = 1;

 
   if($allow_order == 1){
    $display_price = $allow_order;
   }else $display_price = $shop_display_price ? $shop_display_price : 0;

   $cat_name = '';
   if(!empty($cat_id)){
    $cat_result = ORM::for_table($config['db']['pre'] . 'catagory_main')
    ->where('cat_id', $cat_id)
    ->find_one();
    $cat_name = $cat_result['cat_name'];
   }

    if ($bGetNewMenu) {
        $menu = ORM::for_table($config['db']['pre'] . 'menu')
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
            ->order_by_asc('is_new_food')->find_many();

            
    } else {
        $sub_menus = array();
        array_push($sub_menus,$cat_id);
        $sub_menu_result =  ORM::for_table($config['db']['pre'] . 'catagory_main')
        ->where(array(
            'parent' => $cat_id,
            'shop_id' => $shop['id']
        ))
        ->find_many();

        foreach ($sub_menu_result as $info) 
        {
            array_push($sub_menus,$info->cat_id);
        }
     
        $menu = ORM::for_table($config['db']['pre'] . 'menu')
            ->where(array(
                'shop_id' => $shop['id'],
                'active' => '1'
            ))
            ->where_in('cat_id', $sub_menus)
            ->order_by_asc('position')
            ->find_many();
    }
    $menu_count = 0;
    $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
    
    $idx = 0;
    define('CALLED_FROM_NAIL',1);
    $item_html_part = 'shop-templates/' . $shop_template . '/template-parts/shop-items-by-category.html.php';
    ob_start();
   
    foreach ($menu as $info2) {
        if(empty($cat_id))
        {
         $cat_result = ORM::for_table($config['db']['pre'] . 'catagory_main')
         ->where('cat_id', $info2['cat_id'])
         ->find_one();
         $cat_name = $cat_result['cat_name'];
        }
        $menuId = $info2['id'];
       
        $user_lang = !empty($_COOKIE['Quick_user_lang_code']) ? $_COOKIE['Quick_user_lang_code'] : $config['lang_code'];
        $json = json_decode($info2['translation'], true);
        $title = !empty($json[$user_lang]['title']) ? $json[$user_lang]['title'] : $info2['name'];
        $description = !empty($json[$user_lang]['description']) ? $json[$user_lang]['description'] : $info2['description'];
        //$description = $info2['description'];
        $menuName = ucfirst($title);
        $menuDesc = nl2br($description);
        $menuType = $info2['type'];

        $menu_id = '';
        if (!empty($info2['menu_res_id'])) {
            $menu_id = $info2['menu_res_id'] . '. ';
        }
        $menuImage = $info2['image'];
        $discount_price = $info2['discount_price'];
        if ($shop_menu_reduced == "1") {
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
        if ($is_new_food) {
            $ribbon = '<span class="ribbon new-item"></span>';
        } elseif ($is_discount) {
            $ribbon = '<span class="ribbon discount-item"></span>';
        }
        $menu_data_array = array();
        $menu_data_array['id'] = $menuId;
        $menu_data_array['title'] = htmlentities((string)$menuName, ENT_QUOTES, 'UTF-8');
        $menu_data_array['price'] = $info2['price'];
        $menu_data_array['price_format'] = $menuPrice;
        $menu_data_array['type'] = $menuType;
        $menu_data_array['imgFullLink'] = $config['site_url'] . 'storage/menu/' . $menuImage;
        $menu_data_array['img'] =  $menuImage;
        $menu_data_array['description'] = $menuDesc . '&ensp;';
        $menu_data_array['extras'] = $extras;
        $menu_data_array['cat_name'] = $cat_name;
        $menu_data_array['menu_id'] = $menu_id;
        $total_menus[$menuId] = $menu_data_array;

        $menu_data_array['cat_id'] = $cat_id ? $cat_id : $info2['cat_id'];
        $menu_data_array['discount'] = $discount_price;
        $menu_data_array['currency'] = $currency;
        $menu_data_array['show_price'] = $display_price;
        $menu_data_array['show_id'] = $display_id;
        $menu_data_array['show_image'] = ($display_image) && ($menuImage!="default.png");
        $menu_data_array['show_order'] = $allow_order;
        $menu_data_array['image_path'] = $config['site_url'] . 'storage/menu/';

        $menu_data_array['duration'] = $info2['service_duration'] ? $info2['service_duration'] : 60;

        $data = &$menu_data_array;
        $data['ribbon'] = $ribbon;

        $menuName = ($data['show_id'] ?  $menu_id : '') . $menuName;
        $menuName = CShopHelper::splitWords($menuName, $bGetNewMenu ? ($display_id ? 24 : 60) : 60);
        $item_image = $menu_data_array['imgFullLink'];

        $s = '';
        if ($bGetNewMenu) { //list discount and/or new items
            require($item_html_part);
        }else{ //list all items section
            $dSubString  = 30;
            if($idx==0) echo '<div class="container"><div class="row no-margin">';            
            require($item_html_part);
            if(++$idx>=2){
                $idx = 0;
                echo '</div></div>'; //end row
            }            
        }      
              
        $menu_count++;
    }//foreach($menu as $info2)

    if($idx) echo '</div></div>'; //end row    
    $s = ob_get_contents();        
    ob_clean();
    ob_end_flush();

    $menu_tpl .= $s;  

    return $menu_tpl;
}

function _itemExtraInfo(&$data){
    ?>
    <div id="item-<?php echo $data['id']?>" class="item-hidden-data" style="display:none">
        <div class="row">
            <div class="col-sm-3 col-xs-3"><img src="<?php echo $data['imgFullLink'];?>"/></div>
            <div class="col-sm-6 col-xs-6">
                <h4><?php echo ($data['show_id'] ?  $data['menu_id'] : '') . $data['title']; ?></h4>
                <p><?php echo $data['description'] ?></p> 
            </div>
            <div class="col-sm-3 col-xs-3 text-right item-info-price">
                <?php
                    if($data['show_price']){                            
                        if($data['discount']) echo sprintf('<del style="display:block">%s</del>', price_format($data['price'], $data['currency']));
                    }
                    echo sprintf('<span class=""  style="display:block">%s</span>', $data['price_format']);
                ?>
            </div>
        </div>        
        <?php 
        if(!empty($data['extras'])){?>
        <div class="row" style="clear:both;">
            <div class="col-lg-12 col-xs-12 dlab-divider bg-gray-dark" style="margin:0;padding:0"><i class="icon-dot c-square"></i></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12 item-extras-info">
                <?php
                global $lang;
                echo '<ul><li><h6>'.$lang['EXTRAS'].'</h6><li>';
                foreach($data['extras'] as $i){
                    echo sprintf('<li>%s <span style="float:right;">%s</span></li>', $i['title'], price_format($i['price'], $data['currency']));
                }
                echo '</ul>';
            ?>
            </div>
        </div>
        <?php
        }?> 
    </div>
    <?php
}//_itemExtraInfo

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// HELPER CLASS - CALLED FROM shop.php OR in this file
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

class CShopHelper{
    public static function splitWords($str, $maxLength, $suffix="..."){
        if(strlen($str)<=$maxLength) return $str;
        $arr = explode(" ", $str);
        $words = count($arr);
        if(!$words || $words==1) return $str;
        $ret = "";
        for($i=0; $i<$words; ++$i){
            if(strlen($ret) + strlen($arr[$i]) < $maxLength) $ret .= ($ret ? " " : "") . $arr[$i];
            else break;			
        }		
        return $ret.$suffix;
    }

    public static function loadBookingModalTemplate($shopId){
        global $shop_template;
        $file = 'shop-templates/' . $shop_template . '/template-parts/booking.html.php';
        ob_start();  
        //require($file);    
        $page = new HtmlTemplate($file);
        $page->SetParameter('SHOP_TEMPLATE', $shop_template);
        $page->SetParameter('SERVICES_BY_CATEGORY', CShopHelper::loadAllServices());
        //$page->SetLoop('SHOP_PAYMENT_METHODS', CShopHelper::loadPaymentMethods($shopId));
        $staffs = 0;
        self::loadStaffsList($shopId, $staffs, 0);
        if($staffs) $page->SetLoop('STAFFS_LIST', $staffs);
        $page->CreatePageEcho();
        $s = ob_get_contents();
        ob_clean();
        ob_end_flush();
        return $s;
    }

    public static function loadPaymentMethods($shopId=0){
        global $config;
        $rows = ORM::for_table($config['db']['pre'] . 'payments')
                    ->where('payment_install', '1')->find_many();
        /*$rows = ORM::for_table($config['db']['pre'] . 'payments')
                    ->raw_query('SELECT * FROM qr_payments WHERE payment_install=1')->find_many();*/
        $data = 0;
        if($rows){
            $data = array();
            foreach($rows as $row){
                $payid = $row['payment_id'];
                $data[$payid]['id'] = $row['payment_id'];
                $data[$payid]['title'] = $row['payment_title'];
                $data[$payid]['folder'] = $row['payment_folder'];
                $data[$payid]['desc'] = $row['payment_desc'];
            }
        }   
        return $data;
    }

    public static function randomStr($length = 32){
        $keyspace = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#\$%^&*()_+=-|}{[]');
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }

        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public static function getCategoryImage($shopId, $catId){
        $sql = "SELECT image FROM qr_menu WHERE cat_id={$catId} AND active ORDER BY RAND() LIMIT 1";        
        $item = ORM::forTable('')->raw_query($sql) ->find_one();
        return $item ? $item['image'] : false;
    }

    public static function loadAllServices($catId = 0, $optionTagsOutput = 1, $langCode='de'){
        global $config, $shop, $currency;
        $sql = "SELECT m.id, m.name, m.service_spec_id, if(m.is_discount, m.discount_price, m.price) AS price, m.discount_price>0 AS is_discount, 
                        IF(discount_price>0, price-discount_price, 0) AS discount_amount,  
                        IF(m.service_duration, m.service_duration, 60) AS duration, 
                        m.image, c.cat_name, c.cat_id, m.translation FROM qr_menu m LEFT JOIN qr_catagory_main c 
                ON m.cat_id=c.cat_id WHERE " . ($catId>0 ? "m.cat_id={$catId} AND " : "") . " m.active='1' AND c.cat_id=m.cat_id AND c.shop_id=".$shop['id']." ORDER BY c.cat_name ASC, m.name ASC";
        
        $results = ORM::for_table($config['db']['pre'] . 'menu')->raw_query($sql)->find_many();  
        
        $numOfRows = count($results);        
        $idx = 0;
        if($optionTagsOutput){
            $prev_catId = -1;
            foreach($results as $row){                
                $cat_name = $row['cat_name'];
                $cat_id = $row['cat_id'];
                if($cat_id != $prev_catId){
                    if($prev_catId != -1){
                        echo '</optgroup>';
                    }
                    echo '<optgroup label="' . $row['cat_name'] . '">';
                    $prev_catId = $cat_id;
                }

                echo sprintf('<option value="%d" data-spec-id="%d" data-duration="%d" data-subtext="%s\' | %s %s">%s</option>', $row['id'], $row['cat_id'], $row['duration'], $row['duration'], $row['price'], $currency, $row['name']);
                
                if(++$i >= $numOfRows){
                    echo '</optgroup>';
                }
            }
            $s = ob_get_contents();        
            ob_clean();
            ob_end_flush();    
            ob_start();    
            return $s;
        }else{            
            $data = array();            
            foreach($results as $row){
                $json = json_decode($row['translation']);                
                $name = $row['name'];
                if(isset($json->{$langCode})){                    
                    if(isset($json->{$langCode}->title) && $json->{$langCode}->title) $name = htmlspecialchars($json->{$langCode}->title, ENT_QUOTES);
                }
                $data[] = array( 'id' => $row['id'], 'name' => $name, 'image' => $row['image'], 'price' => $row['price'], 'is_discount' => $row['is_discount'],
                                'discount_amount' => $row['discount_amount'], 'duration' => $row['duration']);                
            }
            return json_encode( array($data) , JSON_UNESCAPED_UNICODE);
        }        
    }

    public static function getSpecNames($shopId, $ids){
        global $config;
        $sql = "SELECT cat_name AS name FROM {$config['db']['pre']}catagory_main WHERE cat_id IN({$ids})";        
        $rows = ORM::for_table($config['db']['pre'] . 'catagory_main')->raw_query($sql)->find_many();
        $names = '';
        if($rows){
            $names = array();
            foreach($rows as $row){
                $names[] = $row['name'];
            }
            return implode(", ", $names);
        }
        return $names;
    }

    public static function loadStaffsList($shopId, &$data, $getSpec = 1){
        global $config;
        $sql = "SELECT DISTINCT u.id, u.name, u.image, u.spec_ids FROM qr_user u WHERE u.shop_id={$shopId} AND !u.deleted ORDER BY u.id ASC";
        
        $rows = ORM::for_table($config['db']['pre'] . 'user')->raw_query($sql)->find_many();          
        $itemCount = count($rows);
        if(!$itemCount){
            return;
        }        
        $data = array(); $preId = -1;        
        $imgpath = __DIR__ . "/../../storage/profile/";
        foreach($rows as $row){
            $id = $row['id'];
            $data[$id]['id'] = $id;
            $data[$id]['name'] = $row['name'];

            if(!is_file($imgpath . $row['image'])){
                $data[$id]['image'] = 'default_user.png';
            }else{
                $data[$id]['image'] = $row['image'];
            }
            
            if($getSpec) $spec = self::getSpecNames($shopId, $row['spec_ids']);            
            $data[$id]['spec'] = $spec ? self::splitWords($spec, 64) : '<b style="color:#FFF;">N/A</b>';
        }
    }

    private function showStaff($row){
        $staffName = $row['id'] . '. ' . $row['name'];
        ?>
        <div class="col-lg-4 col-sm-6 col-xs-6" style="padding:2px 4px;">
            <label class="btn" style="display:table;width:100%;background:#f5f5f5;border:1px solid #ddd;">
                <input type="radio" name="staffs[]" value="<?php echo $row['id']?>" data-name="<?php echo $row['name']?>">
                <img src="./storage/profile/<?php echo $row['image']?>" style="width:40px;height:40px;border-radius:50%;vertical-align:middle;"/>
                <div style="display:table-cell;text-align:left;vertival-align:middle;width:70%;"><b><?php echo $staffName; ?></b></div>
            </label>
        </div>
        <?php
    }//showstaff

    public static function getAllFontSettings($shopId, $fontsDirUrl){
        global $config;
        $rows = ORM::forTable("{$config['db']['pre']}shop_options")->where('shop_id', $shopId)->where_like('option_name', '%font-options')->find_many();        
        /*$sql = "SELECT * FROM {$config['db']['pre']}shop_options WHERE shop_id={$shopId} AND option_name LIKE '%font-options'";
        echo $sql;
        $rows = ORM::forTable("")->rawQuery($sql)->find_many();*/
        $data = array('css'=>'', 'font-face'=>'');
        if(!$rows) return $data;

        
        $fontSrcNames = array();
        foreach($rows as $r){                
            $options = json_decode($r['option_value']);            
            $path = $fontsDirUrl . $options->{'font-path'};
            $src = $options->{'font-src'};
            $cssFontFace = '';
            if(!empty($path) && !empty($src) && !isset($fontSrcNames[$path])){
                $fontSrcNames[$path] = $src;
                $cssFontFace = self::buildCssFontSrc($path, $src);
            } 
            if(!$options->{'font-face'}) unset($options->{'font-face'});
            unset($options->{'font-path'});
            unset($options->{'font-src'});
            unset($options->{'option-desc'});
            
            //build css class            
            $data['css'] .= self::buildClassNameCss($r['option_name'], $options);            
            //build css font-face            
            if($cssFontFace && $options->{'font-face'}){
                $css = "@font-face{ font-family: " . $options->{'font-face'} . "; src: " . $cssFontFace . ";}";
                $data['font-face'] .= $css;
            }
        }        
        return $data;
    }

    private static function buildClassNameCss($className, &$opt){
        //"\r\n.{$r['option_name']}" . str_replace("\"", "", json_encode($options)) . "\n";
        if($className=="default-font-options") $css = "*{";
        elseif($className=="menu-font-options"){
            $css = ".{$className}--removed{";
        }else $css = ".{$className}{";
        $options = (array)$opt;
        
        foreach($options as $k => $v){
            if(empty($v)) continue;
            if($k=='font-face') $css .= "font-family:{$v} !important; ";
            elseif($k=='font-size') $css .= "{$k}:{$v}px  !important; ";
            else $css .= "{$k}:{$v}  !important; ";
        }
        return $css . "}";
    }
    private static function buildCssFontSrc($path, $srcList){        
        $files = explode(',', $srcList);
        $s = '';
        foreach($files as $f){
            $s .= "url(\"" . $path . "/" . $f . "\"),";
        }
        return trim($s, ',');
    }    
    
    public static function getCustomerCommonForm($formName, &$aparams = null){
        $file = 'login.html.php';
        switch($formName){
            case 'login':
                $file = 'login.form.html.php';
                break;
            case 'change-pwd':
                $file = 'change-pwd.form.html.php';
                break;
            case 'forgot-pwd':
                $file = 'forgot-pwd.form.html.php';
                break;
            case 'signup':
                $file = 'signup.form.html.php';
                break;
        }
        global $shop_template;
        $template = 'shop-templates/' . $shop_template . '/template-parts/forms/' . $file;
        ob_start();
        $page = new HtmlTemplate($template);
        $page->SetParameter('SHOP_TEMPLATE', $shop_template);
        if($aparams != null && is_array($aparams)){
            foreach($aparams as $param => $value){
                $page->SetParameter($param, $value);
            }
        }
        $page->CreatePageEcho();
        $s = ob_get_contents();
        ob_clean();
        ob_end_flush();
        return $s;
    }
    
}//CShopHelper
?>